<?php
namespace Jp\Skud\Sdl\Collection\Sdq\Closure;

use ReflectionFunction;

/**
 * 射影器
 */
class Selector extends ClosureBase
{
    // ================================================================
    // 関数
    // ================================================================
    /**
     * 射影処理を行う。
     *
     * @param int|string $key
     * @param mixed $value
     * @param mixed[] $options
     * @return bool
     */
    public function select(int|string $key, mixed $value, mixed ...$options) : bool
    {
        return ($this->function)($key, $value, ...$options);
    }






    // ================================================================
    // 静的関数
    // ================================================================
    /**
     * @inheritDoc
     */
    final protected static function isValidFunction(callable $predicate) : bool
    {
        // 変数定義
        $refFnc = new ReflectionFunction($predicate);


        // 引数の検証
        $parameters = $refFnc->getParameters();
        if(count($parameters) > 2 && !$parameters[2]->isOptional())
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
