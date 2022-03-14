<?php
namespace Jp\Skud\SdlTest\Collection\Sdq\Closure;

use Jp\Skud\Sdl\Collection\Sdq\Closure\Joiner;
use Jp\Skud\Sdl\NotSupportedException;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * [Jp\Skud\Sdl\Collection\Sdq\Closure\Joiner]の単体テストクラス
 */
final class JoinerTest extends TestCase
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
        $_ = Joiner::from(static::class.'::join');
        $_ = Joiner::from(function() : bool { return true; });
        $_ = Joiner::from(function($k1, $k2, $v1, $v2) : array { return []; });
        $_ = Joiner::from(function($k1, $k2, $v1, $v2, $o = null) : array { return []; });
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
          , function() {}
          , function() : void {}
          , function($k1, $k2, $v1, $v2, $o1) : string { return ''; }
          , function($k1, $k2, $v1, $v2, $o1, $o2 = null) : int { return 1; }
        ];

        foreach($cases as $case)
        {
            $isExpected = false;

            try
            {
                $_ = Joiner::from($case);
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
     * @return array
     */
    public static function join() : array
    {
        return [];
    }
}
