<?php
namespace Jp\Skud\Sdl\Collection;

use Countable;
use IteratorAggregate;

/**
 * 読み取り専用のコレクションに関する機能を提供するインタフェース
 */
interface IReadonlyCollection extends Countable, IteratorAggregate
{
    // ================================================================
    // 抽象関数
    // ================================================================
    /**
     * 要素を取得する。
     *
     * @param int|string $key
     * @return mixed
     */
    public function get(int|string $key) : mixed;
}
