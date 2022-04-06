<?php
namespace Jp\Skud\Sdl\Net\EMail;

use Jp\Skud\Sdl\Net\EMail\Content\HtmlContent;
use Jp\Skud\Sdl\Net\EMail\Content\PlainTextContent;

/**
 * Eメールを表現するインタフェース
 */
interface IEMail
{
    // ================================================================
    // 抽象関数
    // ================================================================
    /**
     * 件名を取得する。
     *
     * @return string
     */
    public function getSubject() : string;


    /**
     * 件名を設定する。
     *
     * @param string $subject
     * @return static
     */
    public function setSubject(string $subject) : static;


    /**
     * テキストコンテンツを取得する。
     *
     * @return PlainTextContent|null
     */
    public function plainTextContent() : ?PlainTextContent;


    /**
     * テキストコンテンツを設定する。
     *
     * @param PlainTextContent|null $plainTextContent
     * @return static
     */
    public function setPlainTextContent(?PlainTextContent $plainTextContent) : static;


    /**
     * HTMLコンテンツを取得する。
     *
     * @return HtmlContent|null
     */
    public function htmlContent() : ?HtmlContent;


    /**
     * HTMLコンテンツを設定する。
     *
     * @param HtmlContent|null $htmlContent
     * @return static
     */
    public function setHtmlContent(?HtmlContent $htmlContent) : static;


    /**
     * Eメールヘダーの集合を取得する。
     *
     * @return EMailHeaders
     */
    public function headers() : EMailHeaders;


    /**
     * Eメールヘダーの集合を設定する。
     *
     * @param EMailHeaders $eMailHeaders
     * @return static
     */
    public function setHeaders(EMailHeaders $eMailHeaders) : static;


    /**
     * 送信元アドレスの集合を取得する。
     *
     * @return EMailAddresses
     */
    public function fromAddresses() : EMailAddresses;


    /**
     * 送信元アドレスの集合を設定する。
     *
     * @param EMailAddresses $fromEMailAddresses
     * @return static
     */
    public function setFromAddresses(EMailAddresses $fromEMailAddresses) : static;


    /**
     * Reply-Toアドレスの集合を取得する。
     *
     * @return EMailAddresses
     */
    public function replyAddresses() : EMailAddresses;


    /**
     * Reply-Toアドレスの集合を設定する。
     *
     * @param EMailAddresses $replyEMailAddresses
     * @return static
     */
    public function setReplyAddresses(EMailAddresses $replyEMailAddresses) : static;


    /**
     * 送信先アドレスの集合を取得する。
     *
     * @return EMailAddresses
     */
    public function toAddresses() : EMailAddresses;


    /**
     * 送信先アドレスの集合を設定する。
     *
     * @param EMailAddresses $toEMailAddresses
     * @return static
     */
    public function setToAddresses(EMailAddresses $toEMailAddresses) : static;


    /**
     * CCアドレスの集合を取得する。
     *
     * @return EMailAddresses
     */
    public function ccAddresses() : EMailAddresses;


    /**
     * CCアドレスの集合を設定する。
     *
     * @param EMailAddresses $ccAddresses
     * @return static
     */
    public function setCcAddresses(EMailAddresses $ccAddresses) : static;


    /**
     * BCCアドレスの集合を取得する。
     *
     * @return EMailAddresses
     */
    public function bccAddresses() : EMailAddresses;


    /**
     * BCCアドレスの集合を設定する。
     *
     * @param EMailAddresses $bccAddresses
     * @return static
     */
    public function setBccAddresses(EMailAddresses $bccAddresses) : static;
}
