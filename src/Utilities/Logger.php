<?php
/**
 * The logger class will interact with the php package Monolog
 * for handling error logs when they occur at runtime
 */

namespace JobCron\Utilities;

use Monolog\Logger as MonoLogger;
use Monolog\Handler\StreamHandler;

// use Error;

class Logger 
{
    const LOG_FILE = 'error.log';
    const LOG_NAME = 'logger';

    private $logTypes = [
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

    public static function start()
    {
        if (!isset(self::$monolog)) {
            self::$monolog = new MonoLogger('logger');
            self::$monolog->pushHandler(new StreamHandler(__DIR__ . self::LOG_NAME, MonoLogger::WARNING));
            return self::$monolog;
        } 
    }

    public static function write(string $logType = 'error', string $logMessage) : void
    {
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