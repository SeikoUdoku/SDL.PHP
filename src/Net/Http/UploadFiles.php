<?php
namespace Jp\Skud\Sdl\Net\Http;

use ArrayAccess;
use Countable;
use DomainException;
use InvalidArgumentException;
use IteratorAggregate;
use Jp\Skud\Sdl\Collection\Collection;
use Jp\Skud\Sdl\Collection\IArrayable;
use Jp\Skud\Sdl\Text\StringUtil;
use Traversable;

/**
 * アップロードされたファイルの集合を表現するクラス
 */
class UploadFiles implements ArrayAccess, Countable, IArrayable, IteratorAggregate
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var Collection|(UploadFile|UploadFile[])[] アップロードファイル名 */
    protected Collection $files;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param iterable|(UploadFile|UploadFile[])[] $elms
     */
    public function __construct(iterable $elms = [])
    {
        $files = new Collection();
        /**
         * @param iterable|(UploadFile|UploadFile[])[] $elms
         * @param Collection|(UploadFile|UploadFile[])[] $parent
         */
        $fncInitialize = function(iterable $elms, Collection $parent) use(&$fncInitialize) : void
        {
            foreach($elms as $elmKey => $elm)
            {
                if(is_iterable($elmKey))
                {
                    $parent[$elmKey] = new Collection();
                    $fncInitialize($elm, $parent[$elmKey]);
                }

                if(!($elm instanceof UploadFile))
                {
                    throw new InvalidArgumentException('引数にUploadFileオブジェクトでない値が含まれています。');
                }

                $parent->add($elm, $elmKey);
            }
        };

        $fncInitialize($elms, $files);
        $this->files = $files;
    }




    /**
     * ファイルが存在するか判定する。
     *
     * @param string $key
     * @return bool
     */
    public function containsKey(string $key) : bool
    {
        return $this->files->containsKey($key);
    }




    /**
     * ファイルを取得する。
     *
     * @param string $key
     * @return UploadFile|Collection|(UploadFile|UploadFile[])[]|null
     */
    public function get(string $key) : UploadFile|Collection|null
    {
        return $this->files->get($key);
    }




    /**
     * ファイルを取得する。
     *
     * @param string $key
     * @return UploadFile|Collection|(UploadFile|UploadFile[])[]|null
     */
    public function tryGet(string $key) : UploadFile|Collection|null
    {
        return $this->files->tryGet($key, null);
    }




    /**
     * ファイルを設定する。
     *
     * @param string $key
     * @param UploadFile $value
     * @return static
     *
     * @throws DomainException
     */
    public function setElement(string $key, UploadFile $value) : static
    {
        if(StringUtil::isEmpty($key))
        {
            throw new DomainException('キーを空文字とすることはできません。');
        }

        $this->files->setElement($key, $value);
        return $this;
    }




    /**
     * ファイルを追加する。
     *
     * @param string $key
     * @param UploadFile $value
     * @return static
     *
     * @throws DomainException
     */
    public function add(string $key, UploadFile $value) : static
    {
        if(StringUtil::isEmpty($key))
        {
            throw new DomainException('キーを空文字とすることはできません。');
        }

        $this->files->add($value, $key);
        return $this;
    }




    /**
     * ファイルを追加する。
     *
     * @param string $key
     * @param UploadFile $value
     * @return static
     *
     * @throws DomainException
     */
    public function tryAdd(string $key, UploadFile $value) : static
    {
        if(StringUtil::isEmpty($key))
        {
            throw new DomainException('キーを空文字とすることはできません。');
        }

        $this->files->tryAdd($value, $key);
        return $this;
    }




    /**
     * ファイルを更新する。
     *
     * @param string $key
     * @param UploadFile $value
     * @return static
     *
     * @throws DomainException
     */
    public function update(string $key, UploadFile $value) : static
    {
        if(StringUtil::isEmpty($key))
        {
            throw new DomainException('キーを空文字とすることはできません。');
        }

        $this->files->update($key, $value);
        return $this;
    }




    /**
     * ファイルを更新する。
     *
     * @param string $key
     * @param UploadFile $value
     * @return static
     *
     * @throws DomainException
     */
    public function tryUpdate(string $key, UploadFile $value) : static
    {
        if(StringUtil::isEmpty($key))
        {
            throw new DomainException('キーを空文字とすることはできません。');
        }

        $this->files->tryUpdate($key, $value);
        return $this;
    }




    /**
     * ファイルを削除する。
     *
     * @param string $key
     * @return static
     */
    public function remove(string $key) : static
    {
        $this->files->remove($key);
        return $this;
    }




    /**
     * ファイルを削除する。
     *
     * @param string $key
     * @return static
     */
    public function tryRemove(string $key) : static
    {
        $this->files->tryRemove($key);
        return $this;
    }




    /**
     * ファイルをすべて削除する。
     *
     * @return static
     */
    public function clear() : static
    {
        $this->files->clear();
        return $this;
    }




    /**
     * @inheritDoc
     */
    public function toArray() : array
    {
        return $this->files->toArray();
    }



    /**
     * @inheritdoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->files->offsetExists($offset);
    }




    /**
     * @inheritdoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->files->offsetGet($offset);
    }




    /**
     * @inheritdoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->files->offsetSet($offset, $value);
    }




    /**
     * @inheritdoc
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->files->offsetUnset($offset);
    }




    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return $this->files->count();
    }




    /**
     * @inheritdoc
     */
    public function getIterator(): Traversable
    {
        return $this->files->getIterator();
    }
}
