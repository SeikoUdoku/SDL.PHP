<?php
namespace Jp\Skud\Sdl\Net\EMail\Mailer;

use Jp\Skud\Sdl\Net\EMail\IEMail;

/**
 * Eメール送信機能を提供するインタフェース
 */
interface IEMailSender
{
    // ================================================================
    // 抽象関数
    // ================================================================
    /**
     * Eメールを送信する。
     *
     * @param IEMail $email
     * @return bool
     */
    public function send(IEMail $email) : bool;
}
