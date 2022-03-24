<?php
namespace Jp\Skud\Sdl\IO\FileSystem;

use Jp\Skud\Sdl\IO\IStream;
use Jp\Skud\Sdl\IO\MimeType;

/**
 * ファイルに関する機能を提供するインタフェース
 */
interface IFile
{
    // ================================================================
    // 抽象関数
    // ================================================================
    /**
     * 絶対パスを取得する。
     *
     * @return string
     */
    public function getPath() : string;


    /**
     * 格納ディレクトリを取得する。
     *
     * @return IDirectory
     */
    public function directory() : IDirectory;


    /**
     * ファイル名(拡張子込み)を取得する。
     *
     * @return string
     */
    public function getBaseName() : string;


    /**
     * ファイル名(拡張子抜き)を取得する。
     *
     * @return string
     */
    public function getName() : string;


    /**
     * 拡張子を取得する。
     *
     * @return string
     */
    public function getExtension() : string;


    /**
     * ファイルサイズを取得する。
     *
     * @return int
     */
    public function getSize() : int;


    /**
     * MIME-Typeを取得する。
     *
     * @return MimeType
     */
    public function mimeType() : MimeType;


    /**
     * ストリームを取得する。
     *
     * @return IStream
     */
    public function stream() : IStream;


    /**
     * ファイルの内容を取得する。
     *
     * @return string
     */
    public function read() : string;


    /**
     * ファイルが存在するか判定する。
     *
     * @param string $location
     * @return bool
     */
    public static function exists(string $location) : bool;


    /**
     * ファイルを開く。
     *
     * @param string $location
     * @return static|null
     */
    public static function tryOpen(string $location) : ?static;


    /**
     * ファイルを開く。
     *
     * @param string $location
     * @return static
     */
    public static function open(string $location) : static;


    /**
     * ファイルを開く。 (存在しない場合には作成する。)
     *
     * @param string $location
     * @return static
     */
    public static function openOrCreate(string $location) : static;


    /**
     * ファイルを作成する。
     *
     * @param string $location
     * @return static
     */
    public static function create(string $location) : static;
}
