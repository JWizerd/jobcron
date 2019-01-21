<?php
/**
 * The logger class will interact with the php package Monolog
 * for handling error logs when they occur at runtime
 *
 * Example: Logger::write('error', 'test', true, true);
 */

namespace JobCron\Utilities;

use Monolog\Logger as MonoLogger;
use Monolog\Handler\StreamHandler;

use JobCron\Utilities\Mailer;

use \Throwable;

// use Error;

class Logger 
{
    const LOG_FILE = '/var/www/html/error.log';
    const LOG_NAME = 'logger';

    private static $logTypes = [
        'debug' => 100,
        'info' => 200,
        'notice' => 250,
        'warning' => 300,
        'error' => 400,
        'critical' => 500,
        'alert' => 550,
        'emergency' => 600
    ];

    private static $monolog;

    private static function getInstance() : MonoLogger
    {  
        if (empty(self::$monolog)) {
            self::$monolog = new MonoLogger(self::LOG_NAME);
            self::$monolog->pushHandler(new StreamHandler(self::LOG_FILE, MonoLogger::WARNING));
            return self::$monolog;
        } else {
            return self::$monolog;
        }
    }

    public static function write(string $logType = 'error', string $logMessage, bool $backtrace, bool $notify = false) : void
    {
        $monolog = self::getInstance();

        try {
            if (array_key_exists($logType, self::$logTypes)) {

                $message['message'] = $logMessage;

                if ($backtrace) {
                    $message['stacktrace'] = debug_backtrace();
                }

                $monolog->warning(
                    $logType,
                    [
                        'code' => self::$logTypes[$logType],
                        'message' => $message
                    ]
                );

                if ($notify) {
                    self::notify($logType, json_encode($message));
                }
            } else {
                throw new Exception('Log Type need to be strictly typed for optimal error reporting');
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    public static function notify(string $logType = 'error', string $logMessage, $email = '') 
    {
        /**
         * @todo add User mongo document email address as fallback if email param isn't provided
         */
        $email = !empty($email) ?: 'jeremiah.wodke@gmail.com';

        $subject = sprintf(
            'JobCron Logger says: CODE %s - %s',
            self::$logTypes[$logType],
            $logType
        ); 

        Mailer::send($email, $subject, $logMessage);
    }


}