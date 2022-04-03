<?php
namespace Jp\Skud\Sdl\Net\Web;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Jp\Skud\Sdl\Collection\Collection;
use Jp\Skud\Sdl\Collection\IArrayable;
use Jp\Skud\Sdl\DateTime;
use Jp\Skud\Sdl\Text\StringUtil;
use Traversable;

/**
 * セッションを表現するクラス
 */
class Session implements ArrayAccess, Countable, IArrayable, IteratorAggregate
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var Collection セッションデータ */
    protected Collection $session;

    /** @var string セッションId */
    protected string $sessionId;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param string $sessionId
     * @param iterable $session
     */
    public function __construct(string $sessionId, iterable $session = [])
    {
        $this->sessionId = $sessionId;
        $this->session = new Collection($session);
    }




    /**
     * キーがセッション中に存在するか判定する。
     *
     * @param string $key
     * @return bool
     */
    public function containsKey(string $key) : bool
    {
        return $this->session->containsKey($key);
    }




    /**
     * 値がセッション中に存在するか判定する。
     *
     * @param mixed $value
     * @return bool
     */
    public function containsValue(mixed $value) : bool
    {
        return $this->session->containsValue($value);
    }




    /**
     * 任意のセッション値を取得する。
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key) : mixed
    {
        return $this->session->get($key);
    }




    /**
     * 任意のセッション値を取得する。
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function tryGet(string $key, mixed $default = null) : mixed
    {
        return $this->session->tryGet($key, $default);
    }




    /**
     * 任意のセッション値を文字列として取得する。
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    public function getAsString(string $key, string $default = '') : string
    {
        return (string)$this->tryGet($key, $default);
    }




    /**
     * 任意のセッション値を整数値として取得する。
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
     * 任意のセッション値を浮動小数点数型数値として取得する。
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
     * 任意のセッション値を論理値として取得する。
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
     * 任意のセッション値を配列として取得する。
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
     * 任意のセッション値をDateTime値として取得する。
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
     * 任意のセッション値を設定する。
     *
     * @param string $key
     * @param mixed $value
     * @return static
     */
    public function setElement(string $key, mixed $value) : static
    {
        $this->session->setElement($key, $value);
        return $this;
    }




    /**
     * セッション値を追加する。
     *
     * @param string $key
     * @param mixed $value
     * @return static
     */
    public function add(string $key, mixed $value) : static
    {
        $this->session->add($value, $key);
        return $this;
    }




    /**
     * セッション値を追加する。
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function tryAdd(string $key, mixed $value) : bool
    {
        return $this->session->tryAdd($value, $key);
    }




    /**
     * セッション値を設定する。
     *
     * @param string $key
     * @param mixed $value
     * @return static
     */
    public function update(string $key, mixed $value) : static
    {
        $this->session->update($key, $value);
        return $this;
    }




    /**
     * セッション値を設定する。
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function tryUpdate(string $key, mixed $value) : bool
    {
        return $this->session->tryUpdate($key, $value);
    }




    /**
     * セッション値を削除する。
     *
     * @param string $key
     * @return static
     */
    public function remove(string $key) : static
    {
        $this->session->remove($key);
        return $this;
    }




    /**
     * セッション値を削除する。
     *
     * @param string $key
     * @return bool
     */
    public function tryRemove(string $key) : bool
    {
        return $this->session->tryRemove($key);
    }




    /**
     * セッション値を全て削除する。
     *
     * @return static
     */
    public function clear() : static
    {
        $this->session->clear();
        return $this;
    }




    /**
     * セッションIdを取得する。
     *
     * @return string
     */
    public function getSessionId() : string
    {
        return $this->sessionId;
    }




    /**
     * セッションIdを設定する。
     *
     * @param string $sessionId
     * @return static
     */
    public function setSessionId (string $sessionId) : static
    {
        $this->sessionId = $sessionId;
        return $this;
    }




    /**
     * 現在の接続で有効なセッションに保存して永続化する。
     *
     * @throws WebComponentException
     */
    public function save() : void
    {
        if(session_status() !== PHP_SESSION_ACTIVE)
        {
            throw new WebComponentException('セッションが開始されていません。');
        }

        $_SESSION = (array)$this->session->getIterator();
    }




    /**
     * @inheritDoc
     */
    public function toArray() : array
    {
        return $this->session->toArray();
    }




    /**
     * @inheritdoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->session->offsetExists($offset);
    }




    /**
     * @inheritdoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->session->offsetGet($offset);
    }




    /**
     * @inheritdoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->session->offsetSet($offset, $value);
    }




    /**
     * @inheritdoc
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->session->offsetUnset($offset);
    }




    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return $this->session->count();
    }




    /**
     * @inheritdoc
     */
    public function getIterator(): Traversable
    {
        return $this->session->getIterator();
    }






    // ================================================================
    // 静的関数
    // ================================================================
    /**
     * 現在の接続で有効なセッションIdを取得する。
     *
     * @return string
     *
     * @throws WebComponentException
     */
    public static function id() : string
    {
        if(session_status() !== PHP_SESSION_ACTIVE)
        {
            throw new WebComponentException('セッションが開始されていません。');
        }

        $id = session_id();

        if($id === false)
        {
            throw new WebComponentException('セッションIdの取得に失敗しました。');
        }

        return $id;
    }




    /**
     * セッションの状態を取得する。
     *
     * @return int
     */
    public static function status() : int
    {
        return session_status();
    }




    /**
     * セッションを開始する。
     *
     * @return static
     *
     * @throws WebComponentException
     */
    public static function start() : static
    {
        if(session_status() === PHP_SESSION_ACTIVE)
        {
            throw new WebComponentException('セッションは既に開始されています。');
        }

        if(!session_start())
        {
            throw new WebComponentException('セッションの開始に失敗しました。');
        }

        return new static(session_id(), $_SESSION);
    }
}
