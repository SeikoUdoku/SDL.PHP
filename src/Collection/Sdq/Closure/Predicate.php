<?php
namespace Jp\Skud\Sdl\Collection\Sdq\Closure;

use ReflectionFunction;

/**
 * 比較器
 */
class Predicate extends ClosureBase
{
    // ================================================================
    // 関数
    // ================================================================
    /**
     * 比較処理を行う。
     *
     * @param int|string $key
     * @param mixed $value
     * @param mixed[] $options
     * @return bool
     */
    public function predicating(int|string $key, mixed $value, mixed ...$options) : bool
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
        if($refFnc->getReturnType()?->getName() !== 'bool')
        {
            return false;
        }


        return true;
    }
}
