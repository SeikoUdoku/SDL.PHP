<?php
namespace Jp\Skud\Sdl\Text;

use DomainException;
use OutOfRangeException;

/**
 * 文字列に関する汎用的な操作を提供するユーティリティクラス
 */
class StringUtil
{
    // ================================================================
    // 定数
    // ================================================================
    /** ホワイトスペース文字の集合 */
    public const WHITE_SPACE_CHARS = [
        Char::NUL
      , Char::HT
      , Char::LF
      , Char::CR
      , Char::SPACE
      , Char::VT
    ];

    /** 単語区切り文字の集合 */
    public const WORD_SEPARATOR_CHARS = [
        ' '
      , '-'
      , '_'
    ];






    // ================================================================
    // 関数
    // ================================================================
    /**
     * 空文字列であるか判定する。
     *
     * @param string $str
     * @return bool
     */
    public static function isEmpty(string $str) : bool
    {
        return (static::bytes($str) < 1);
    }




    /**
     * 空文字列ないしは、任意のホワイトスペース文字のみで校正される文字列であるか判定する。
     *
     * @param string $str
     * @param string[] $trimChars
     * @return bool
     */
    public static function isWhiteSpace(string $str, array $trimChars = self::WHITE_SPACE_CHARS) : bool
    {
        return static::isEmpty(static::trim($str, $trimChars));
    }




    /**
     * 文字列のバイト数を取得する。
     *
     * @param string $str
     * @return int
     */
    public static function bytes(string $str) : int
    {
        return strlen($str);
    }




    /**
     * 文字列の文字数を取得する。
     *
     * @param string $str
     * @param string|null $encoding
     * @return int
     */
    public static function length(string $str, ?string $encoding = null) : int
    {
        return mb_strlen($str, $encoding);
    }




    /**
     * 文字列前後の任意文字を除去した文字列を取得する。
     *
     * @param string $str
     * @param string[] $trimChars
     * @return string
     */
    public static function trim(string $str, array $trimChars = self::WHITE_SPACE_CHARS) : string
    {
        return trim($str, implode('', $trimChars));
    }




    /**
     * 文字列前方の任意文字を除去した文字列を取得する。
     *
     * @param string $str
     * @param string[] $trimChars
     * @return string
     */
    public static function trimStart(string $str, array $trimChars = self::WHITE_SPACE_CHARS) : string
    {
        return ltrim($str, implode('', $trimChars));
    }




    /**
     * 文字列後方の任意文字を除去した文字列を取得する。
     *
     * @param string $str
     * @param string[] $trimChars
     * @return string
     */
    public static function trimEnd(string $str, array $trimChars = self::WHITE_SPACE_CHARS) : string
    {
        return rtrim($str, implode('', $trimChars));
    }




    /**
     * 文字列から特定範囲を抽出する。
     *
     * @param string $str
     * @param int $offset
     * @param int|null $length
     * @param string|null $encoding
     * @param bool $byteMode
     * @return string
     */
    public static function substr(string $str, int $offset, ?int $length = null, ?string $encoding = null, bool $byteMode = false) : string
    {
        if($byteMode)
        {
            return substr($str, $offset, $length);
        }
        else
        {
            return mb_substr($str, $offset, $length, $encoding);
        }
    }




    /**
     * 文字列を指定桁長まで固定長の任意文字列で埋める。
     *
     * @param string $str
     * @param int $length
     * @param string $padStr
     * @param string|null $encoding
     * @param bool $byteMode
     * @return string
     *
     * @throws OutOfRangeException
     * @throws DomainException
     */
    public static function padding(string $str, int $length, string $padStr = ' ', int $padType = STR_PAD_RIGHT , ?string $encoding = '', bool $byteMode = false) : string
    {
        // バリデーション
        if($length < 1)
        {
            throw new OutOfRangeException('桁長を[1]未満とすることはできません。');
        }

        if(static::bytes($padStr) < 1)
        {
            throw new DomainException('パディング文字列長を[1byte]未満とすることはできません。');
        }

        if(!in_array($padType, [STR_PAD_LEFT, STR_PAD_RIGHT, STR_PAD_BOTH], true))
        {
            throw new DomainException("パディング処理方法[{$padType}]が不正です。");
        }


        // バイト単位パディング処理
        if($byteMode)
        {
            return str_pad($str, $length, $padStr, $padType);
        }


        // 文字単位パディング処理
        $inputStrLen = static::length($str, $encoding);
        $padStrLen = static::length($padStr, $encoding);
        $padLen  = $length - $inputStrLen;

        if($padStrLen < 1 || $padLen < 1)
        {
            return $str;
        }

        if($padType === STR_PAD_BOTH)
        {
            $padLen /= 2;
        }

        $padStrFully = static::repeat($padStr, ceil($padLen / $padStrLen));
        $padStrStart = '';
        $padStrEnd = '';

        if($padType === STR_PAD_LEFT || $padType === STR_PAD_BOTH)
        {
            $padStrStart = static::substr($padStrFully, 0, floor($padLen), $encoding);
        }

        if($padType === STR_PAD_RIGHT || $padType === STR_PAD_BOTH)
        {
            $padStrEnd  = static::substr($padStrFully, 0, ceil($padLen), $encoding);
        }


        return $padStrStart.$str.$padStrEnd;
    }




