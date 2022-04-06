<?php
namespace Jp\Skud\Sdl\Net\EMail;

use Jp\Skud\Sdl\Net\EMail\Content\HtmlContent;
use Jp\Skud\Sdl\Net\EMail\Content\PlainTextContent;

/**
 * Eメールを表現するクラス
 */
class EMail implements IEMail
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var string 件名 */
    protected string $subject = '';

    /** @var PlainTextContent|null テキストコンテンツ */
    protected ?PlainTextContent $plainTextContent = null;

    /** @var HtmlContent|null HTMLコンテンツ */
    protected ?HtmlContent $htmlContent = null;

    /** @var EMailHeaders Eメールヘダーの集合 */
    public EMailHeaders $headers;

    /** @var EMailAddresses 送信元アドレスの集合 */
    public EMailAddresses $fromAddresses;

    /** @var EMailAddresses Reply-Toアドレスの集合 */
    public EMailAddresses $replyToAddresses;

    /** @var EMailAddresses 送信先アドレスの集合 */
    public EMailAddresses $toAddresses;

    /** @var EMailAddresses CCアドレスの集合 */
    public EMailAddresses $ccAddresses;

    /** @var EMailAddresses BCCアドレスの集合 */
    public EMailAddresses $bccAddresses;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->headers = new EMailHeaders();
        $this->fromAddresses = new EMailAddresses();
        $this->replyToAddresses = new EMailAddresses();
        $this->toAddresses = new EMailAddresses();
        $this->ccAddresses = new EMailAddresses();
        $this->bccAddresses = new EMailAddresses();
    }




    /**
     * @inheritDoc
     */
    public function getSubject() : string
    {
        return $this->subject;
    }




    /**
     * @inheritDoc
     */
    public function setSubject(string $subject) : static
    {
        $this->subject = $subject;
        return $this;
    }




    /**
     * @inheritDoc
     */
    public function plainTextContent() : ?PlainTextContent
    {
        return $this->plainTextContent;
    }




    /**
     * @inheritDoc
     */
    public function setPlainTextContent(?PlainTextContent $plainTextContent) : static
    {
        $this->plainTextContent = $plainTextContent;
        return $this;
    }




    /**
     * @inheritDoc
     */
    public function htmlContent() : ?HtmlContent
    {
        return $this->htmlContent;
    }




    /**
     * @inheritDoc
     */
    public function setHtmlContent(?HtmlContent $htmlContent) : static
    {
        $this->htmlContent = $htmlContent;
        return $this;
    }




    /**
     * @inheritDoc
     */
    public function headers() : EMailHeaders
    {
        return $this->headers;
    }




    /**
     * @inheritDoc
     */
    public function setHeaders(EMailHeaders $eMailHeaders) : static
    {
        $this->headers = $eMailHeaders;
        return $this;
    }




    /**
     * @inheritDoc
     */
    public function fromAddresses() : EMailAddresses
    {
        return $this->fromAddresses;
    }




    /**
     * @inheritDoc
     */
    public function setFromAddresses(EMailAddresses $fromEMailAddresses) : static
    {
        $this->fromAddresses = $fromEMailAddresses;
        return $this;
    }




    /**
     * @inheritDoc
     */
    public function replyAddresses() : EMailAddresses
    {
        return $this->replyToAddresses;
    }




    /**
     * @inheritDoc
     */
    public function setReplyAddresses(EMailAddresses $replyEMailAddresses) : static
    {
        $this->replyToAddresses = $replyEMailAddresses;
        return $this;
    }




    /**
     * @inheritDoc
     */
    public function toAddresses() : EMailAddresses
    {
        return $this->toAddresses;
    }




    /**
     * @inheritDoc
     */
    public function setToAddresses(EMailAddresses $toEMailAddresses) : static
    {
        $this->toAddresses = $toEMailAddresses;
        return $this;
    }




    /**
     * @inheritDoc
     */
    public function ccAddresses() : EMailAddresses
    {
        return $this->ccAddresses;
    }




    /**
     * @inheritDoc
     */
    public function setCcAddresses(EMailAddresses $ccAddresses) : static
    {
        $this->ccAddresses = $ccAddresses;
        return $this;
    }




    /**
     * @inheritDoc
     */
    public function bccAddresses() : EMailAddresses
    {
        return $this->bccAddresses;
    }




    /**
     * @inheritDoc
     */
    public function setBccAddresses(EMailAddresses $bccAddresses) : static
    {
        $this->bccAddresses = $bccAddresses;
        return $this;
    }
}
