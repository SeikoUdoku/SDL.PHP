<?php
namespace Jp\Skud\Sdl\Collection\Sdq;

use Countable;
use IteratorAggregate;
use Jp\Skud\Sdl\Collection\Collection;
use Jp\Skud\Sdl\Collection\ElementNotFoundException;
use Jp\Skud\Sdl\Collection\IArrayable;
use Jp\Skud\Sdl\Collection\IReadonlyCollection;
use Jp\Skud\Sdl\Collection\Sdq\Closure\Predicate;
use Jp\Skud\Sdl\Collection\Sdq\Closure\Selector;
use Traversable;

/**
 * コレクションに関する機能を提供するクラス
 */
class Sdq implements Countable, IArrayable, IteratorAggregate
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var IReadonlyCollection 操作対象のコレクション */
    protected IReadonlyCollection $collection;






    // ================================================================
    // 変数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param IReadonlyCollection|static $collection
     */
    public function __construct(IReadonlyCollection $collection)
    {
        $this->collection = $collection;
    }




    /**
     * 操作対象のコレクションを取得する。
     *
     * @return IReadonlyCollection
     */
    public function collection() : IReadonlyCollection
    {
        return $this->collection;
    }




    /**
     * 射影を取得する。
     *
     * @param callable|Selector $selector
     * @return static
     */
    public function select(callable|Selector $selector) : static
    {
        // 変数定義
        $collection = new Collection();
        if(!($selector instanceof Selector))
        {
            $selector = Selector::from($selector);
        }


        // 射影処理
        foreach($this->collection as $key => $value)
        {
            $collection[$key] = $selector->select($key, $value);
        }


        return new static($collection);
    }




    /**
     * 条件に合致する要素を取得する。
     *
     * @param callable|Predicate $predicate
     * @return static
     */
    public function where(callable|Predicate $predicate) : static
    {
        // 変数定義
        $collection = new Collection();
        if(!($predicate instanceof Predicate))
        {
            $predicate = Predicate::from($predicate);
        }


        // 比較処理
        foreach($this->collection as $key => $value)
        {
            if($predicate->predicating($key, $value))
            {
                $collection[$key] = $value;
            }
        }


        return new static($collection);
    }




    /**
     * 条件に合致する最初の要素を取得する。
     *
     * @param callable|Predicate|null $predicate
     * @return static
     *
     * @throws ElementNotFoundException
     */
    public function first(callable|Predicate|null $predicate = null) : mixed
    {
        if($predicate === null)
        {
            $predicate = Predicate::from(function() : bool { return true; });
        }

        // 変数定義
        if(!($predicate instanceof Predicate))
        {
            $predicate = Predicate::from($predicate);
        }


        // 比較処理
        foreach($this->collection as $key => $value)
        {
            if($predicate->predicating($key, $value))
            {
                return $value;
            }
        }


        throw new ElementNotFoundException('条件に合致する要素が存在しません。');
    }




    /**
     * 条件に合致する最初の要素を取得する。
     *
     * @param callable|Predicate|null $predicate
     * @param mixed $default
     * @return static
     */
    public function firstOrDefault(callable|Predicate|null $predicate = null, mixed $default = null) : mixed
    {
        if($predicate === null)
        {
            $predicate = Predicate::from(function() : bool { return true; });
        }

        // 変数定義
        if(!($predicate instanceof Predicate))
        {
            $predicate = Predicate::from($predicate);
        }


        // 比較処理
        foreach($this->collection as $key => $value)
        {
            if($predicate->predicating($key, $value))
            {
                return $value;
            }
        }


        return $default;
    }




    /**
     * 条件に合致する最後の要素を取得する。
     *
     * @param callable|Predicate|null $predicate
     * @return static
     *
     * @throws ElementNotFoundException
     */
    public function last(callable|Predicate|null $predicate = null) : mixed
    {
        if($predicate === null)
        {
            $predicate = Predicate::from(function() : bool { return true; });
        }

        // 変数定義
        if(!($predicate instanceof Predicate))
        {
            $predicate = Predicate::from($predicate);
        }


        // 比較処理
        $founded = false;
        $foundedValue = null;
        foreach($this->collection as $key => $value)
        {
            if($predicate->predicating($key, $value))
            {
                $founded = true;
                $foundedValue = $value;
            }
        }


        if($founded)
        {
            return $foundedValue;
        }

        throw new ElementNotFoundException('条件に合致する要素が存在しません。');
    }




    /**
     * 条件に合致する最後の要素を取得する。
     *
     * @param callable|Predicate|null $predicate
     * @param mixed $default
     * @return static
     */
    public function lastOrDefault(callable|Predicate|null $predicate = null, mixed $default = null) : mixed
    {
        if($predicate === null)
        {
            $predicate = Predicate::from(function() : bool { return true; });
        }

        // 変数定義
        if(!($predicate instanceof Predicate))
        {
            $predicate = Predicate::from($predicate);
        }


        // 比較処理
        $founded = false;
        $foundedValue = null;
        foreach($this->collection as $key => $value)
        {
            if($predicate->predicating($key, $value))
            {
                $founded = true;
                $foundedValue = $value;
            }
        }


        if($founded)
        {
            return $foundedValue;
        }

        return $default;
    }




    /**
     * 条件に合致する要素が存在するか判定する。
     *
     * @param callable|Predicate|null $predicate
     * @return bool
     */
    public function any(callable|Predicate|null $predicate = null) : bool
    {
        if($predicate === null)
        {
            return ($this->count() > 0);
        }


        // 変数定義
        if(!($predicate instanceof Predicate))
        {
            $predicate = Predicate::from($predicate);
        }


        // 比較処理
        foreach($this->collection as $key => $value)
        {
            if($predicate->predicating($key, $value))
            {
                return true;
            }
        }


        return false;
    }




    /**
     * 条件に合致する要素の数を取得する。
     *
     * @param callable|Predicate|null $predicate
     * @return int
     */
    public function count(callable|Predicate|null $predicate = null) : int
    {
        if($predicate === null)
        {
            return $this->collection->count();
        }


        // 変数定義
        if(!($predicate instanceof Predicate))
        {
            $predicate = Predicate::from($predicate);
        }


        // 比較処理
        $cnt = 0;
        foreach($this->collection as $key => $value)
        {
            if($predicate->predicating($key, $value))
            {
                ++$cnt;
            }
        }


        return $cnt;
    }




    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return $this->collection->getIterator();
    }




    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return (array)$this->collection->getIterator();
    }






    // ================================================================
    // 静的関数
    // ================================================================
    /**
     * オブジェクトを作成する。
     *
     * @param IReadonlyCollection|iterable $collection
     * @return static
     */
    public static function from(IReadonlyCollection|iterable $collection) : static
    {
        if(!($collection instanceof IReadonlyCollection))
        {
            $collection = Collection::from($collection);
        }

        return new static($collection);
    }
}
