<?php
namespace Jp\Skud\Sdl\ValueObject;

use DomainException;
use Stringable;

/**
 * 文字列値を表現する値オブジェクト機能を提供するクラス
 */
class StringValueObject implements Stringable
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var string $value 値 */
    protected string $value = '';






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if(!static::validate($value))
        {
            throw new DomainException("値[{$value}]が不正です。");
        }

        $this->value = $value;
    }




    /**
     * 値を取得する。
     *
     * @return string
     */
    public function getValue() : string
    {
        return $this->value;
    }




    /**
     * オブジェクトの文字列表現を取得する。
     *
     * @return string
     */
    public function toString() : string
    {
        return $this->getValue();
    }




    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->toString();
    }






    // ================================================================
    // 静的関数
    // ================================================================
    /**
     * 値が業務仕様に準じているか判定する。
     *
     * @param string $value
     * @return bool
     */
    public static function validate(string $value) : bool
    {
        return true;
    }




    /**
     * 値からオブジェクトを作成する。
     *
     * @param string $value
     * @return static
     */
    public static function from(string $value) : static
    {
        return new static($value);
    }
}
