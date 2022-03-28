<?php
namespace Jp\Skud\Sdl\Net\Web;

use Jp\Skud\Sdl\Collection\Collection;
use Jp\Skud\Sdl\Collection\IReadonlyCollection;
use Jp\Skud\Sdl\Net\Http\HttpRequest;
use Jp\Skud\Sdl\Net\Http\HttpResponse;

/**
 * Http要求データを基に処理を行うコントローラクラスが実装すべきクラス
 */
abstract class ControllerBase
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var HttpRequest Http要求 */
    protected HttpRequest $request;

    /** @var HttpResponse Http応答 */
    protected HttpResponse $response;

    /** @var Collection カスタムパラメタ */
    protected Collection $parameters;






    // ================================================================
    // 抽象関数
    // ================================================================
    /**
     * 初期化処理
     */
    abstract public function initialize() : void;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     * オーバーライドする場合は、必ず親クラスのコンストラクタを実行すること。
     *
     * @param HttpRequest $request
     */
    public function __construct(HttpRequest $request)
    {
        // 変数初期化
        $this->request = $request;
        $this->response = new HttpResponse();
        $this->parameters = new Collection();
    }




    /**
     * Http応答を取得する。
     *
     * @return HttpResponse
     */
    public function httpResponse() : HttpResponse
    {
        return $this->response;
    }




    /**
     * Http要求を取得する。
     *
     * @return HttpRequest
     */
    public function httpRequest() : HttpRequest
    {
        return $this->request;
    }





    /**
     * 応答取得処理
     *
     * @return HttpResponse
     */
    public function respond() : void
    {
        $this->response->send();
    }




    /**
     * HEADメソッドでアクセスした際の処理内容
     */
    public function head() : void
    {
    }




    /**
     * GETメソッドでアクセスした際の処理内容
     */
    public function get() : void
    {
    }




    /**
     * POSTメソッドでアクセスした際の処理内容
     */
    public function post() : void
    {
    }




    /**
     * PUTメソッドでアクセスした際の処理内容
     */
    public function put() : void
    {
    }




    /**
     * DELETEメソッドでアクセスした際の処理内容
     */
    public function delete() : void
    {
    }




    /**
     * CONNECTメソッドでアクセスした際の処理内容
     */
    public function connect() : void
    {
    }




    /**
     * OPTIONSメソッドでアクセスした際の処理内容
     */
    public function options() : void
    {
    }




    /**
     * TRACEメソッドでアクセスした際の処理内容
     */
    public function trace() : void
    {
    }




    /**
     * PATCHメソッドでアクセスした際の処理内容
     */
    public function patch() : void
    {
    }




    /**
     * パラメタのコレクションを取得する。
     *
     * @return Collection
     */
    public function parameters() : Collection
    {
        return $this->parameters;
    }
}
