<?php
namespace Jp\Skud\SdlTest\Collection;

use InvalidArgumentException;
use Jp\Skud\Sdl\Collection\Collection;
use Jp\Skud\Sdl\Collection\ElementNotFoundException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Throwable;

/**
 * [Jp\Skud\Collection\Collection]の単体テストクラス
 */
final class CollectionTest extends TestCase
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
        // コンストラクタのテスト
        $_ = new Collection();
        $_ = new Collection([]);
        $_ = new Collection(range(0, 999));


        // ::from()メソッドのテスト
        $_ = Collection::from([]);
        $_ = Collection::from(range(0, 999));
    }




    /**
     * 取得に関するテスト
     */
    public function testGetElement() : void
    {
        // 変数初期化
        $elements = [
            'A' => 0
          , 'B' => 1
          , 'C' => 2
          , 'D' => 3
          , 'E' => 4
        ];

        $collection = Collection::from($elements);


        // ::tryGet()メソッドのテスト
        $this->assertSame(0, $collection->tryGet('A'));
        $this->assertSame(null, $collection->tryGet('X'));
        $this->assertSame(-1, $collection->tryGet('X', -1));


        // ::get()メソッドのテスト
        $this->assertSame(1, $collection->tryGet('B'));

        try
        {
            $collection->get('X');
        }
        catch(Throwable $e)
        {
            $this->assertTrue($e instanceof ElementNotFoundException);
        }


        // 配列アクセスのテスト
        $this->assertSame(2, $collection['C']);

        try
        {
            $collection['X'];
        }
        catch(Throwable $e)
        {
            $this->assertTrue($e instanceof ElementNotFoundException);
        }
    }




    /**
     * 追加に関するテスト
     */
    public function testAddElement() : void
    {
        $collection = Collection::from([]);

        // ::add()メソッドのテスト
        $collection->add('A');
        $this->assertSame('A', $collection->get(0));
        $this->assertCount(1, $collection);


        // ::tryAdd()メソッドのテスト
        $collection->tryAdd('B', 1);

        $this->assertFalse($collection->tryAdd('X', 1));

        $this->assertSame('B', $collection->get(1));
        $this->assertCount(2, $collection);


        // ::setElement()メソッドのテスト
        $collection->setElement(2, 'C');
        $this->assertSame('C', $collection->get(2));
        $this->assertCount(3, $collection);


        // 配列アクセスのテスト
        $collection[3] = 'C';
        $this->assertSame('C', $collection->get(3));
        $this->assertCount(4, $collection);

        $collection[] = 'D';
        $this->assertSame('D', $collection->get(4));
        $this->assertCount(5, $collection);
    }




    /**
     * 更新に関するテスト
     */
    public function testUpdateElement() : void
    {
        $collection = Collection::from([
            0 => 'A'
          , 1 => 'B'
          , 2 => 'C'
          , 3 => 'D'
        ]);
        $expectSize = $collection->count();


        // ::update()メソッドのテスト
        $collection->update(0, 'Z');
        $this->assertSame('Z', $collection->get(0));
        $this->assertCount($expectSize, $collection);


        // ::tryUpdate()メソッドのテスト
        $collection->tryUpdate(1, 'Y');
        $this->assertSame('Y', $collection->get(1));
        $this->assertCount($expectSize, $collection);

        $this->assertFalse($collection->tryUpdate(-1, 'A'));


        // ::setElement()メソッドのテスト
        $collection->setElement(2, 'X');
        $this->assertSame('X', $collection->get(2));
        $this->assertCount($expectSize, $collection);


        // 配列アクセスのテスト
        $collection[3] = 'W';
        $this->assertSame('W', $collection->get(3));
        $this->assertCount($expectSize, $collection);
    }




    /**
     * 削除に関するテスト
     */
    public function testDeleteElement() : void
    {
        $collection = Collection::from([
            0 => 'A'
          , 1 => 'B'
          , 2 => 'C'
          , 3 => 'D'
        ]);
        $expectSize = $collection->count();


        // ::remove()メソッドのテスト
        $collection->remove(0);
        $this->assertCount(--$expectSize, $collection);
        $this->assertFalse($collection->containsKey('0'));


        // ::tryRemove()メソッドのテスト
        $this->assertFalse($collection->tryRemove(0));

        $collection->tryRemove(1);
        $this->assertCount(--$expectSize, $collection);
        $this->assertFalse($collection->containsKey('1'));


        // 配列アクセスのテスト
        unset($collection[0]);
        $this->assertCount($expectSize, $collection);

        unset($collection[2]);
        $this->assertCount(--$expectSize, $collection);
        $this->assertFalse($collection->containsKey('2'));
    }





    // ================================================================
    // 異常系のテスト
    // ================================================================
    /**
     * 配列形式での操作時に、不正な型のキーを用いた場合のテスト
     */
    public function testArrayAccessWithInvalidKeyType() : void
    {
        $collection = Collection::from(['A', 'B', 'C', 'D', 'E']);
        $keys = [
            null
          , 1.5
          , [0]
          , new stdClass()
          , function()
            {
                return 0;
            }
        ];


        foreach($keys as $key)
        {
            $isExpected = false;

            try
            {
                $_ = $collection[$key];
            }
            catch(Throwable $e)
            {
                $isExpected = ($e instanceof InvalidArgumentException);
            }

            $this->assertTrue($isExpected);
        }
    }
}
