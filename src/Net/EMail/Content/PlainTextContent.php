<?php
namespace Jp\Skud\Sdl\Net\EMail\Content;

use Jp\Skud\Sdl\IO\MimeType;

/**
 * テキストで表現されるEメールコンテンツを表現するクラス
 */
class PlainTextContent extends EMailContentBase
{
    // ================================================================
    // 関数
    // ================================================================
    /**
     * @inheritDoc
     */
    public function __construct(string $content = '')
    {
        parent::__construct($content, MimeType::from(MimeType::PLAIN_TEXT));
    }
}
