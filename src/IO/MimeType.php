<?php
namespace Jp\Skud\Sdl\IO;

use DomainException;
use Exception;
use Jp\Skud\Sdl\Collection\Collection;
use Jp\Skud\Sdl\Text\StringUtil;

/**
 * IO処理に関するエラーが発生した場合の例外クラス。
 */
class MimeType
{
    // ================================================================
    // 定数
    // ================================================================
    /** MIME-Type: Html */
    public const HTML = 'text/plain';

    /** MIME-Type: Xml */
    public const XML = self::XML_READABLE;

    /** MIME-Type: Xml(UserReadable) */
    public const XML_READABLE = 'text/xml';

    /** MIME-Type: Xml(Application) */
    public const XML_APPLICATION = 'application/xml';

    /** MIME-Type: JavaScript */
    public const JAVA_SCRIPT = 'text/javascript';

    /** MIME-Type: CSV */
    public const CSV = 'text/csv';

    /** MIME-Type: Json */
    public const JSON = 'application/json';

    /** MIME-Type: Json+LD */
    public const JSON_LD = 'application/ld+json';

    /** MIME-Type: PlainText */
    public const PLAIN_TEXT = 'text/plain';

    /** MIME-Type: GIF */
    public const GIT = 'image/gif';

    /** MIME-Type: JPEG */
    public const JPEG = 'image/jpeg';

    /** MIME-Type: PNG */
    public const PNG = 'image/png';

    /** MIME-Type: MP3 */
    public const MP3 = 'audio/mpeg';

    /** MIME-Type: WAVE */
    public const WAVE = 'audio/wav';

    /** MIME-Type: MPEG(Video) */
    public const MPEG_VIDEO = 'video/mpeg';

    /** MIME-Type: MP4 */
    public const MP4 = 'video/mp4';

    /** MIME-Type: SVG */
    public const SVG = 'image/svg+xml';

    /** MIME-Type: ZIP */
    public const ZIP = 'application/zip';

    /** MIME-Type: OpenXML */
    public const OPEN_XML = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

    /** MIME-Type: Excel */
    public const EXCEL = 'application/vnd.ms-excel';

    /** MIME-Type: PDF */
    public const PDF = 'application/pdf';

    /** 正規表現:MIME-Type文字列解析用 */
    protected const PREG_PATTERN = '@^([\S]{1,})/([\S]{1,})(; [(;* \S=\S)*]{0,})?$@ui';






    // ================================================================
    // 変数
    // ================================================================
    /** @var string $topLevelType 最上位メディア型 */
    protected string $topLevelType;

    /** @var string $subType 下位型 */
    protected string $subType;

    /** @var Collection $parameters パラメータ */
    protected Collection $parameters;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param string $mimeType
     *
     * @throws DomainException
     * @throws Exception
     */
    public function __construct(string $mimeType)
    {
        // 全体様式チェック
        static::validate($mimeType);


        // 解析
        $matches = [];
        $matched =  preg_match(static::PREG_PATTERN, $mimeType, $matches);

        if($matched === 0)
        {
            return false;
        }
        elseif($matched === false)
        {
            throw new Exception("MIME-Type[{$mimeType}]の検証に失敗しました。");
        }

        $topLevelType = StringUtil::trim($matches[1]);
        $subType = StringUtil::trim($matches[2]);
        $parametersStr = isset($matches[3]) ? StringUtil::trim($matches[3]) : '';

        $parameters = new Collection();
        if(!StringUtil::isEmpty($parametersStr))
        {
            foreach(explode(';', $parametersStr) as $p)
            {
                $pkv = explode('=', $p);
                if(count($pkv) < 2)
                {
                    continue;
                }

                $pk = StringUtil::trim((string)$pkv[0]);
                $pv = StringUtil::trim((string)$pkv[1]);
                if(!StringUtil::isEmpty($pk) && !StringUtil::isEmpty($pv))
                {
                    $parameters->setElement($pk, $pv);
                }
            }
        }


        // オブジェクト初期化
        $this->topLevelType = $topLevelType;
        $this->subType = $subType;
        $this->parameters = $parameters;
    }




    /**
     * 最上位メディア型を取得する。
     *
     * @return string
     */
    public function getTopLevelType() : string
    {
        return $this->topLevelType;
    }




