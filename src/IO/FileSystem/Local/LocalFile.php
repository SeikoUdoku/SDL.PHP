<?php
namespace Jp\Skud\Sdl\IO\FileSystem\Local;

use DomainException;
use finfo;
use Jp\Skud\Sdl\IO\FileSystem\DuplicateDirectoryException;
use Jp\Skud\Sdl\IO\FileSystem\DuplicateFileException;
use Jp\Skud\Sdl\IO\FileSystem\FileNotFoundException;
use Jp\Skud\Sdl\IO\FileSystem\IFile;
use Jp\Skud\Sdl\IO\IOException;
use Jp\Skud\Sdl\IO\MimeType;
use Jp\Skud\Sdl\IO\Stream;
use Jp\Skud\Sdl\Text\StringUtil;

/**
 * ローカルストレージのファイルに関する機能を提供するクラス
 */
class LocalFile implements IFile
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var string $location ファイルの絶対パス */
    protected string $location = '';

    /** @var Stream $stream ストリーム */
    protected Stream $stream;






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
    public function __construct(string $location, string $streamMode = 'r+')
    {
        if(StringUtil::isEmpty($location))
        {
            throw new DomainException('ファイルパスが空文字列です。');
        }

        $this->location = $location;
        $this->stream = new Stream($location, $streamMode);
    }




    /**
     * @inheritDoc
     */
    public function getPath() : string
    {
        return $this->location;
    }




    /**
     * @inheritDoc
     *
     * @return LocalDirectory
     */
    public function directory() : LocalDirectory
    {
        $dirname = pathinfo($this->location, PATHINFO_DIRNAME);
        return LocalDirectory::open($dirname);
    }




    /**
     * @inheritDoc
     */
    public function getBaseName() : string
    {
        return pathinfo($this->location, PATHINFO_BASENAME);
    }




    /**
     * @inheritDoc
     */
    public function getName() : string
    {
        return pathinfo($this->location, PATHINFO_FILENAME);
    }




    /**
     * @inheritDoc
     */
    public function getExtension() : string
    {
        return pathinfo($this->location, PATHINFO_EXTENSION);
    }




    /**
     * @inheritDoc
     */
    public function getSize() : int
    {
        $size = filesize($this->location);

        if($size === false)
        {
            throw new IOException("ファイル[{$this->location}]の容量取得に失敗しました。");
        }

        return $size;
    }




    /**
     * @inheritDoc
     */
    public function mimeType() : MimeType
    {
        $fileInfo = new finfo();
        return new MimeType($fileInfo->file($this->location, FILEINFO_MIME_TYPE));
    }




    /**
     * @inheritDoc
     *
     * @return Stream
     */
    public function stream() : Stream
    {
        return $this->stream;
    }




    /**
     * @inheritDoc
     */
    public function read() : string
    {
        return $this->stream->readAll();
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
            throw new DomainException('ファイルパスが空文字列です。');
        }

        return (file_exists($location) && is_file($location));
    }




    /**
     * @inheritDoc
     *
     * @param string $streamMode
     */
    public static function tryOpen(string $location, string $streamMode = 'r+') : static
    {
        if(!static::exists($location))
        {
            return null;
        }

        return new static($location, $streamMode);
    }




    /**
     * @inheritDoc
     *
     * @param string $streamMode
     *
     * @throws FileNotFoundException
     */
    public static function open(string $location, string $streamMode = 'r+') : static
    {
        $file = static::tryOpen($location, $streamMode);

        if($file === null)
        {
            throw new FileNotFoundException("ファイル[$location]が存在しません。");
        }

        return $file;
    }




    /**
     * @inheritDoc
     *
     * @param string $streamMode
     */
    public static function openOrCreate(string $location, string $streamMode = 'r+') : static
    {
        $file = static::tryOpen($location, $streamMode);

        if($file === null)
        {
            $file = static::create($location, $streamMode);
        }

        return $file;
    }




    /**
     * @inheritDoc
     *
     * @param string $streamMode
     *
     * @throws DuplicateDirectoryException
     * @throws DuplicateFileException
     */
    public static function create(string $location, string $streamMode = 'r+') : static
    {
        // 検証
        if(LocalDirectory::exists($location))
        {
            throw new DuplicateDirectoryException("同名[{$location}]のディレクトリが存在します。");
        }

        if(static::exists($location))
        {
            throw new DuplicateFileException("同名[{$location}]のファイルが存在します。");
        }


        // ディレクトリの存否判定・作成処理
        $dirname = pathinfo($location, PATHINFO_DIRNAME);
        if(!LocalDirectory::exists($dirname))
        {
            LocalDirectory::create($dirname);
        }


        // ファイルの作成処理
        if(!file_put_contents($location, '', LOCK_EX))
        {
            throw new IOException("ファイル[{$location}]の作成に失敗しました。");
        }


        return new static($location, $streamMode);
    }
}
