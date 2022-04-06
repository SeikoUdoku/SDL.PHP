<?php
namespace Jp\Skud\Sdl\Net\EMail\Content;

use Jp\Skud\Sdl\IO\MimeType;
use Stringable;

/**
 * Eメールのコンテンツを表現するインタフェース
 */
interface IEMailContent extends Stringable
{
    // ================================================================
    // 抽象関数
    // ================================================================
    /**
     * コンテンツを取得する。
     *
     * @return string
     */
    public function getContent() : string;


    /**
     * コンテンツを設定する。
     *
     * @param string $content
     * @return static
     */
    public function setContent(string $content) : static;


    /**
     * MimeTypeを取得する。
     *
     * @return MimeType
     */
    public function mimeType() : MimeType;


    /**
     * MimeTypeを設定する。
     *
     * @param MimeType $mimeType
     * @return static
     */
    public function setMimeType(MimeType $mimeType) : static;
}