    /**
     * 最上位メディア型を設定する。
     *
     * @param string $topLevelType
     * @return static
     *
     * @throws DomainException
     */
    public function setTopLevelType(string $topLevelType) : static
    {
        if(!static::validateTopLevelType($topLevelType))
        {
            throw new DomainException("最上位メディア型[{$topLevelType}]の形式が不正です。");
        }

        $this->topLevelType = $topLevelType;

        return $this;
    }




    /**
     * 最上位メディア型を取得する。
     *
     * @return string
     */
    public function getSubType() : string
    {
        return $this->subType;
    }




    /**
     * 下位型を設定する。
     *
     * @param string $subType
     * @return static
     *
     * @throws DomainException
     */
    public function setSubType(string $subType) : static
    {
        if(!static::validateSubType($subType))
        {
            throw new DomainException("下位型[{$subType}]の形式が不正です。");
        }

        $this->subType = $subType;

        return $this;
    }




    /**
     * パラメタを取得する。
     *
     * @return Collection
     */
    public function parameters() : Collection
    {
        return $this->parameters;
    }




    /**
     * オブジェクトの文字列表現を取得する。
     *
     * @return string
     */
    public function toString() : string
    {
        $parametersStr = '';
        foreach($this->parameters->getIterator() as $pk => $pv)
        {
            $parametersStr .= "; {$pk}={$pv}";
        }

        return "{$this->topLevelType}/{$this->subType}{$parametersStr}";
    }




    /**
     * @inheritDoc
     */
    public function __toString() : string
    {
        return $this->toString();
    }






    // ================================================================
    // 静的関数
    // ================================================================
    /**
     * 値からオブジェクトを作成する。
     *
     * @param string $mimeType
     * @return static|null
     */
    public static function from(string $mimeType) : ?static
    {
        if(!static::validate($mimeType))
        {
            return null;
        }

        return new static($mimeType);
    }




    /**
     * MIME-Type文字列が正しい様式が検証する。
     *
     * @param string $mimeType
     * @return bool
     *
     * @throws Exception
     */
    public static function validate(string $mimeType) : bool
    {
        // 全体様式チェック
        $matches = [];
        $matched =  preg_match(static::PREG_PATTERN, $mimeType, $matches);

        if($matched === 0)
        {
            return false;
        }
        elseif($matched === false)
        {
            throw new Exception("MIME-Type[{$mimeType}]の検証に失敗しました。");
        }


        // 個別様式チェック
        $topLevelType = StringUtil::trim($matches[1]);
        $subType = StringUtil::trim($matches[2]);
        $parametersStr = isset($matches[3]) ? StringUtil::trim($matches[3]) : '';

        return (
            static::validateTopLevelType($topLevelType)
            && static::validateSubType($subType)
            && (StringUtil::isEmpty($parametersStr) || static::validateParametersString($parametersStr))
        );
    }




    /**
     * 最上位メディア型を表す文字列が正しい様式か検証する。
     *
     * @param string $mimeType
     * @return bool
     *
     * @throws Exception
     */
    public static function validateTopLevelType(string $topLevelType) : bool
    {
        // 様式チェック
        $matches = [];
        $matched =  preg_match('@^(application|audio|image|message|multipart|text|video|x-[\S]+){1}$@ui', $topLevelType, $matches);

        if($matched === 0)
        {
            return false;
        }
        elseif($matched === false)
        {
            throw new Exception("最上位メディア型[{$topLevelType}]の検証に失敗しました。");
        }

        return true;
    }




    /**
     * 下位型を表す文字列が正しい様式か検証する。
     *
     * @param string $mimeType
     * @return bool
     *
     * @throws Exception
     */
    public static function validateSubType(string $subType) : bool
    {
        // 様式チェック
        $matches = [];
        $matched =  preg_match('@^[\S]{1,}$@ui', $subType, $matches);

        if($matched === 0)
        {
            return false;
        }
        elseif($matched === false)
        {
            throw new Exception("下位型[{$subType}]の検証に失敗しました。");
        }

        return true;
    }




    /**
     * パラメタを表す文字列が正しい様式か検証する。
     *
     * @param string $parameterStr
     * @return bool
     *
     * @throws Exception
     */
    public static function validateParametersString(string $parameterStr) : bool
    {
        // 様式チェック
        $matches = [];
        $matched =  preg_match('@^; *[; (\S=\S)]{1,}$@ui', $parameterStr, $matches);

        if($matched === 0)
        {
            return false;
        }
        elseif($matched === false)
        {
            throw new Exception("パラメタ[{$parameterStr}]の検証に失敗しました。");
        }

        return true;
    }
}
