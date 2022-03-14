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
     * 要素の取得を試みる。
     *
     * @param int|string $key
     * @param mixed $default
     * @return mixed
     */
    public function tryGet(int|string $key, mixed $default = null) : mixed;


    /**
     * 要素を取得する。
     *
     * @param int|string $key
     * @return mixed
     */
    public function get(int|string $key) : mixed;


    /**
     * 特定のキーが含まれるか判定する。
     *
     * @param int|string $key
     * @return bool
     */
    public function containsKey(int|string $key) : bool;


    /**
     * 特定の値が含まれるか判定する。
     *
     * @param mixed $value
     * @return bool
     */
    public function containsValue(mixed $value) : bool;
}
