<?php
namespace Jp\Skud\SdlTest\Collection\Sdq\Closure;

use Jp\Skud\Sdl\Collection\Sdq\Closure\Predicate;
use Jp\Skud\Sdl\NotSupportedException;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * [Jp\Skud\Sdl\Collection\Sdq\Closure\Predicate]の単体テストクラス
 */
final class PredicateTest extends TestCase
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
        $_ = Predicate::from(static::class.'::predicating');
        $_ = Predicate::from(function() : bool { return true; });
        $_ = Predicate::from(function($k, $v) : bool { return true; });
        $_ = Predicate::from(function($k, $v, $o = null) : bool { return true; });
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
          , function() : string { return ''; }
          , function() : int { return 0; }
          , function() {}
          , function() : void {}
          , function($k, $v, $o1) : bool { return true; }
          , function($k, $v, $o1, $o2 = null) : bool { return true; }
        ];

        foreach($cases as $case)
        {
            $isExpected = false;

            try
            {
                $_ = Predicate::from($case);
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
    public static function predicating() : bool
    {
        return true;
    }
}
