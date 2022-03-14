<?php
namespace Jp\Skud\Sdl\Collection\Sdq\Closure;

use ReflectionFunction;

/**
 * 結合器
 */
class Joiner extends ClosureBase
{
    // ================================================================
    // 関数
    // ================================================================
    /**
     * 結合処理を行う。
     *
     * @param int|string $key1
     * @param mixed $value1
     * @param int|string $key2
     * @param mixed $value2
     * @param mixed[] $options
     * @return bool
     */
    public function join(int|string $key1, mixed $value1, int|string $key2, mixed $value2, mixed ...$options) : bool
    {
        return ($this->function)($key1, $value1, $key2, $value2, ...$options);
    }






    // ================================================================
    // 静的関数
    // ================================================================
    /**
     * @inheritDoc
     */
    final protected static function isValidFunction(callable $selector) : bool
    {
         // 変数定義
        $refFnc = new ReflectionFunction($selector);


        // 引数の検証
        $parameters = $refFnc->getParameters();
        if(count($parameters) > 4 && !$parameters[4]->isOptional())
        {
            return false;
        }


        // 戻り値の検証
        if($refFnc->getReturnType() === null || $refFnc->getReturnType()?->getName() === 'void')
        {
            return false;
        }


        return true;
    }
}
