<?php
namespace Jp\Skud\Sdl\Net\Web;

use Jp\Skud\Sdl\Collection\Collection;
use Jp\Skud\Sdl\DateTime;
use Jp\Skud\Sdl\Text\StringUtil;

/**
 * クッキーに関する操作を提供するユーティリティクラス
 */
class Cookie
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var Collection クッキー */
    protected Collection $cookies;

    /** @var array[] 設定キュー */
    protected array $setQue = [];

    /** @var string[] 削除キュー */
    protected array $unsetQue = [];

    /** @var string 既定パス */
    protected string $defaultPath = '';

    /** @var string 既定ドメイン */
    protected string $defaultDomain = '';

    /** @var bool 既定Https制限フラグ */
    protected bool $defaultIsSecure = true;

    /** @var bool 既定Http通信限定フラグ */
    protected bool $defaultIsHttpOnly = true;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param iterable $cookies
     */
    public function __construct(iterable $cookies = [])
    {
        $this->cookies = new Collection($cookies);
    }




    /**
     * キーがクッキー中に存在するか判定する。
     *
     * @param string $key
     * @return bool
     */
    public function containsKey(string $key) : bool
    {
        return $this->cookies->containsKey($key);
    }




    /**
     * クッキーの値を取得する。
     *
     * @param string $key
     * @return string
     */
    public function get(string $key) : string
    {
        return (string)$this->cookies->get($key);
    }




    /**
     * クッキーの値を取得する。
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function tryGet(string $key, mixed $default = null) : mixed
    {
        return $this->cookies->tryGet($key, $default);
    }




    /**
     * 任意のクッキーの値を文字列として取得する。
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
     * 任意のクッキーの値を整数値として取得する。
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
     * 任意のクッキーの値を浮動小数点数型数値として取得する。
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
     * 任意のクッキーの値を論理値として取得する。
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
     * 任意のクッキーの値を配列として取得する。
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
     * 任意のクッキーの値をDateTime値として取得する。
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
     * クッキーを設定する。
     *
     * @param string $key
     * @param string $value
     * @param DateTime|null $expiredAt
     * @param string $path
     * @param string $domain
     * @param bool $isSecure
     * @param bool $isHttpOnly
     * @return static
     */
    public function set(
        string $key
      , string $value
      , ?DateTime $expiredAt = null
      , string $path = $this->getDefaultPath()
      , string $domain = $this->getDefaultDomain()
      , bool $isSecure = $this->getDefaultIsSecure()
      , bool $isHttpOnly = $this->getDefaultIsHttpOnly()
    ) : static
    {
        $timeStamp = 0;
        if($expiredAt !== null)
        {
            $timeStamp = $expiredAt->getTimestamp();
        }

        $this->setQue[$key] = [
            $key
          , $value
          , $timeStamp
          , $path
          , $domain
          , $isSecure
          , $isHttpOnly
        ];

        if(isset($this->unsetQue[$key]))
        {
            unset($this->unsetQue[$key]);
        }

        $this->cookies->setElement($key, $value);

        return $this;
    }




    /**
     * クッキーを削除する。
     *
     * @param string $key
     * @return static
     */
    public function unset(string $key) : static
    {
        if(!in_array($key, $this->unsetQue, true))
        {
            $this->unsetQue[] = $key;
            $this->cookies->tryRemove($key);
        }

        if(isset($this->setQue[$key]))
        {
            unset($this->setQue[$key]);
        }

        return $this;
    }




    /**
     * クッキーを保存する。
     *
     * @return static
     */
    public function save() : static
    {
        // 追加処理
        foreach($this->setQue as $queItemKey => $queItem)
        {
            !setcookie(
                $queItemKey
              , $queItem[1]
              , $queItem[2]
              , $queItem[3]
              , $queItem[4]
              , $queItem[5]
              , $queItem[6]
            );
        }

        $this->setQue = [];


        // 削除処理
        foreach($this->unsetQue as $queItemKey => $queItem)
        {
            !setcookie(
                $queItemKey
              , ''
              , DateTime::now()->subSeconds(1)->getTimestamp()
            );
        }

        $this->unsetQue = [];


        return $this;
    }




    /**
     * 既定パスを取得する。
     *
     * @return string
     */
    public function getDefaultPath(): string
    {
        return $this->defaultPath;
    }




    /**
     * 既定パスを設定する。
     *
     * @param string $defaultPath
     * @return static
     */
    public function setDefaultPath(string $defaultPath) : static
    {
        $this->defaultPath = $defaultPath;
        return $this;
    }




    /**
     * 既定ドメインを取得する。
     *
     * @return string
     */
    public function getDefaultDomain(): string
    {
        return $this->defaultDomain;
    }




    /**
     * 既定ドメインを設定する。
     *
     * @param string $defaultDomain
     * @return static
     */
    public function setDefaultDomain(string $defaultDomain) : static
    {
        $this->defaultDomain = $defaultDomain;
        return $this;
    }




    /**
     * 既定Https制限フラグを取得する。
     *
     * @return bool
     */
    public function getDefaultIsSecure(): bool
    {
        return $this->defaultIsSecure;
    }




    /**
     * 既定Https制限フラグを設定する。
     *
     * @param bool $defaultIsSecure
     * @return static
     */
    public function setDefaultIsSecure(bool $defaultIsSecure) : static
    {
        $this->defaultIsSecure = $defaultIsSecure;
        return $this;
    }




    /**
     * 既定Http通信限定フラグを取得する。
     *
     * @return bool
     */
    public function getDefaultIsHttpOnly(): bool
    {
        return $this->defaultIsHttpOnly;
    }




    /**
     * 既定Http通信限定フラグを設定する。
     *
     * @param bool $defaultIsHttpOnly
     * @return static
     */
    public function setDefaultIsHttpOnly(bool $defaultIsHttpOnly) : static
    {
        $this->defaultIsHttpOnly = $defaultIsHttpOnly;
        return $this;
    }
}
