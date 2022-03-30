<?php
namespace Jp\Skud\Sdl\Net\Web;

use DomainException;
use Exception;
use Jp\Skud\Sdl\Collection\Collection;
use Jp\Skud\Sdl\Net\Http\HttpRequest;
use Jp\Skud\Sdl\Net\Uri;
use Jp\Skud\Sdl\Text\StringUtil;

/**
 * Http要求データを基に処理コントローラへの振向処理を行うクラス
 */
class Router
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var Collection|ControllerBase[] コントローラ辞書 */
    protected Collection $controllers;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->controllers = new Collection();
    }




    /**
     * ルーティング規則を追加する。
     *
     * @param string $uriRegexPattern
     * @param string $controllerName
     * @return static
     *
     * @throws DomainException
     */
    public function addRule(string $uriRegexPattern, string $controllerName) : static
    {
        // 検証
        if(StringUtil::isEmpty($uriRegexPattern))
        {
            throw new DomainException('リクエストURIパターンを空文字とすることはできません。');
        }

        if(!class_exists($controllerName))
        {
            throw new DomainException("コントローラクラス({$controllerName})が存在しません。");
        }

        if(!is_a($controllerName, ControllerBase::class, true))
        {
            throw new DomainException(
                "コントローラクラス[{$controllerName}]は、[".ControllerBase::class."]を実装していなければなりません。"
            );
        }


        // 追加処理
        $this->controllers->setElement($uriRegexPattern, $controllerName);

        return $this;
    }




    /**
     * 対応する要求処理コントローラを取得する。
     *
     * @param Uri $routingUri
     * @param HttpRequest $request
     * @return ControllerBase|null
     */
    public function getControllerInstance(Uri $routingUri, HttpRequest $request) : ?ControllerBase
    {
        // 取得処理
        $controller = null;

        foreach($this->controllers as $uriRegexPattern => $controllerClassName)
        {
            $matches = [];
            $result = preg_match($uriRegexPattern, $routingUri, $matches);
            if($result === 1)
            {
                /** @var ControllerBase $controller */
                $controller = new $controllerClassName($request);
                $controller->parameters()->add(new Collection($matches), '__Router_MatchesOnRouting');
            }
            elseif($result === false)
            {
                throw new Exception("ルーティング処理中の正規表現マッチングでエラーが発生しました。[パターン:{$uriRegexPattern}]");
            }
        }


        return $controller;
    }
}
