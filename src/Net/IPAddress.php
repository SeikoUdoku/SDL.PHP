<?php
namespace Jp\Skud\Sdl\Net;

use DomainException;
use Stringable;

/**
 * IPアドレスを表現するクラス
 */
class IPAddress implements Stringable
{
    // ================================================================
    // 定数
    // ================================================================
    /** ANY(IPv4) */
    public const ANY_IPV4 = '0.0.0.0';

    /** ANY(IPv6) */
    public const ANY_IPV6 = '::';






    // ================================================================
    // 変数
    // ================================================================
    /** @var string IPアドレス(IN_ADDR形式) */
    protected string $ipAddr = '';






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param string $ipAddr
     *
     * @throws DomainException
     */
    public function __construct(string $ipAddr)
    {
        if(!self::validate($ipAddr))
        {
            throw new DomainException("IPアドレス[{$ipAddr}]の様式が不正です。");
        }

        $this->ipAddr = inet_pton($ipAddr);
    }




    /**
     * 文字列表現を取得する。
     *
     * @return string
     */
    public function toString() : string
    {
        return (string)inet_ntop($this->ipAddr);
    }




    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return $this->toString();
    }






    // ================================================================
    // 静的関数
    // ================================================================
    /**
     * IPアドレスの形式が正しいか判定する。
     *
     * @param string $ipAddr
     * @return bool
     */
    public static function validate(string $ipAddr) : bool
    {
        if(inet_pton($ipAddr) === false)
        {
            return false;
        }

        return true;
    }
}
