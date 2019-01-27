<?php
/**
 * A mailgun facade to easily send email noticiations without having to worry about
 * mailgun configuration and instantiation
 *
 * Example:
 * Mailer::send('test@email.com', 'subject', 'message body');
 */

namespace JobCron\Utilities;

use Mailgun\Mailgun;
use Mailgun\Model\Message\SendResponse;

use \Exception;
use \Throwable;

class Mailer 
{
    /**
     * send notication to mailgun
     * @param  array  $emailBody title, message body 
     * @param  [type] $email        who to send to, probably the signed in users email
     * @return [type]            the message response
     */
    public static function send(string $email, string $subject, string $message) : void
    {
        $creds = self::getCreds();
        $mailgun = self::getMailgun($creds['key']);

        $msg = [
            'from' => $email,
            'to' => $email,
            'subject' => $subject,
            'html' => $message
        ];

        try {              
            $response = $mailgun->messages()->send($creds['domain'], $msg);

            if (!$response instanceof SendResponse) {
                throw new Exception('Mailgun request was unsuccessful');
            }
        } catch (Throwable $e) {
            print_r($e);
        }
    }

    private static function getCreds() : array
    {
        try {
            return CredentialsManager::get('mailgun');
        } catch(Throwable $e) {
            print_r($e->getMessage());
            return [];
        }
    }

    private static function getMailgun($key)
    {
        try {
            if(!empty(self::getCreds())) {
                return Mailgun::create($key);
            } else {
                throw new Exception(
                    'credentials could not be located when trying to set mailgun instance.'
                );
            }
        } catch (Throwable $e) {
            print_r($e->getMessage());
        }
    }
}

