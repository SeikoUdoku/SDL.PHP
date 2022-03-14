<?php
namespace Jp\Skud\SdlTest\Collection\Sdq\Closure;

use Jp\Skud\Sdl\Collection\Sdq\Closure\Selector;
use Jp\Skud\Sdl\NotSupportedException;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * [Jp\Skud\Sdl\Collection\Sdq\Closure\Selector]の単体テストクラス
 */
final class SelectorTest extends TestCase
{
    // ================================================================
    // 正常系のテスト
    // ================================================================
    /**
     * 初期化に関するテスト
     *
     * @doesNotPerformAssertions
     */
    public function testInitializer() : void
    {
        $_ = Selector::from(static::class.'::select');
        $_ = Selector::from(function() : string { return ''; });
        $_ = Selector::from(function($k, $v) : array { return []; });
        $_ = Selector::from(function($k, $v, $o = null) : bool { return true; });
    }






    // ================================================================
    // 異常系のテスト
    // ================================================================
    /**
     * 初期化に関するテスト
     */
    public function testUnSupportedFunction() : void
    {
        $cases = [
            function() { return true; }
          , function() { return null; }
          , function() {}
          , function() : void {}
          , function($k, $v, $o1) : int { return 0; }
          , function($k, $v, $o1, $o2 = null) : array { return []; }
        ];

        foreach($cases as $case)
        {
            $isExpected = false;

            try
            {
                $_ = Selector::from($case);
            }
            catch(Throwable $e)
            {
                $isExpected = $e instanceof NotSupportedException;
            }

            $this->assertTrue($isExpected);
        }
    }






    // ================================================================
    // その他・関数
    // ================================================================
    /**
     * テスト用のサンプル関数
     *
     * @return bool
     */
    public static function select() : int
    {
        return 0;
    }
}
