<?php
namespace Jp\Skud\Sdl\Net\Http;

use Jp\Skud\Sdl\ValueObject\IntValueObject;

/**
 * Httpステータスコードを表現するクラス
 */
CLASS HttpStatusCode extends IntValueObject
{
    // ================================================================
    // 定数
    // ================================================================
    /** Continue:100 */
    public const CONTINUE = 100;

    /** SwitchingProtocols:101*/
    public const SWITCHING_PROTOCOLS = 101;

    /** Processing:102 */
    public const PROCESSING = 102;

    /** EarlyHints:103 */
    public const EARLY_HINTS = 103;

    /** OK:200 */
    public const OK = 200;

    /** Created:201 */
    public const CREATED = 201;

    /** Accepted:202 */
    public const ACCEPTED = 202;

    /** NonAuthoritativeInformation:203 */
    public const NON_AUTHORITATIVE_INFORMATION = 203;

    /** NoContent:204 */
    public const NO_CONTENT = 204;

    /** ResetContent:205 */
    public const RESET_CONTENT = 205;

    /** PartialContent:206 */
    public const PARTIAL_CONTENT = 206;

    /** MultiStatus:207 */
    public const MULTI_STATUS = 207;

    /** AlreadyReported:208 */
    public const ALREADY_REPORTED = 208;

    /** IMUsed:226 */
    public const IM_USED = 226;

    /** MultipleChoices:300 */
    public const MULTIPLE_CHOICES = 300;

    /** MovedPermanently:301 */
    public const MOVED_PERMANENTLY = 301;

    /** Found:302 */
    public const FOUND = 302;

    /** SeeOther:303 */
    public const SEE_OTHER = 303;

    /** NotModified:304 */
    public const NOT_MODIFIED = 304;

    /** UseProxy:305 */
    public const USE_PROXY = 305;

    /** Unused:306 */
    public const UNUSED = 306;

    /** TemporaryRedirect:307 */
    public const TEMPORARY_REDIRECT = 307;

    /** PermanentRedirect:308 */
    public const PERMANENT_REDIRECT = 308;

    /** BadRequest:400 */
    public const BAD_REQUEST = 400;

    /** Unauthorized:401 */
    public const UNAUTHORIZED = 401;

    /** PaymentRequired:402 */
    public const PAYMENT_REQUIRED = 402;

    /** Forbidden:403 */
    public const FORBIDDEN = 403;

    /** NotFound:404 */
    public const NOT_FOUND = 404;

    /** MethodNotAllowed:405 */
    public const METHOD_NOT_ALLOWED = 405;

    /** NotAcceptable:406 */
    public const NOT_ACCEPTABLE = 406;

    /** ProxyAuthenticationRequired:407 */
    public const PROXY_AUTHENTICATION_REQUIRED = 407;

    /** RequestTimeout:408 */
    public const REQUEST_TIMEOUT = 408;

    /** Conflict:409 */
    public const CONFLICT = 409;

    /** Gone:410 */
    public const GONE = 410;

    /** LengthRequired:411 */
    public const LENGTH_REQUIRED = 411;

    /** PreconditionFailed:412 */
    public const PRECONDITION_FAILED = 412;

    /** PayloadTooLarge:413 */
    public const PAYLOAD_TOO_LARGE = 413;

    /** UriTooLong:414 */
    public const URI_TOO_LONG = 414;

    /** UnsupportedMediaType:415 */
    public const UNSUPPORTED_MEDIA_TYPE = 415;

    /** RangeNotSatisfiable:416 */
    public const RANGE_NOT_SATISFIABLE = 416;

    /** ExpectationFailed:417 */
    public const EXPECTATION_FAILED = 417;

    /** MisdirectedRequest:421 */
    public const MISDIRECTED_REQUEST = 421;

    /** UnprocessableEntity:422 */
    public const UNPROCESSABLE_ENTITY = 422;

    /** Locked:423 */
    public const LOCKED = 423;

    /** FailedDependency:424 */
    public const FAILED_DEPENDENCY = 424;

    /** TooEarly:425 */
    public const TOO_EARLY = 425;

    /** UpgradeRequired:426 */
    public const UPGRADE_REQUIRED = 426;

    /** PreconditionRequired:428 */
    public const PRECONDITION_REQUIRED = 428;

    /** TooManyRequests:429 */
    public const TOO_MANY_REQUESTS = 429;

    /** RequestHeaderFieldsTooLarge:431 */
    public const REQUEST_HEADER_FIELD_TOO_LARGE = 431;

    /** UnavailableForLegalReasons:451 */
    public const UNAVAILABLE_FOR_LEGAL_REASONS = 451;

    /** InternalServerError:500 */
    public const INTERNAL_SERVER_ERROR = 500;

    /** NotImplemented:501 */
    public const NOT_IMPLEMENTED = 501;

    /** BadGateway:502 */
    public const BAD_GATEWAY = 502;

    /** ServiceUnavailable:503 */
    public const SERVICE_UNAVAILABLE = 503;

    /** GatewayTimeout:504 */
    public const GATEWAY_TIMEOUT = 504;

    /** HttpVersionNotSupported:505 */
    public const HTTP_VERSION_NOT_SUPPORTED = 505;

    /** VariantAlsoNegotiates:506 */
    public const VARIANT_ALSO_NEGOTIATES = 506;

    /** InsufficientStorage:507 */
    public const INSUFFICIENT_STORAGE = 507;

    /** LoopDetected:508 */
    public const LOOP_DETECTED = 508;

    /** NotExtended:510 */
    public const NOT_EXTENDED = 510;

    /** NetworkAuthenticationRequired:511 */
    public const NETWORK_AUTHENTICATION_REQUIRED = 511;






    // ================================================================
    // 定数
    // ================================================================
    /** ステータスコードラベル定義 */
    protected const LABELS = [
        self::CONTINUE => 'Continue'
      , self::SWITCHING_PROTOCOLS => 'Switching Protocols'
      , self::PROCESSING => 'Processing'
      , self::EARLY_HINTS => 'Early Hints'
      , self::OK => 'OK'
      , self::CREATED => 'Created'
      , self::ACCEPTED => 'Accepted'
      , self::NON_AUTHORITATIVE_INFORMATION => 'Non-Authoritative Information'
      , self::NO_CONTENT => 'No Content'
      , self::RESET_CONTENT => 'Reset Content'
      , self::PARTIAL_CONTENT => 'Partial Content'
      , self::MULTI_STATUS => 'Multi-Status'
      , self::ALREADY_REPORTED => 'Already Reported'
      , self::IM_USED => 'IM Used'
      , self::MULTIPLE_CHOICES => 'Multiple Choices'
      , self::MOVED_PERMANENTLY => 'Moved Permanently'
      , self::FOUND => 'Found'
      , self::SEE_OTHER => 'See Other'
      , self::NOT_MODIFIED => 'Not Modified'
      , self::USE_PROXY => 'Use Proxy'
      , self::UNUSED => '(Unused)'
      , self::TEMPORARY_REDIRECT => 'Temporary Redirect'
      , self::PERMANENT_REDIRECT => 'Permanent Redirect'
      , self::BAD_REQUEST => 'Bad Request'
      , self::UNAUTHORIZED => 'Unauthorized'
      , self::PAYMENT_REQUIRED => 'Payment Required'
      , self::FORBIDDEN => 'Forbidden'
      , self::NOT_FOUND => 'Not Found'
      , self::METHOD_NOT_ALLOWED => 'Method Not Allowed'
      , self::NOT_ACCEPTABLE => 'Not Acceptable'
      , self::PROXY_AUTHENTICATION_REQUIRED => 'Proxy Authentication Required'
      , self::REQUEST_TIMEOUT => 'Request Timeout'
      , self::CONFLICT => 'Conflict'
      , self::GONE => 'Gone'
      , self::LENGTH_REQUIRED => 'Length Required'
      , self::PRECONDITION_FAILED => 'Precondition Failed'
      , self::PAYLOAD_TOO_LARGE => 'Payload Too Large'
      , self::URI_TOO_LONG => 'URI Too Long'
      , self::UNSUPPORTED_MEDIA_TYPE => 'Unsupported Media Type'
      , self::RANGE_NOT_SATISFIABLE => 'Range Not Satisfiable'
      , self::EXPECTATION_FAILED => 'Expectation Failed'
      , self::MISDIRECTED_REQUEST => 'Misdirected Request'
      , self::UNPROCESSABLE_ENTITY => 'Unprocessable Entity'
      , self::LOCKED => 'Locked'
      , self::FAILED_DEPENDENCY => 'Failed Dependency'
      , self::TOO_EARLY => 'Too Early'
      , self::UPGRADE_REQUIRED => 'Upgrade Required'
      , self::PRECONDITION_REQUIRED => 'Precondition Required'
      , self::TOO_MANY_REQUESTS => 'Too Many Requests'
      , self::REQUEST_HEADER_FIELD_TOO_LARGE => 'Request Header Fields Too Large'
      , self::UNAVAILABLE_FOR_LEGAL_REASONS => 'Unavailable For Legal Reasons'
      , self::INTERNAL_SERVER_ERROR => 'Internal Server Error'
      , self::NOT_IMPLEMENTED => 'Not Implemented'
      , self::BAD_GATEWAY => 'Bad Gateway'
      , self::SERVICE_UNAVAILABLE => 'Service Unavailable'
      , self::GATEWAY_TIMEOUT => 'Gateway Timeout'
      , self::HTTP_VERSION_NOT_SUPPORTED => 'HTTP Version Not Supported'
      , self::VARIANT_ALSO_NEGOTIATES => 'Variant Also Negotiates'
      , self::INSUFFICIENT_STORAGE => 'Insufficient Storage'
      , self::LOOP_DETECTED => 'Loop Detected'
      , self::NOT_EXTENDED => 'Not Extended'
      , self::NETWORK_AUTHENTICATION_REQUIRED => 'Network Authentication Required'
    ];






    // ================================================================
    // 関数
    // ================================================================
    /**
     * オブジェクトを文字列に変換する。
     *
     * @return string
     */
    public function toString() : string
    {
        if(!isset(static::LABELS[$this->value]))
        {
            return (string)$this->value;
        }

        return static::LABELS[$this->value];
    }
}
