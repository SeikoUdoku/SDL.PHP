<?php
namespace Jp\Skud\Sdl\Net\Http;

use Jp\Skud\Sdl\DateTime;
use Jp\Skud\Sdl\Net\IPAddress;
use Jp\Skud\Sdl\Net\Uri;
use Jp\Skud\Sdl\Net\UriQueries;
use Jp\Skud\Sdl\Net\Web\Session;

/**
 * Http要求を取扱うクラス
 */
class HttpRequest
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var IPAddress IPアドレス */
    protected IPAddress $ipAddr;

    /** @var Uri 要求URI */
    protected Uri $uri;

    /** @var HttpMethod Httpメソッド */
    protected HttpMethod $httpMethod;

    /** @var DateTime 要求日時 */
    protected DateTime $requestedAt;

    /** @var Session セッション */
    protected Session $session;

    /** @var HttpHeaders 要求ヘダー */
    protected HttpHeaders $headers;

    /** @var UriQueries ボデークエリ */
    protected UriQueries $bodyQueries;

    /** @var UploadFiles アップロードファイル */
    protected UploadFiles $uploadFiles;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     */
    public function __construct(
        ?IPAddress $ipAddr = null
      , ?Uri $uri = null
      , ?HttpMethod $httpMethod = null
      , ?DateTime $requestedAt = null
      , ?Session $session = null
      , ?HttpHeaders $headers = null
      , ?UriQueries $bodyQueries = null
      , ?UploadFiles $uploadFiles = null
    )
    {
        if($ipAddr !== null)
        {
            $this->ipAddr = $ipAddr;
        }
        else
        {
            $this->ipAddr = new IPAddress(IPAddress::ANY_IPV4);
        }

        if($uri !== null)
        {
            $this->uri = $uri;
        }
        else
        {
            $this->uri = new Uri();
        }

        if($httpMethod !== null)
        {
            $this->httpMethod = $httpMethod;
        }
        else
        {
            $this->httpMethod = HttpMethod::from(HttpMethod::GET);
        }

        if($requestedAt !== null)
        {
            $this->requestedAt = $requestedAt;
        }
        else
        {
            $this->requestedAt = new DateTime();
        }

        if($session !== null)
        {
            $this->session = $session;
        }
        else
        {
            $this->session = new Session('', []);
        }

        if($headers !== null)
        {
            $this->headers = $headers;
        }
        else
        {
            $this->headers = new HttpHeaders([]);
        }

        if($bodyQueries !== null)
        {
            $this->bodyQueries = $bodyQueries;
        }
        else
        {
            $this->bodyQueries = new UriQueries();
        }

        if($uploadFiles !== null)
        {
            $this->uploadFiles = $uploadFiles;
        }
        else
        {
            $this->uploadFiles = new UploadFiles();
        }
    }




    /**
     * IPアドレスを取得する。
     *
     * @return IPAddress
     */
    public function ipAddr(): IPAddress
    {
        return $this->ipAddr;
    }




    /**
     * IPアドレスを設定する。
     *
     * @param IPAddress $ipAddr
     * @return self
     */
    public function setIpAddr(IPAddress $ipAddr): self
    {
        $this->ipAddr = $ipAddr;
        return $this;
    }




    /**
     * 要求URIを取得する。
     *
     * @return Uri
     */
    public function uri(): Uri
    {
        return $this->uri;
    }




    /**
     * 要求URIを設定する。
     *
     * @param Uri $uri
     * @return self
     */
    public function setUri(Uri $uri): self
    {
        $this->uri = $uri;
        return $this;
    }



    public function uriQueries() : UriQueries
    {
        return $this->uri->uriQueries();
    }




    /**
     * Httpメソッドを取得する。
     *
     * @return HttpMethod
     */
    public function httpMethod(): HttpMethod
    {
        return $this->httpMethod;
    }




    /**
     * Httpメソッドを設定する。
     *
     * @param HttpMethod $httpMethod
     * @return self
     */
    public function setHttpMethod(HttpMethod $httpMethod): self
    {
        $this->httpMethod = $httpMethod;
        return $this;
    }




    /**
     * 要求日時を取得する。
     *
     * @return DateTime
     */
    public function requestedAt(): DateTime
    {
        return $this->requestedAt;
    }




    /**
     * 要求日時を設定する。
     *
     * @param DateTime $requestedAt
     * @return self
     */
    public function setRequestedAt(DateTime $requestedAt): self
    {
        $this->requestedAt = $requestedAt;
        return $this;
    }




    /**
     * セッションを取得する。
     *
     * @return Session
     */
    public function session(): Session
    {
        return $this->session;
    }




    /**
     * セッションを設定する。
     *
     * @param Session $session
     * @return self
     */
    public function setSession(Session $session): self
    {
        $this->session = $session;
        return $this;
    }




    /**
     * 要求ヘダーを取得する。
     *
     * @return HttpHeaders
     */
    public function headers(): HttpHeaders
    {
        return $this->headers;
    }




    /**
     * 要求ヘダーを設定する。
     *
     * @param HttpHeaders $headers
     * @return self
     */
    public function setHeaders(HttpHeaders $headers): self
    {
        $this->headers = $headers;
        return $this;
    }




    /**
     * ボデークエリを取得する。
     *
     * @return UriQueries
     */
    public function bodyQueries(): UriQueries
    {
        return $this->bodyQueries;
    }




    /**
     * ボデークエリを設定する。
     *
     * @param Queries $bodyQueries
     * @return self
     */
    public function setBodyQueries(UriQueries $bodyQueries): self
    {
        $this->bodyQueries = $bodyQueries;
        return $this;
    }




    /**
     * アップロードファイルを取得する。
     *
     * @return UploadFiles
     */
    public function uploadFiles(): UploadFiles
    {
        return $this->uploadFiles;
    }




    /**
     * アップロードファイルを設定する。
     *
     * @param UploadFiles $uploadFiles
     * @return self
     */
    public function setUploadFiles(UploadFiles $uploadFiles): self
    {
        $this->uploadFiles = $uploadFiles;
        return $this;
    }
}