    /**
     * 文字列の前方を指定桁長まで固定長の任意文字列で埋める。
     *
     * @param string $str
     * @param int $length
     * @param string $padStr
     * @param string|null $encoding
     * @param bool $byteMode
     * @return string
     */
    public static function paddingStart(string $str, int $length, string $padStr = ' ', ?string $encoding = '', bool $byteMode = true) : string
    {
        return static::padding($str, $length, $padStr, STR_PAD_LEFT, $encoding, $byteMode);
    }




    /**
     * 文字列の後方を指定桁長まで固定長の任意文字列で埋める。
     *
     * @param string $str
     * @param int $length
     * @param string $padStr
     * @param string|null $encoding
     * @param bool $byteMode
     * @return string
     */
    public static function paddingEnd(string $str, int $length, string $padStr = ' ', ?string $encoding = '', bool $byteMode = true) : string
    {
        return static::padding($str, $length, $padStr, STR_PAD_RIGHT, $encoding, $byteMode);
    }




    /**
     * 文字列の前方並びに後方を指定桁長まで固定長の任意文字列で埋める。
     *
     * @param string $str
     * @param int $length
     * @param string $padStr
     * @param string|null $encoding
     * @param bool $byteMode
     * @return string
     */
    public static function paddingBoth(string $str, int $length, string $padStr = ' ', ?string $encoding = '', bool $byteMode = true) : string
    {
        return static::padding($str, $length, $padStr, STR_PAD_BOTH, $encoding, $byteMode);
    }




    /**
     * 文字列を任意回数繰り返した文字列を取得する。
     *
     * @param string $str
     * @param int $repeatNums
     * @return string
     */
    public static function repeat(string $str, int $repeatNums) : string
    {
        return str_repeat($str, $repeatNums);
    }




    /**
     * 任意の文字列が検索対象文字列に含まれるか判定する。
     *
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function contains(string $haystack, string $needle) : bool
    {
        return str_contains($haystack, $needle);
    }




    /**
     * 文字列中のアルファベットを全て大文字に変換する。
     *
     * @param string $str
     * @return string
     */
    public static function toUpper(string $str, ?string $encoding = null) : string
    {
        return mb_strtoupper($str, $encoding);
    }




    /**
     * 文字列中のアルファベットを全て小文字に変換する。
     *
     * @param string $str
     * @return string
     */
    public static function toLower(string $str, ?string $encoding = null) : string
    {
        return mb_strtolower($str, $encoding);
    }




    /**
     * 文字列の半角全角を変換する。
     *
     * @see https://www.php.net/manual/ja/function.mb-convert-kana.php
     *
     * @param string $str
     * @param string $mode
     * @return string
     */
    public static function convertWidth(string $str, string $mode, ?string $encoding = null) : string
    {
        return mb_convert_kana($str, $mode, $encoding);
    }




    /**
     * 文字列をパスカルケース(PascalCase)形式に変換する。
     *
     * @param string $str
     * @param string[] $wordSeparatorChars
     * @return string
     */
    public static function pascalize(string $str, array $wordSeparatorChars = self::WORD_SEPARATOR_CHARS) : string
    {
        $str = static::trim($str, static::WHITE_SPACE_CHARS + $wordSeparatorChars);
        return str_replace($wordSeparatorChars, '', ucwords($str, implode('', $wordSeparatorChars)));
    }




    /**
     * 文字列をキャメルケース(camelCase)形式に変換する
     *
     * @param string $str
     * @param string[] $wordSeparatorChars
     * @return string
     */
    public static function camelize(string $str, array $wordSeparatorChars = self::WORD_SEPARATOR_CHARS) : string
    {
        return lcfirst(static::pascalize($str, $wordSeparatorChars));
    }




    /**
     * 文字列をスネークケース(snake_case)形式に変換する
     *
     * @param string $str
     * @param string[] $wordSeparatorChars
     * @return string
     */
    public static function snakify(string $str, array $wordSeparatorChars = self::WORD_SEPARATOR_CHARS) : string
    {
        $str = preg_replace('/([A-Z])/u', '_$1', static::pascalize($str, $wordSeparatorChars));
        $str = static::toLower($str);
        return static::trimStart($str, ['_']);
    }
}
