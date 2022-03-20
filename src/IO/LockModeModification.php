<?php
namespace Jp\Skud\Sdl\IO;

use Jp\Skud\Sdl\ValueObject\IntValueObject;

/**
 * ロック方法のオプション値を表現するクラス
 */
class LockModeModification extends IntValueObject
{
    // ================================================================
    // 列挙値
    // ================================================================
    /** 非ブロックモード */
    public const NotBlock = LOCK_NB;






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
