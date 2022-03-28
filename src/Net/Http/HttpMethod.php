<?php
namespace Jp\Skud\Sdl\Net\Http;

use Jp\Skud\Sdl\ValueObject\StringValueObject;

/**
 * Httpメソッドを表現するクラス
 */
class HttpMethod extends StringValueObject
{
    // ================================================================
    // 定数
    // ================================================================
    /** HEADメソッド */
    public const HEAD = 'HEAD';

    /** GETメソッド */
    public const GET = 'GET';

    /** POSTメソッド */
    public const POST = 'POST';

    /** PUTメソッド */
    public const PUT = 'PUT';

    /** DELETEメソッド */
    public const DELETE = 'DELETE';

    /** CONNECTメソッド */
    public const CONNECT = 'CONNECT';

    /** OPTIONSメソッド */
    public const OPTIONS = 'OPTIONS';

    /** TRACEメソッド */
    public const TRACE = 'TRACE';

    /** PATCHメソッド */
    public const PATCH = 'PATCH';
}
