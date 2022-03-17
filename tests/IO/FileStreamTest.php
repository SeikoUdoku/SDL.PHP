<?php
namespace Jp\Skud\SdlTest\IO;

use Jp\Skud\Sdl\IO\IOException;
use Jp\Skud\Sdl\IO\LockMode;
use Jp\Skud\Sdl\IO\LockModeModification;
use Jp\Skud\Sdl\IO\Stream;
use PHPUnit\Framework\TestCase;

/**
 * [Jp\Skud\Sdl\IO\FileStream]の単体テストクラス
 */
final class FileStreamTest extends TestCase
{
    // ================================================================
    // 定数
    // ================================================================
    /** テストファイルの作成場所 */
    private const TEST_FILE_DIR = __DIR__.'/../../variants/temp/test';




    // ================================================================
    // 正常系のテスト
    // ================================================================
    /**
     * ロックに関するテスト
     */
    public function testLockFunctions() : void
    {
        // 変数初期化
        $fileName = md5((string)microtime()).'.temp';
        $location = static::TEST_FILE_DIR.'/'.$fileName;
        $stream = Stream::open($location , 'c+');
        $this->fileExists($location);


        // 共有ロックのテスト
        $stream->lock(LockMode::Shared);

        $tStream = Stream::open($location, 'r');
        $tStream->lock(LockMode::Shared);
        unset($tStream);



        // 排他ロックのテスト
        $stream->lock(LockMode::Exclusive);;
        $tStream = Stream::open($location, 'r');
        $isExpected = false;
        try
        {
            $tStream->lock(LockMode::Shared, [LockModeModification::NotBlock]);
        }
        catch(IOException $e)
        {
            $isExpected = true;
        }
        $this->assertTrue($isExpected);

        $tStream->unlock();
        unset($tStream);


        // ファイル削除
        unlink($location);
    }




    /**
     * 書込みに関するテスト
     *
     * @return void
     */
    public function testWrite() : void
    {
        // 変数初期化
        $fileName = md5((string)microtime()).'.temp';
        $location = static::TEST_FILE_DIR.'/'.$fileName;
        $stream = Stream::open($location , 'c+');


        // ファイル書込み処理
        $content = static::class;
        $contentBytes = strlen(static::class);
        $writtenBytes = 0;

        $stream->lock(LockMode::Exclusive);

        $stream->write($content, null, $writtenBytes);
        $stream->flush();
        $this->assertSame($contentBytes, $stream->tell());
        $stream->rewind();
        $this->assertSame($content, $stream->readAll(1));
        $this->assertSame($contentBytes, $writtenBytes);


        // ファイル削除
        unlink($location);
    }
}
