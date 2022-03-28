<?php
namespace Jp\Skud\Sdl\Net\Http;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Jp\Skud\Sdl\Collection\Collection;
use Jp\Skud\Sdl\DateTime;
use Jp\Skud\Sdl\Text\StringUtil;
use Traversable;

/**
 * Httpヘダーを表現するクラス
 */
class HttpHeaders implements ArrayAccess, Countable, IteratorAggregate
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var Collection Httpヘダー */
    protected Collection $headers;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param iterable $headers
     */
    public function __construct(iterable $headers = [])
    {
        $this->headers = new Collection($headers);
    }




    /**
     * ヘダーが存在するか判定する。
     *
     * @param string $key
     * @return bool
     */
    public function containsKey(string $key) : bool
    {
        return $this->headers->containsKey($key);
    }




    /**
     * ヘダー値が存在するか判定する。
     *
     * @param string $value
     * @return bool
     */
    public function containsValue(string $value) : bool
    {
        return $this->headers->containsValue($value);
    }





    /**
     * 全てのヘダーを取得する。
     *
     * @return Collection
     */
    public function getHeaders() : Collection
    {
        return clone $this->headers;
    }




    /**
     * 任意のヘダー値を取得する。
     *
     * @param string $key
     * @return string
     */
    public function get(string $key) : string
    {
        return (string)$this->headers->get($key);
    }




    /**
     * 任意のヘダー値を取得する。
     *
     * @param string $key
     * @param mixed $default
     * @return string
     */
    public function tryGet(string $key, mixed $default = null) : string
    {
        return (string)$this->headers->tryGet($key, $default);
    }




    /**
     * 任意のヘダー値を文字列として取得する。
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    public function getAsString(string $key, string $default = '') : string
    {
        return $this->tryGet($key, $default);
    }




    /**
     * 任意のヘダー値を整数値として取得する。
     *
     * @param string $key
     * @param int $default
     * @return int
     */
    public function getAsInteger(string $key, int $default = 0) : int
    {
        return (int)$this->tryGet($key, $default);
    }




    /**
     * 任意のヘダー値を浮動小数点数型数値として取得する。
     *
     * @param string $key
     * @param float $default
     * @return float
     */
    public function getAsFloat(string $key, float $default = 0) : float
    {
        return (float)$this->tryGet($key, $default);
    }




    /**
     * 任意のヘダー値を論理値として取得する。
     *
     * @param string $key
     * @param bool $default
     * @return bool
     */
    public function getAsBool(string $key, bool $default = false) : bool
    {
        return (bool)$this->tryGet($key, $default);
    }




    /**
     * 任意のヘダー値を配列として取得する。
     *
     * @param string $key
     * @param array $default
     * @return array
     */
    public function getAsArray(string $key, array $default = []) : array
    {
        return (array)$this->tryGet($key, $default);
    }




    /**
     * 任意のヘダー値をDateTime値として取得する。
     *
     * @param string $key
     * @param DateTime|null $default
     * @return DateTime
     */
    public function getAsDateTime(string $key, ?DateTime $default = null) : DateTime
    {
        if($default === null)
        {
            $default = DateTime::now();
        }

        $value = $this->getAsString($key);

        if(StringUtil::isEmpty($value))
        {
            return $default;
        }

        return new DateTime($value);
    }




    /**
     * ヘダーを追加する。
     *
     * @param string $key
     * @param string $value
     * @return static
     */
    public function add(string $key, string $value) : static
    {
        $this->headers->add($value, $key);
        return $this;
    }




    /**
     * ヘダーを追加する。
     *
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function tryAdd(string $key, string $value) : bool
    {
        return $this->headers->tryAdd($value, $key);
    }




    /**
     * ヘダーを設定する。
     *
     * @param string $key
     * @param string $value
     * @return static
     */
    public function set(string $key, string $value) : static
    {
        $this->headers->setElement($key, $value);
        return $this;
    }




    /**
     * ヘダーを削除する。
     *
     * @param string $key
     * @return static
     */
    public function remove(string $key) : static
    {
        $this->headers->remove($key);
        return $this;
    }




    /**
     * ヘダーを削除する。
     *
     * @param string $key
     * @return bool
     */
    public function tryRemove(string $key) : bool
    {
        return $this->headers->tryRemove($key);
    }




    /**
     * ヘダーの集合を配列に変換する。
     *
     * @return string[]
     */
    public function toArray() : array
    {
        return $this->headers->toArray();
    }




    /**
     * @inheritdoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->headers->offsetExists($offset);
    }




    /**
     * @inheritdoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->headers->offsetGet($offset);
    }




    /**
     * @inheritdoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->headers->offsetSet($offset, $value);
    }




    /**
     * @inheritdoc
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->headers->offsetUnset($offset);
    }




    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return $this->headers->count();
    }




    /**
     * @inheritdoc
     */
    public function getIterator(): Traversable
    {
        return $this->headers->getIterator();
    }
}
