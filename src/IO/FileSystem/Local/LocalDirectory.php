<?php
namespace Jp\Skud\Sdl\IO\FileSystem\Local;

use DomainException;
use Jp\Skud\Sdl\Collection\Collection;
use Jp\Skud\Sdl\Collection\IReadonlyCollection;
use Jp\Skud\Sdl\IO\FileSystem\DirectoryNotFoundException;
use Jp\Skud\Sdl\IO\FileSystem\DuplicateDirectoryException;
use Jp\Skud\Sdl\IO\FileSystem\DuplicateFileException;
use Jp\Skud\Sdl\IO\FileSystem\DuplicateItemException;
use Jp\Skud\Sdl\IO\FileSystem\IDirectory;
use Jp\Skud\Sdl\IO\FileSystem\ItemNotFoundException;
use Jp\Skud\Sdl\IO\IOException;
use Jp\Skud\Sdl\Text\StringUtil;

/**
 * ローカルストレージのディレクトリに関する機能を提供するクラス
 */
class LocalDirectory implements IDirectory
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var string $location フォルダの絶対パス */
    protected string $location = '';






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param string $location
     *
     * @throws DomainException
     */
    public function __construct(string $location)
    {
        if(StringUtil::isEmpty($location))
        {
            throw new DomainException('ディレクトリパスが空文字列です。');
        }

        $this->location = StringUtil::trimEnd($location, ['/', '\\', DIRECTORY_SEPARATOR]);
    }




    /**
     * @inheritDoc
     */
    public function getLocation() : string
    {
        return $this->location;
    }




    /**
     * @inheritDoc
     */
    public function hasItem(string $location) : bool
    {
        $fixedLoc = $this->createFixedPath($location);
        return static::exists($fixedLoc) || LocalFile::exists($fixedLoc);
    }




    /**
     * @inheritDoc
     *
     * @param string $pattern
     *
     * @throws DomainException
     * @throws IOException
     */
    public function getItems(string $pattern = '/*') : IReadonlyCollection
    {
        if(StringUtil::isEmpty($pattern))
        {
            throw new DomainException('検索パターンが空文字列です。');
        }

        $items = new Collection();
        $itemNames = glob($this->createFixedPath($pattern));

        if($itemNames === false)
        {
            throw new IOException("検索処理[パターン:{$pattern}]の処理に失敗しました。");
        }

        foreach($itemNames as $itemName)
        {
            if(static::exists($itemName))
            {
                $items->add(static::open($itemName));
            }
            elseif(LocalFile::exists($itemName))
            {
                $items->add(LocalFile::open($itemName));
            }
        }

        return $items;
    }




    /**
     * @inheritDoc
     */
    public function hasDirectory(string $location) : bool
    {
        return static::exists($this->createFixedPath($location));
    }




    /**
     * @inheritDoc
     *
     * @param string $pattern
     *
     * @throws DomainException
     * @throws IOException
     */
    public function getDirectories($pattern = '/*') : IReadonlyCollection
    {
        if(StringUtil::isEmpty($pattern))
        {
            throw new DomainException('検索パターンが空文字列です。');
        }

        $directories = new Collection();
        $directoryNames = glob($this->createFixedPath($pattern), GLOB_ONLYDIR);

        if($directoryNames === false)
        {
            throw new IOException("検索処理[パターン:{$pattern}]の処理に失敗しました。");
        }

        foreach($directoryNames as $directoryName)
        {
            if(static::exists($directoryName))
            {
                $directories->add(static::open($directoryName));
            }
        }

        return $directories;
    }




    /**
     * @inheritDoc
     */
    public function tryOpenDirectory(string $location) : ?static
    {
        return static::tryOpen($this->createFixedPath($location));
    }




    /**
     * @inheritDoc
     */
    public function openDirectory(string $location) : static
    {
        return static::open($this->createFixedPath($location));
    }




    /**
     * @inheritDoc
     */
    public function createDirectory(string $location) : static
    {
        return static::create($this->createFixedPath($location));
    }




    /**
     * @inheritDoc
     */
    public function hasFile(string $location) : bool
    {
        return LocalFile::exists($this->createFixedPath($location));
    }




    /**
     * @inheritDoc
     *
     * @param string $pattern
     * @param string $streamMode
     *
     * @throws DomainException
     * @throws IOException
     */
    public function getFiles(string $pattern = '/*', string $streamMode = 'r+') : IReadonlyCollection
    {
        if(StringUtil::isEmpty($pattern))
        {
            throw new DomainException('検索パターンが空文字列です。');
        }

        $files = new Collection();
        $fileNames = glob($this->createFixedPath($pattern));

        if($fileNames === false)
        {
            throw new IOException("検索処理[パターン:{$pattern}]の処理に失敗しました。");
        }

        foreach($fileNames as $fileName)
        {
            if(LocalFile::exists($fileName))
            {
                $files->add(LocalFile::open($fileName, $streamMode));
            }
        }

        return $files;
    }




    /**
     * @inheritDoc
     *
     * @param string $streamMode
     * @return LocalFile|null
     */
    public function tryOpenFile(string $location, string $streamMode = 'r+') : ?LocalFile
    {
        return LocalFile::tryOpen($this->createFixedPath($location), $streamMode);
    }




    /**
     * @inheritDoc
     *
     * @param string $streamMode
     * @return LocalFile
     */
    public function openFile(string $location, string $streamMode = 'r+') : LocalFile
    {
        return LocalFile::open($this->createFixedPath($location), $streamMode);
    }




    /**
     * @inheritDoc
     *
     * @param string $streamMode
     * @return LocalFile
     */
    public function createFile(string $location, string $streamMode = 'r+') : LocalFile
    {
        return LocalFile::create($this->createFixedPath($location), $streamMode);
    }




    /**
     * @inheritDoc
     *
     * @throws DomainException
     * @throws DuplicateItemException
     * @throws ItemNotFoundException
     */
    public function rename(string $before, string $after) : static
    {
        if(StringUtil::isEmpty($before))
        {
            throw new DomainException('変更前パスが空文字列です。');
        }

        if(StringUtil::isEmpty($after))
        {
            throw new DomainException('変更後パスが空文字列です。');
        }

        // 変数初期化
        $beforeFixLoc = $this->createFixedPath($before);
        $afterFixLoc = $this->createFixedPath($after);


        // 検証
        if(!$this->hasItem($before))
        {
            throw new ItemNotFoundException("項目[{$before}]が存在しません。");
        }

        if($this->hasItem($after))
        {
            throw new DuplicateItemException("項目[{$after}]がすでに存在します。");
        }


        // 移動処理
        if(!rename($beforeFixLoc, $afterFixLoc))
        {
            throw new IOException("項目名称の変更[Before:{$before}][To:{$after}]に失敗しました。");
        }

        return $this;

    }




    /**
     * @inheritDoc
     *
     * @throws DomainException
     * @throws DuplicateItemException
     * @throws ItemNotFoundException
     */
    public function copy(string $from, string $to) : static
    {
        if(StringUtil::isEmpty($from))
        {
            throw new DomainException('コピー元パスが空文字列です。');
        }

        if(StringUtil::isEmpty($to))
        {
            throw new DomainException('コピー先パスが空文字列です。');
        }

        // 変数初期化
        $fromFixLoc = $this->createFixedPath($from);
        $toFixLoc = $this->createFixedPath($to);


        // 検証
        if(!$this->hasItem($from))
        {
            throw new ItemNotFoundException("項目[{$from}]が存在しません。");
        }

        if($this->hasItem($to))
        {
            throw new DuplicateItemException("項目[{$to}]がすでに存在します。");
        }


        // 移動処理
        if(!copy($fromFixLoc, $toFixLoc))
        {
            throw new IOException("項目の複製[Before:{$from}][To:{$to}]に失敗しました。");
        }

        return $this;
    }




    /**
     * @inheritDoc
     *
     * @throws DomainException
     * @throws ItemNotFoundException
     */
    public function delete(string $location) : static
    {
        if(StringUtil::isEmpty($location))
        {
            throw new DomainException('パスが空文字列です。');
        }

        // 変数初期化
        $fixLoc = $this->createFixedPath($location);

        // 検証
        if(!$this->hasItem($location))
        {
            throw new ItemNotFoundException("項目[{$fixLoc}]が存在しません。");
        }


        // 削除処理
        if($this->hasDirectory($location))
        {
            // ディレクトリの場合
            $fncRecursiveDeleteDirectoryItems = function(string $directory) use(&$fncRecursiveDeleteDirectoryItems) : void
            {
                $items = array_diff(scandir($directory), ['.','..']);
                foreach($items as $item)
                {
                    if(static::exists("{$directory}/{$item}"))
                    {
                        $fncRecursiveDeleteDirectoryItems("{$directory}/{$item}");
                    }
                    else
                    {
                        if(!unlink("{$directory}/{$item}"))
                        {
                            throw new IOException("ファイル[{{$directory}/{$item}}]の削除に失敗しました。");
                        }
                    }
                }

                if(!rmdir($directory))
                {
                    throw new IOException("ディレクトリ[{$directory}]の削除に失敗しました。");
                }
            };

            $fncRecursiveDeleteDirectoryItems($fixLoc);
        }
        else
        {
            // ファイルの場合
            if(!unlink($fixLoc))
            {
                throw new IOException("ファイル[{$fixLoc}]の削除に失敗しました。");
            }
        }


        return $this;
    }




    /**
     * 相対パスからインスタンス固有の絶対パスを作成する。
     *
     * @param string $relativeLocation
     * @return string
     */
    public function createFixedPath(string $relativeLocation) : string
    {
        $location = $this->getLocation().DIRECTORY_SEPARATOR;
        $location .= StringUtil::trimStart($relativeLocation, ['/', '\\', DIRECTORY_SEPARATOR]);

        return $location;
    }






    // ================================================================
    // 静的関数
    // ================================================================
    /**
     * @inheritDoc
     *
     * @throws DomainException
     */
    public static function exists(string $location) : bool
    {
        if(StringUtil::isEmpty($location))
        {
            throw new DomainException('ディレクトリパスが空文字列です。');
        }

        return (file_exists($location) && is_dir($location));
    }




    /**
     * @inheritDoc
     */
    public static function tryOpen(string $location) : ?static
    {
        if(!static::exists($location))
        {
            return null;
        }

        return new static($location);
    }




    /**
     * @inheritDoc
     *
     * @throws DirectoryNotFoundException
     */
    public static function open(string $location) : static
    {
        $directory = static::tryOpen($location);

        if($directory === null)
        {
            throw new DirectoryNotFoundException("ディレクトリ[$location]が存在しません。");
        }

        return $directory;
    }




    /**
     * @inheritDoc
     */
    public static function openOrCreate(string $location) : static
    {
        $directory = static::tryOpen($location);

        if($directory === null)
        {
            $directory = static::create($location);
        }

        return $directory;
    }




    /**
     * @inheritDoc
     *
     * @param int $permissions
     *
     * @throws DuplicateDirectoryException
     * @throws DuplicateFileException
     */
    public static function create(string $location, int $permissions = 0777) : static
    {
        // 検証
        if(static::exists($location))
        {
            throw new DuplicateDirectoryException("同名[{$location}]のディレクトリが存在します。");
        }

        if(LocalFile::exists($location))
        {
            throw new DuplicateFileException("同名[{$location}]のファイルが存在します。");
        }


        // ディレクトリの作成処理
        if(!mkdir($location, $permissions, true))
        {
            throw new IOException("ディレクトリ[{$location}]の作成に失敗しました。");
        }


        return new static($location);
    }
}
