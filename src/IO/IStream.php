<?php
namespace Jp\Skud\Sdl\IO;

/**
 * ストリームに関する機能を提供するインタフェース
 */
interface IStream
{
    // ================================================================
    // 抽象関数
    // ================================================================
    /**
     * 対象リソースのストリームを開く
     *
     * @param string $location
     * @param string $mode
     * @return static
     */
    public static function open(string $location, string $mode) : static;


    /**
     * 現在のストリームを閉じ、対象リソースを開放する。
     */
    public function close() : void;


    /**
     * 対象リソースに対するロックを取得する。
     *
     * @param LockMode $mode
     * @param LockModeModification[] $modeModifications
     * @return static
     */
    public function lock(LockMode $mode, array $modeModifications = []) : static;


    /**
     * 対象リソースのロックを開放する。
     *
     * @return static
     */
    public function unlock() : static;


    /**
     * ポインタ位置から指定バイト数分を読み込む。
     *
     * @param int $length
     * @return string
     */
    public function read(int $length) : string;


    /**
     * ポインタ位置がストリームの終端に達したか判定する。
     *
     * @return bool
     */
    public function eof() : bool;


    /**
     * ポインタを指定位置に移動する。
     *
     * @param int $offset
     * @return static
     */
    public function seek(int $offset) : static;


    /**
     * ポインタの現在位置を取得する。
     *
     * @return int
     */
    public function tell() : int;


    /**
     * 対象リソースを指定長に設定する。
     *
     * @param int $size
     * @return static
     */
    public function truncate(int $size) : static;


    /**
     * ポインタを先頭に戻す。
     *
     * @return static
     */
    public function rewind() : static;


    /**
     * バッファに書き込みを行う。
     *
     * @param string $content
     * @return static
     */
    public function write(string $content) : static;


    /**
     * 現在のバッファの内容をクリアし、対象リソースに書き込む。
     *
     * @return static
     */
    public function flush() : static;
}
