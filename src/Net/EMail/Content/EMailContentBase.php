<?php
namespace Jp\Skud\Sdl\Net\EMail\Content;

use Jp\Skud\Sdl\IO\MimeType;

/**
 * Eメールのコンテンツを表現する抽象クラス
 */
abstract class EMailContentBase implements IEMailContent
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var string $content コンテンツ */
    protected string $content = '';

    /** @var MimeType $mimeType MIME-Type */
    protected MimeType $mimeType;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param string $content
     * @param MimeType|null $mimeType
     */
    public function __construct(string $content = '', ?MimeType $mimeType = null)
    {
        $this->setContent($content);

        if($mimeType !== null)
        {
            $this->setMimeType($mimeType);
        }
        else
        {
            $this->setMimeType(MimeType::from(MimeType::PLAIN_TEXT));
        }
    }




    /**
     * @inheritDoc
     */
    public function getContent() : string
    {
        return $this->content;
    }




    /**
     * @inheritDoc
     */
    public function setContent(string $content) : static
    {
        $this->content = $content;
        return $this;
    }




    /**
     * @inheritDoc
     */
    public function mimeType() : MimeType
    {
        return $this->mimeType;
    }




    /**
     * @inheritDoc
     */
    public function setMimeType(MimeType $mimeType): static
    {
        $this->mimeType = $mimeType;
        return $this;
    }




    /**
     * オブジェクトの文字列表現を取得する。
     *
     * @return string
     */
    public function toString() : string
    {
        return $this->content;
    }




    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
