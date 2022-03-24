<?php
namespace Jp\Skud\SdlTest\IO;

use Jp\Skud\Sdl\IO\MimeType;
use PHPUnit\Framework\TestCase;

/**
 * [Jp\Skud\Sdl\IO\MimeType]の単体テストクラス
 */
final class MimeTypeTest extends TestCase
{
    // ================================================================
    // 正常系のテスト
    // ================================================================
    /**
     * バリデーションに関するテスト
     */
    public function testInitialize() : void
    {
        $validCases = [
            1 => ['x-example/example+text', 'x-example', 'example+text', 0]
          , 2 => ['x-example/prs.skud.example+text; k1=v1', 'x-example', 'prs.skud.example+text', 1]
          , 3 => ['x-example/prs.skud.sdl.example+text; k1=v1; k2=v2', 'x-example', 'prs.skud.sdl.example+text', 2]
        ];

        foreach($validCases as $caseNo => $case)
        {
            $mimeType = MimeType::from($case[0]);
            $this->assertNotNull($mimeType, "CaseNo.{$caseNo}");
            $this->assertSame($case[1], $mimeType->getTopLevelType(), "CaseNo.{$caseNo}");
            $this->assertSame($case[2], $mimeType->getSubType(), "CaseNo.{$caseNo}");
            $this->assertCount($case[3], $mimeType->parameters(), "CaseNo.{$caseNo}");
            $this->assertSame($case[0], $mimeType->toString(), "CaseNo.{$caseNo}");
        }

        $invalidCases = [
            1 => 'invalidType/prs.skud.sdl.example+text'
          , 2 => 'text'
          , 3 => '/plain'
        ];

        foreach($invalidCases as $caseNo => $case)
        {
            $mimeType = MimeType::from($case);
            $this->assertNull($mimeType, "CaseNo.{$caseNo}");
        }
    }
}
