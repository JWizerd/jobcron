<?php
/**
 * The logger class will interact with the php package Monolog
 * for handling error logs when they occur at runtime
 */

namespace JobCron\Utilities;

use Monolog\Logger as MonoLogger;
use Monolog\Handler\StreamHandler;

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

    public static function start() : void 
    {  
        try {
            self::$monolog = new MonoLogger(self::LOG_NAME);
            self::$monolog->pushHandler(new StreamHandler(self::LOG_FILE, MonoLogger::WARNING));
        } catch (Throwable $e) {
            print_r($e);
        }
    }

    public static function write(string $logType = 'error', string $logMessage) : void
    {
        self::start();

        try {
            if (array_key_exists($logType, self::$logTypes)) {
                self::$monolog->warning(
                    $logType,
                    [
                        'code' => self::$logTypes[$logType],
                        'message' => debug_backtrace()
                    ]
                );
            } else {
                throw new Exception('Log Type need to be strictly typed for optimal error reporting');
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
}