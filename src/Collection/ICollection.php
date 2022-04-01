<?php
namespace Jp\Skud\Sdl\Collection;

use Countable;
use IteratorAggregate;

/**
 * コレクションに関する機能を提供するインタフェース
 */
interface ICollection extends Countable, IteratorAggregate
{
    // ================================================================
    // 関数
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
     * 要素の追加を試みる。
     *
     * @param mixed $value
     * @param int|string $key
     * @return bool
     */
    public function tryAdd(mixed $value, int|string $key) : bool;


    /**
     * 要素を追加する。
     *
     * @param int|string $key
     * @param mixed $mixed
     * @return static
     */
    public function add(mixed $mixed, int|string $key) : static;


    /**
     * 要素の更新を試みる。
     *
     * @param int|string $key
     * @param mixed $value
     * @return bool
     */
    public function tryUpdate(int|string $key, mixed $value) : bool;


    /**
     * 要素を更新する。
     *
     * @param int|string $key
     * @param mixed $value
     * @return static
     */
    public function update(int|string $key, mixed $value) : static;


    /**
     * 要素を設定する。
     *
     * @param int|string $key
     * @param mixed $value
     * @return static
     */
    public function setElement(int|string $key, mixed $value) : static;


    /**
     * 要素の削除を試みる。
     *
     * @param int|string $key
     * @return bool
     */
    public function tryRemove(int|string $key) : bool;


    /**
     * 要素を削除する。
     *
     * @param int|string $key
     * @return static
     */
    public function remove(int|string $key) : static;


    /**
     * 全ての要素を削除する。
     *
     * @return static
     */
    public function clear() : static;


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


    /**
     * キーのコレクションを取得する。
     *
     * @return static
     */
    public function keys() : static;


    /**
     * 要素のコレクションを取得する。
     *
     * @return static
     */
    public function values() : static;
}
