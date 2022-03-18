<?php
namespace Jp\Skud\SdlTest;

use Jp\Skud\Sdl\StringUtil;
use PHPUnit\Framework\TestCase;
/**
 * [Jp\Skud\Sdl\StringUtil]の単体テストクラス
 */
final class StringUtilTest extends TestCase
{
    // ================================================================
    // 正常系のテスト
    // ================================================================
    /**
     * StringUtil::padding()のテスト
     */
    public function testPadding() : void
    {
        $cases = [
            1 => ['文字列', 5, ' ', STR_PAD_LEFT, null, false, '  文字列']
          , 2 => ['文字列', 5, ' ', STR_PAD_RIGHT, null, false, '文字列  ']
          , 3 => ['文字列', 5, ' ', STR_PAD_BOTH, null, false, ' 文字列 ']
          , 4 => ['文字列', 5, '　', STR_PAD_LEFT, null, false, '　　文字列']
          , 5 => ['文字列', 5, '　', STR_PAD_RIGHT, null, false, '文字列　　']
          , 6 => ['文字列', 5, '　', STR_PAD_BOTH, null, false, '　文字列　']
          , 7 => ['文字列', 5, '＿＝＊', STR_PAD_LEFT, null, false, '＿＝文字列']
          , 8 => ['文字列', 5, '＿＝＊', STR_PAD_RIGHT, null, false, '文字列＿＝']
          , 9 => ['文字列', 6, '＿＝＊', STR_PAD_BOTH, null, false, '＿文字列＿＝']
          , 10 => ['文字列', 7, '＿＝＊', STR_PAD_BOTH, null, false, '＿＝文字列＿＝']
          , 11 => ['文字列', 8, '＿＝＊', STR_PAD_BOTH, null, false, '＿＝文字列＿＝＊']
          , 12 => ['文字列', 4, '＿＊', STR_PAD_LEFT, null, false, '＿文字列']
          , 13 => ['文字列', 4, '＿＊', STR_PAD_RIGHT, null, false, '文字列＿']
          , 14 => ['文字列', 4, '＿＊', STR_PAD_BOTH, null, false, '文字列＿']
        ];

        foreach($cases as $caseNo => $case)
        {
            $this->assertSame(
                $case[6]
              , StringUtil::padding($case[0], $case[1], $case[2], $case[3], $case[4], $case[5])
              , "CaseNo.{$caseNo}"
            );
        }
    }




    /**
     * StringUtil::pascalize()のテスト
     */
    public function testPascalize() : void
    {
        $this->assertSame('PascalCase', StringUtil::pascalize('pascalCase'));
        $this->assertSame('PascalCase', StringUtil::pascalize('Pascal Case'));
        $this->assertSame('PascalCase', StringUtil::pascalize('pascal-case'));
        $this->assertSame('PascalCase', StringUtil::pascalize('pascal_case'));
    }




    /**
     * StringUtil::camelize()のテスト
     */
    public function testCamelize() : void
    {
        $this->assertSame('camelCase', StringUtil::camelize('CamelCase'));
        $this->assertSame('camelCase', StringUtil::camelize('Camel case'));
        $this->assertSame('camelCase', StringUtil::camelize('camel-case'));
        $this->assertSame('camelCase', StringUtil::camelize('camel_case'));
    }




    /**
     * StringUtil::snakify()のテスト
     */
    public function testSnakify() : void
    {
        $this->assertSame('snake_case', StringUtil::snakify('SnakeCase'));
        $this->assertSame('snake_case', StringUtil::snakify('Snake case'));
        $this->assertSame('snake_case', StringUtil::snakify('snake-case'));
        $this->assertSame('snake_case', StringUtil::snakify('snake_case'));
    }
}
