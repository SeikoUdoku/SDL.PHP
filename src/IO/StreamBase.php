<?php
namespace Jp\Skud\Sdl\IO;

/**
 * ストリームに関する機能を提供する抽象クラス
 */
abstract class StreamBase implements IStream
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var string $location 操作対象リソース */
    public readonly string $location;

    /** @var string $operationMode 動作モード */
    public readonly string $operationMode;

    /** @var resource $resource 操作対象リソース */
    public readonly mixed $resource;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param string $location
     * @param string $mode
     *
     * @throws IOException
     */
    public function __construct(string $location, string $mode)
    {
        $this->location = $location;
        $this->operationMode = $mode;


        $resource = fopen($location, $mode);

        if($resource === false)
        {
            throw new IOException("リソース[{$this->location}]のストリーム取得に失敗しました。");
        }

        $this->resource = $resource;
    }




    /**
     * デストラクタ
     */
    public function __destruct()
    {
        $this->close();
    }




    /**
     * @inheritDoc
     *
     * @throws IOException
     */
    public function close() : void
    {
        $this->flush();
        $this->unlock();

        if(!fclose($this->resource))
        {
            throw new IOException("リソース[{$this->location}]の開放に失敗しました。");
        }
    }




    /**
     * @inheritDoc
     *
     * @throws IOException
     */
    public function lock(LockMode $mode, array $modeModifications = []) : static
    {
        $operator = $mode->toOperator();
        foreach($modeModifications as $modeModification)
        {
            /** @var LockModeModification $modeModification */
            $operator |= $modeModification->toOperator();
        }

        if(!flock($this->resource, $operator))
        {
            throw new IOException("リソース[{$this->location}]のロック取得に失敗しました。");
        }

        return $this;
    }




    /**
     * @inheritDoc
     *
     * @throws IOException
     */
    public function unlock() : static
    {
        if(!flock($this->resource, LOCK_UN))
        {
            throw new IOException("リソース[{$this->location}]のロック開放に失敗しました。");
        }

        return $this;
    }




    /**
     * @inheritDoc
     *
     * @throws IOException
     */
    public function read(int $length) : string
    {
        $result = fread($this->resource, $length);

        if($result === false)
        {
            throw new IOException("リソース[{$this->location}]の読込に失敗しました。");
        }

        return $result;
    }




    /**
     * ストリームの全体を読み込む
     *
     * @param int $chunkBytes
     * @return string
     */
    public function readAll(int $chunkBytes = 4096) : string
    {
        $content = '';

        while(!$this->eof())
        {
            $content .= $this->read($chunkBytes);
        }

        return $content;
    }




    /**
     * @inheritDoc
     */
    public function eof() : bool
    {
        return feof($this->resource);
    }




    /**
     * @inheritDoc
     *
     * @throws IOException
     */
    public function seek(int $offset, int $operator = SEEK_SET) : static
    {
        if(fseek($this->resource, $offset, $operator) === -1)
        {
            throw new IOException("指定ポインタ位置[{$offset}:{$operator}]への移動に失敗しました。\n対象リソース[{$this->location}]");
        }

        return $this;
    }




    /**
     * @inheritDoc
     *
     * @throws IOException
     */
    public function tell() : int
    {
        $result = ftell($this->resource);

        if($result === false)
        {
            throw new IOException("ポインタ位置の取得に失敗しました。\n対象リソース[{$this->location}]");
        }

        return $result;
    }




    /**
     * @inheritDoc
     *
     * @throws IOException
     */
    public function truncate(int $size) : static
    {
        if(!ftruncate($this->resource, $size))
        {
            throw new IOException("リソースの丸め処理[Size:{$size}]に失敗しました。\n対象リソース[{$this->location}]");
        }

        return $this;
    }




    /**
     * @inheritDoc
     *
     * @throws IOException
     */
    public function rewind() : static
    {
        if(!rewind($this->resource))
        {
            throw new IOException("ポインタ位置の移動に失敗しました。\n対象リソース[{$this->location}]");
        }

        return $this;
    }




    /**
     * @inheritDoc
     *
     * @param string $content
     * @param int|null $bytes
     * @param int $writtenBytes
     * @return static
     */
    public function write(string $content, ?int $bytes = null, int &$writtenBytes = 0) : static
    {
        $result = fwrite($this->resource, $content, $bytes);

        if($result === false)
        {
            throw new IOException("ポインタ位置の取得に失敗しました。\n対象リソース[{$this->location}]");
        }

        $writtenBytes = $result;
        return $this;
    }




    /**
     * @inheritDoc
     *
     * @throws IOException
     */
    public function flush() : static
    {
        if(!fflush($this->resource))
        {
            throw new IOException("バッファ内容のクリアに失敗しました。 \n対象リソース[{$this->location}]");
        }

        return $this;
    }






    // ================================================================
    // 静的関数
    // ================================================================
    /**
     * @inheritDoc
     */
    public static function open(string $location, string $mode) : static
    {
        return new static($location, $mode);
    }
}
