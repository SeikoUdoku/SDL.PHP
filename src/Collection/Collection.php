<?php
namespace Jp\Skud\Sdl\Collection;

use ArrayAccess;
use ArrayIterator;
use InvalidArgumentException;
use Jp\Skud\Sdl\NotSupportedException;
use Traversable;

/**
 * コレクションに関する機能を提供するクラス
 */
class Collection implements ArrayAccess, IArrayable, ICollection, IReadonlyCollection
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var iterable コレクション */
    protected iterable $elms = [];






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param iterable $elms
     */
    public function __construct(iterable $elms = [])
    {
        $this->elms = $elms;
    }




    /**
     * @inheritDoc
     */
    public function tryGet(int|string $key, mixed $default = null) : mixed
    {
        if(!$this->containsKey($key))
        {
            return $default;
        }

        return $this->elms[$key];
    }




    /**
     * @inheritDoc
     *
     * @throws ElementNotFoundException
     */
    public function get(int|string $key) : mixed
    {
        if(!$this->containsKey($key))
        {
            throw new ElementNotFoundException("Key[{$key}] is not found in collection.");
        }

        return $this->elms[$key];
    }




    /**
     * @inheritDoc
     */
    public function tryAdd(mixed $value, int|string|null $key = null) : bool
    {
        if($key !== null)
        {
            if($this->containsKey($key))
            {
                return false;
            }

            $this->elms[$key] = $value;
        }
        else
        {
            $this->elms[] = $value;
        }


        return true;
    }




    /**
     * @inheritDoc
     *
     * @throws DuplicateElementException
     */
    public function add(mixed $value, int|string|null $key = null) : static
    {
        if($key !== null)
        {
            if($this->containsKey($key))
            {
                throw new DuplicateElementException("Duplicate key[{$key}] in collection.");
            }

            $this->elms[$key] = $value;
        }
        else
        {
            $this->elms[] = $value;
        }


        return $this;
    }




    /**
     * @inheritDoc
     */
    public function tryUpdate(int|string $key, mixed $value) : bool
    {
        if(!$this->containsKey($key))
        {
            return false;
        }

        $this->elms[$key] = $value;

        return true;
    }




    /**
     * @inheritDoc
     *
     * @throws ElementNotFoundException
     */
    public function update(int|string $key, mixed $value) : static
    {
        if(!$this->containsKey($key))
        {
            throw new ElementNotFoundException("Key[{$key}] is not found in collection.");
        }

        $this->elms[$key] = $value;

        return $this;
    }




    /**
     * @inheritDoc
     */
    public function setElement(int|string $key, mixed $value) : static
    {
        $this->elms[$key] = $value;
        return $this;
    }




    /**
     * @inheritDoc
     */
    public function tryRemove(int|string $key) : bool
    {
        if(!$this->containsKey($key))
        {
            return false;
        }

        unset($this->elms[$key]);

        return true;
    }




    /**
     * @inheritDoc
     *
     * @throws ElementNotFoundException
     */
    public function remove(int|string $key) : static
    {
        if(!$this->containsKey($key))
        {
            throw new ElementNotFoundException("Key[{$key}] is not found in collection.");
        }

        unset($this->elms[$key]);

        return $this;
    }




    /**
     * @inheritDoc
     */
    public function clear() : static
    {
        $this->elms = [];

        return $this;
    }




    /**
     * @inheritDoc
     */
    public function containsKey(int|string $key) : bool
    {
        return key_exists($key, (array)$this->elms);
    }




    /**
     * @inheritDoc
     */
    public function containsValue(mixed $value) : bool
    {
        return in_array($value, (array)$this->elms, true);
    }




    /**
     * @inheritDoc
     */
    public function count() : int
    {
        if(!is_countable($this->elms))
        {
            throw new NotSupportedException('This collection is not supported for count.');
        }

        return count($this->elms);
    }




    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elms);
    }




    /**
     * @inheritDoc
     */
    public function offsetGet(mixed $offset) : mixed
    {
        if(!$this->isExpectedKeyType($offset))
        {
            throw new InvalidArgumentException('キーの型['.gettype($offset).']が不正です。');
        }

        return $this->tryGet($offset, null);
    }




    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value) : void
    {
        if($offset !== null)
        {
            if(!$this->isExpectedKeyType($offset))
            {
                throw new InvalidArgumentException('キーの型['.gettype($offset).']が不正です。');
            }

            $this->setElement($offset, $value);
        }
        else
        {
            $this->add($value);
        }
    }




    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset) : void
    {
        if(!$this->isExpectedKeyType($offset))
        {
            throw new InvalidArgumentException('キーの型['.gettype($offset).']が不正です。');
        }

        $_ = $this->tryRemove($offset);
    }




    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $offset) : bool
    {
        if(!$this->isExpectedKeyType($offset))
        {
            throw new InvalidArgumentException('キーの型['.gettype($offset).']が不正です。');
        }

        return $this->containsKey($offset);
    }




    /**
     * @inheritDoc
     */
    public function toArray() : array
    {
        return (array)$this->elms;
    }




    /**
     * 読み取り専用のコレクションを取得する。
     *
     * @return IReadonlyCollection
     */
    public function getReadonlyCollection() : IReadonlyCollection
    {
        return $this;
    }




    /**
     * キーのコレクションを取得する。
     *
     * @return static
     */
    public function keys() : static
    {
        return static::from(array_keys((array)$this->elms));
    }




    /**
     * 要素のコレクションを取得する。
     *
     * @return static
     */
    public function values() : static
    {
        return static::from(array_values((array)$this->elms));
    }




    /**
     * キーとして想定される型であるか判定する。
     *
     * @param mixed $key
     * @return bool
     */
    protected function isExpectedKeyType(mixed $key) : bool
    {
        return (is_string($key) || is_int($key));
    }






    // ================================================================
    // 静的関数
    // ================================================================
    /**
     * オブジェクトを作成する。
     *
     * @param iterable $elms
     * @return static
     */
    public static function from(iterable $elms) : static
    {
        return new static($elms);
    }
}
