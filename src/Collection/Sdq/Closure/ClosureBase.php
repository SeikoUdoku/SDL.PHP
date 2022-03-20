<?php
namespace Jp\Skud\Sdl\Collection\Sdq\Closure;

use Closure;
use Jp\Skud\Sdl\NotSupportedException;

/**
 * Sdqのクロージャを表現する抽象クラス
 */
abstract class ClosureBase
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var Closure $function 関数 */
    protected Closure $function;






    // ================================================================
    // 抽象関数
    // ================================================================
    /**
     * 関数が仕様に準じているか判定する。
     *
     * @param callable $function
     * @return bool
     */
    abstract protected static function isValidFunction(callable $function) : bool;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param Closure $function
     *
     * @throws NotSupportedException
     */
    public function __construct(Closure $function)
    {
        if(!static::isValidFunction($function))
        {
            throw new NotSupportedException('不正な仕様の選択関数です。');
        }

        $this->function = $function;
    }




    /**
     * @inheritDoc
     */
    final public function __invoke(mixed ...$values) : mixed
    {
        return ($this->function)(...$values);
    }






    // ================================================================
    // 静的関数
    // ================================================================
    /**
     * オブジェクトを作成する。
     *
     * @param callable $function
     * @return static
     */
    public static function from(callable $function) : static
    {
        if(!($function instanceof Closure))
        {
            $function = Closure::fromCallable($function);
        }

        return new static($function);
    }
}
