<?php
namespace Jp\Skud\Sdl\IO;

use Jp\Skud\Sdl\ValueObject\IntValueObject;

/**
 * ロック方法を表現するクラス
 */
class LockMode extends IntValueObject
{
    // ================================================================
    // 定数
    // ================================================================
    /** 共有ロック */
    public const Shared = LOCK_SH;

    /** 排他ロック */
    public const Exclusive = LOCK_EX;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * flock()関数向けのフラグ値を取得する。
     *
     * @return int
     */
    public function toOperator() : int
    {
        return $this->value;
    }
}
