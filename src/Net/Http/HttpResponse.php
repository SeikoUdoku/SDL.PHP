<?php
namespace Jp\Skud\Sdl\Net\Http;

use Jp\Skud\Sdl\IO\MimeType;
use Jp\Skud\Sdl\Text\StringUtil;

/**
 * Http応答を取扱うクラス
 */
class HttpResponse
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var HttpStatusCode Httpステータスコード */
    protected HttpStatusCode $httpStatusCode;

    /** @var HttpHeaders 応答ヘダー */
    protected HttpHeaders $headers;

    /** @var MimeType|null MIME型 */
    protected ?MimeType $mimeType;

    /** @var string 応答データ */
    protected string $content = '';






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->httpStatusCode = HttpStatusCode::OK;
        $this->headers = new HttpHeaders();
        $this->mimeType = null;
    }



    /**
     * Httpステータスコードを取得する。
     *
     * @return HttpStatusCode
     */
    public function getHttpStatusCode(): HttpStatusCode
    {
        return $this->httpStatusCode;
    }




    /**
     * Httpステータスコードを設定する。
     *
     * @param HttpStatusCode|int $httpStatusCode
     * @return static
     */
    public function setHttpStatusCode(HttpStatusCode|int $httpStatusCode): static
    {
        if(is_int($httpStatusCode))
        {
            $httpStatusCode = HttpStatusCode::from($httpStatusCode);
        }

        $this->httpStatusCode = $httpStatusCode;
        return $this;
    }




    /**
     * 応答ヘダーを取得する。
     *
     * @return HttpHeaders
     */
    public function headers(): HttpHeaders
    {
        return $this->headers;
    }




    /**
     * MimeTypeを取得する。
     *
     * @return MimeType|null
     */
    public function getMimeType(): ?MimeType
    {
        return $this->mimeType;
    }




    /**
     * MimeTypeを設定する。
     *
     * @param MimeType|null $mimeType
     * @return static
     */
    public function setMimeType(?MimeType $mimeType): static
    {
        $this->mimeType = $mimeType;
        return $this;
    }




    /**
     * 応答データを取得する。
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }




    /**
     * 応答データを設定する。
     *
     * @param string $content
     * @return static
     */
    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }



    /**
     * Httpステータスコードを送信する。
     *
     * @return void
     */
    public function sendHttpHeaders() : void
    {
        $headers = clone $this->headers;
        if($this->mimeType !== null && !StringUtil::isEmpty($this->mimeType->toString()))
        {
            $headers->tryAdd('Content-Type', $this->mimeType->toString());
        }

        foreach($headers as $key => $value)
        {
            header((string)$key.': '.(string)$value);
        }
    }




    /**
     * Httpステータスコードを送信する。
     *
     * @return void
     */
    public function sendHttpStatusCode() : void
    {
        http_response_code($this->httpStatusCode->getValue());
    }




    /**
     * コンテンツを送信する。
     *
     * @return void
     */
    public function sendContents() : void
    {
        echo $this->content;
    }




    /**
     * 応答データを送信する。
     *
     * @return void
     */
    public function send() : void
    {
        $this->sendHttpStatusCode();
        $this->sendHttpHeaders();
        $this->sendContents();
    }
}
