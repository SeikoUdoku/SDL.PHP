<?php
namespace Jp\Skud\Sdl\Net\Http;

use DomainException;
use Jp\Skud\Sdl\IO\FileSystem\IFile;
use Jp\Skud\Sdl\Text\StringUtil;

/**
 * アップロードされたファイルを表現するクラス
 */
class UploadFile
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var string アップロードファイル名 */
    protected string $sourceFileName = '';

    /** @var IFile ファイル */
    protected IFile $file;

    /** @var int エラーコード */
    protected $errorCode = UPLOAD_ERR_OK;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param string $sourceFileName
     * @param IFile $file
     * @param int $errorCode
     *
     * @throws DomainException
     */
    public function __construct(string $sourceFileName, IFile $file, int $errorCode)
    {
        if(StringUtil::isEmpty($sourceFileName))
        {
            throw new DomainException('元ファイル名を空文字とすることはできません。');
        }

        $this->sourceFileName = $sourceFileName;
        $this->file = $file;
        $this->errorCode = $errorCode;
    }




    /**
     * 元ファイル名を取得する。
     *
     * @return string
     */
    public function getSourceFileName() : string
    {
        return $this->sourceFileName;
    }




    /**
     * ファイルを取得する。
     *
     * @return IFile
     */
    public function file() : IFile
    {
        return $this->file;
    }




    /**
     * エラーコードを取得する。
     *
     * @return integer
     */
    public function getErrorCode() : int
    {
        return $this->errorCode;
    }




    /**
     * ファイルアップロードでエラーが発生しているか判定する。
     *
     * @return bool
     */
    public function occurredError() : bool
    {
        return !($this->errorCode === UPLOAD_ERR_OK);
    }
}
