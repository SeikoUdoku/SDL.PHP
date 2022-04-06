<?php
namespace Com\Sugiharu\Raven\Library\Net\EMail\Mailer;

use Jp\Skud\Sdl\Collection\Collection;
use Jp\Skud\Sdl\Net\EMail\IEMail;
use Jp\Skud\Sdl\Net\EMail\Mailer\IEMailSender;
use Jp\Skud\Sdl\Text\StringUtil;
use Symfony\Component\Mailer\Transport as SymTransport;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Address as SymAddress;
use Symfony\Component\Mime\Email as SymEMail;
use Symfony\Component\Mime\Header\Headers as SymHeaders;

/**
 * Eメール送信機能を提供するクラス
 */
class EMailSender implements IEMailSender
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var TransportInterface */
    protected TransportInterface $mailer;

    /** @var Collection|string[] Eメールアドレスに対応するDSNの辞書 */
    protected static Collection $eMailAddressDsnDic;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param TransportInterface $mailer
     */
    protected function __construct(TransportInterface $mailer)
    {
        $this->mailer = $mailer;
    }




    /**
     * @inheritDoc
     */
    public function send(IEMail $email) : bool
    {
        // Eメールコンテンツの作成
        $symEMail = new SymEMail();

        // ヘダーの設定
        $symHeaders = new SymHeaders();
        $symEMail->setHeaders($symHeaders);
        foreach($email->headers() as $hKey => $hValue)
        {
            $symHeaders->addHeader((string)$hKey, $hValue);
        }

        // 送信元の設定
        foreach($email->fromAddresses() as $address)
        {
            $symAddress = new SymAddress($address->getAddress(), $address->getName());
            $symEMail->addFrom($symAddress);
        }

        // Reply-Toの設定
        foreach($email->replyAddresses() as $address)
        {
            $symAddress = new SymAddress($address->getAddress(), $address->getName());
            $symEMail->addReplyTo($symAddress);
        }

        // 送信先(To)の設定
        foreach($email->toAddresses() as $address)
        {
            $symAddress = new SymAddress($address->getAddress(), $address->getName());
            $symEMail->addTo($symAddress);
        }

        // 送信先(Cc)の設定
        foreach($email->ccAddresses() as $address)
        {
            $symAddress = new SymAddress($address->getAddress(), $address->getName());
            $symEMail->addCc($symAddress);
        }

        // 送信先(Bcc)の設定
        foreach($email->bccAddresses as $address)
        {
            $symAddress = new SymAddress($address->getAddress(), $address->getName());
            $symEMail->addBcc($symAddress);
        }

        // 件名の設定
        $symEMail->subject($email->getSubject());

        // 本文の設定
        if($email->htmlContent() !== null)
        {
            $symEMail->html($email->htmlContent()->getContent());
        }

        if($email->plainTextContent() !== null)
        {
            $symEMail->text($email->plainTextContent()->getContent());
        }


        // 送信処理
        $result = $this->mailer->send($symEMail);
        return $result !== null;
    }






    // ================================================================
    // 静的関数
    // ================================================================
    /**
     * DSN文字列からEメール送信クラスを取得する。
     *
     * @param string $dsn
     * @return static
     */
    public static function from(string $dsn) : static
    {
        return new static(SymTransport::fromDsn($dsn));
    }




    /**
     * EメールアドレスからEメール送信クラスを取得する。
     *
     * @param string $dsn
     * @return static|null
     */
    public static function fromByEMailAddress(string $address) : ?static
    {
        $dsn = '';

        if(isset(static::eMailAddressDsnDictionary()[$address]))
        {
            $dsn = static::eMailAddressDsnDictionary()[$address];
        }

        if(StringUtil::isEmpty($dsn))
        {
            return null;
        }

        return static::from($dsn);
    }




    /**
     * Eメールアドレスに対応するDSNの辞書を取得する。
     *
     * @return Collection
     */
    public static function eMailAddressDsnDictionary() : Collection
    {
        if(!isset(static::$eMailAddressDsnDic))
        {
            static::$eMailAddressDsnDic = new Collection();
        }

        return static::$eMailAddressDsnDic;
    }
}
