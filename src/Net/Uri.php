<?php
namespace Jp\Skud\Sdl\Net;

use DomainException;
use Jp\Skud\Sdl\Text\StringUtil;
use Stringable;

/**
 * Uriを取扱うクラス
 */
class Uri implements Stringable
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var string スキーム */
    protected string $scheme = '';

    /** @var string ホスト名 */
    protected string $host = '';

    /** @var string ポート番号 */
    protected int $port = 0;

    /** @var string ユーザ名 */
    protected string $user = '';

    /** @var string パスワード */
    protected string $pass = '';

    /** @var string パス */
    protected string $path = '';

    /** @var UriQueries クエリ  */
    protected UriQueries $uriQueries;

    /** @var string フラグメント */
    protected string $fragment = '';






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param string $uri
     *
     * @throws DomainException
     */
    public function __construct(string $uri = '')
    {
        if(!StringUtil::isWhiteSpace($uri))
        {
            $uriParts = parse_url($uri);

            if($uriParts === false)
            {
                throw new DomainException("Uri[{$uri}]の形式が不正です。");
            }

            $scheme = '';
            $host = '';
            $port = 0;
            $user = '';
            $pass = '';
            $path = '';
            $queryStr = '';
            $fragment = '';

            if(isset($uriParts['scheme']))
            {
                $scheme = (string)$uriParts['scheme'];
            }

            if(isset($uriParts['host']))
            {
                $host = (string)$uriParts['host'];
            }

            if(isset($uriParts['port']))
            {
                $port = (int)$uriParts['port'];
            }

            if(isset($uriParts['user']))
            {
                $user = (string)$uriParts['user'];
            }

            if(isset($uriParts['pass']))
            {
                $pass = (string)$uriParts['pass'];
            }

            if(isset($uriParts['path']))
            {
                $path = (string)$uriParts['path'];
            }

            if(isset($uriParts['query']))
            {
                $queryStr = (string)$uriParts['query'];
            }

            if(isset($uriParts['fragment']))
            {
                $fragment = (string)$uriParts['fragment'];
            }

            $this->scheme = $scheme;
            $this->host = $host;
            $this->port = $port;
            $this->user = $user;
            $this->pass = $pass;
            $this->path = $path;
            $this->uriQueries = UriQueries::parseQueryString($queryStr);
            $this->fragment = $fragment;
        }
        else
        {
            $this->uriQueries = new UriQueries();
        }
    }




    /**
     * スキームを取得する。
     *
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }




    /**
     * スキームを設定する。
     *
     * @param string $scheme
     * @return static
     */
    public function setScheme(string $scheme): static
    {
        $this->scheme = $scheme;
        return $this;
    }




    /**
     * ホスト名を取得する。
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }




    /**
     * ホスト名を設定する。
     *
     * @param string $host
     * @return static
     */
    public function setHost(string $host): static
    {
        $this->host = $host;
        return $this;
    }




    /**
     * ポート番号を取得する。
     *
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }




    /**
     * ポート番号を設定する。
     *
     * @param int $port
     * @return static
     */
    public function setPort(int $port): static
    {
        $this->port = $port;
        return $this;
    }




    /**
     * ユーザ名を取得する。
     *
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }




    /**
     * ユーザ名を設定する。
     *
     * @param string $user
     * @return static
     */
    public function setUser(string $user): static
    {
        $this->user = $user;

        return $this;
    }




    /**
     * パスワードを取得する。
     *
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }




    /**
     * パスワードを設定する。
     *
     * @param string $pass
     * @return static
     */
    public function setPass(string $pass): static
    {
        $this->pass = $pass;

        return $this;
    }




    /**
     * パスを取得する。
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }




    /**
     * パスを設定する。
     *
     * @param string $path
     * @return static
     */
    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }




    /**
     * クエリを取得する。
     *
     * @return UriQueries
     */
    public function uriQueries(): UriQueries
    {
        return $this->uriQueries;
    }




    /**
     * クエリを設定する。
     *
     * @param UriQueries $uriQueries
     * @return static
     */
    public function setQueries(UriQueries $uriQueries): static
    {
        $this->uriQueries = $uriQueries;
        return $this;
    }




    /**
     * フラグメントを取得する。
     *
     * @return string
     */
    public function getFragment(): string
    {
        return $this->fragment;
    }




    /**
     * フラグメントを設定する。
     *
     * @param string $fragment
     * @return static
     */
    public function setFragment(string $fragment): static
    {
        $this->fragment = $fragment;

        return $this;
    }




    /**
     * Uri文字列を取得する。
     *
     * @return string
     */
    public function toString() : string
    {
        $uri = '';

        if(!StringUtil::isEmpty($this->scheme))
        {
            $uri .= $this->scheme.'://';
        }

        if(!StringUtil::isEmpty($this->user))
        {
            $uri .= $this->user.':'.$this->pass.'@';
        }

        if(!StringUtil::isEmpty($this->scheme))
        {
            $uri .= $this->host;
        }

        if($this->port > 0)
        {
            $uri .= ':'.(string)$this->port;
        }

        if(!StringUtil::isEmpty($this->path))
        {
            $uri .= $this->path;
        }

        if($this->uriQueries->count() > 0)
        {
            $uri .= '?'.$this->uriQueries->toString();
        }

        if(!StringUtil::isEmpty($this->fragment))
        {
            $uri .= '#'.$this->fragment;
        }

        return $uri;
    }




    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
