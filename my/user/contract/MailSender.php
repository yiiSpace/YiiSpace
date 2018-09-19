<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/11/5
 * Time: 22:27
 */

namespace my\user\contract;

/**
 * Interface MailSender
 * @package my\user\contract
 */
interface MailSender
{

    /**
     * Sends an account activation e-mail message.
     *
     * @param array $config mail configurations.
     * @return boolean whether the mail was sent successfully.
     */
    public function sendActivationMail(array $config = []);

    /**
     * Sends an account reset password e-mail message.
     *
     * @param array $config mail configurations.
     * @return boolean whether the mail was sent successfully.
     */
    public function sendResetPasswordMail(array $config = []);
}