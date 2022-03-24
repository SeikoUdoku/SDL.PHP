<?php
namespace Jp\Skud\Sdl\IO\FileSystem;

use Jp\Skud\Sdl\Collection\IReadonlyCollection;

/**
 * ディレクトリに関する機能を提供するインタフェース
 */
interface IDirectory
{
    // ================================================================
    // 抽象関数
    // ================================================================
    /**
     * ディレクトリまたは、ファイルが存在するか判定する。
     *
     * @param string $location
     * @return bool
     */
    public function hasItem(string $location) : bool;


    /**
     * ディレクト直下のディレクトリとファイルの一覧を取得する。
     *
     * @return IReadonlyCollection|(IDirectory|IFile)[]
     */
    public function getItems() : IReadonlyCollection;


    /**
     * ディレクトリが存在するか判定する。
     *
     * @param string $location
     * @return bool
     */
    public function hasDirectory(string $location) : bool;


    /**
     * ディレクトリ直下のディレクトリの一覧を取得する。
     *
     * @return IReadonlyCollection|IDirectory[]
     */
    public function getDirectories() : IReadonlyCollection;


    /**
     * ディレクトリを開く。
     *
     * @param string $location
     * @return static|null
     */
    public function tryOpenDirectory(string $location) : ?static;


    /**
     * ディレクトリを開く。
     *
     * @param string $location
     * @return static
     */
    public function openDirectory(string $location) : static;


    /**
     * ディレクトリを作成する。
     *
     * @param string $location
     * @return static
     */
    public function createDirectory(string $location) : static;


    /**
     * ファイルが存在するか判定する。
     *
     * @param string $location
     * @return bool
     */
    public function hasFile(string $location) : bool;


    /**
     * ディレクトリ直下のファイルの一覧を取得する。
     *
     * @return IReadonlyCollection|IFile[]
     */
    public function getFiles() : IReadonlyCollection;


    /**
     * ファイルを開く。
     *
     * @param string $location
     * @return IFile|null
     */
    public function tryOpenFile(string $location) : ?IFile;


    /**
     * ファイルを開く。
     *
     * @param string $location
     * @return IFile
     */
    public function openFile(string $location) : IFile;


    /**
     * ファイルを作成する。
     *
     * @param string $location
     * @return IFile
     */
    public function createFile(string $location) : IFile;


    /**
     * ディレクトリまたは、ファイルの名称を変更する。
     *
     * @param string $before
     * @param string $after
     * @return static
     */
    public function rename(string $before, string $after) : static;


    /**
     * ディレクトリまたは、ファイルを複製する。
     *
     * @param string $from
     * @param string $to
     * @return static
     */
    public function copy(string $from, string $to) : static;


    /**
     * ディレクトリまたは、ファイルを削除する。
     *
     * @param string $location
     * @return static
     */
    public function delete(string $location) : static;


    /**
     * ディレクトリが存在するか判定する。
     *
     * @param string $location
     * @return bool
     */
    public static function exists(string $location) : bool;


    /**
     * ディレクトリを開く。
     *
     * @param string $location
     * @return static|null
     */
    public static function tryOpen(string $location) : ?static;


    /**
     * ディレクトリを開く。
     *
     * @param string $location
     * @return static
     */
    public static function open(string $location) : static;


    /**
     * ディレクトリを開く。 (存在しない場合には作成する。)
     *
     * @param string $location
     * @return static
     */
    public static function openOrCreate(string $location) : static;


    /**
     * ディレクトリを作成する。
     *
     * @param string $location
     * @return static
     */
    public static function create(string $location) : static;
}
