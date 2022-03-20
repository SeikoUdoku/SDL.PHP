<?php
namespace Jp\Skud\Sdl\ValueObject;

use DomainException;
use Stringable;

/**
 * 整数値を表現する値オブジェクト機能を提供するクラス
 */
class IntValueObject implements Stringable
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var int $value 値 */
    protected int $value = 0;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param int $value
     *
     * @throws DomainException
     */
    public function __construct(int $value)
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
     * @return int
     */
    public function value() : int
    {
        return $this->getValue();
    }




    /**
     * 値を取得する。
     *
     * @return int
     */
    public function getValue() : int
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
        return (string)$this->getValue();
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
     * @param int $value
     * @return bool
     */
    public static function validate(int $value) : bool
    {
        return true;
    }




    /**
     * 値からオブジェクトを作成する。
     *
     * @param int $value
     * @return static
     */
    public static function from(int $value) : static
    {
        return new static($value);
    }
}
