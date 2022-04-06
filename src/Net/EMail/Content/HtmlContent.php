<?php
namespace Jp\Skud\Sdl\Net\EMail\Content;

use BadMethodCallException;
use Jp\Skud\Sdl\IO\MimeType;
use Jp\Skud\Sdl\NotSupportedException;

/**
 * HTMLで表現されるEメールコンテンツを表現するクラス
 */
class HtmlContent extends EMailContentBase
{
    // ================================================================
    // 関数
    // ================================================================
    /**
     * @inheritDoc
     */
    public function __construct(string $content = '')
    {
        parent::__construct($content, MimeType::from(MimeType::HTML));
    }
}
