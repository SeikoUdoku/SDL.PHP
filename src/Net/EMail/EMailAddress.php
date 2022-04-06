<?php
namespace Jp\Skud\Sdl\Net\EMail;

use Exception;

/**
 * Eメールアドレスを表現するクラス
 */
class EMailAddress
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var string Eメールアドレス */
    protected string $address = '';

    /** @var string 名前 */
    protected string $name = '';






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param string $address
     * @param string $name
     */
    public function __construct(string $address, string $name = '')
    {
        $this->setAddress($address);
        $this->setName($name);
    }




    /**
     * Eメールアドレスを取得する。
     *
     * @return string
     */
    public function getAddress() : string
    {
        return $this->address;
    }




    /**
     * Eメールアドレスを設定する。
     *
     * @param string $address
     * @return static
     */
    public function setAddress(string $address) : static
    {
        if(!self::isValidAddressFormat($address))
        {
            throw new Exception("Eメールアドレス[{$address}]の様式が不正です。");
        }

        $this->address = $address;
        return $this;
    }




    /**
     * 名前を取得する。
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }




    /**
     * 名前を設定する。
     *
     * @param string $name
     * @return static
     */
    public function setName(string $name) : static
    {
        $this->name = $name;
        return $this;
    }






    // ================================================================
    // 静的関数
    // ================================================================
    /**
     * 値からオブジェクトを作成する。
     *
     * @param string $address
     * @return static
     */
    public static function from(string $address) : static
    {
        return new static($address);
    }




    /**
     * Eメールアドレスが正しい様式であるか判定する。
     *
     * @param string $address
     * @return bool
     */
    public static function isValidAddressFormat(string $address) : bool
    {
        $result = filter_var($address, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE);

        return $result === $address;
    }
}
