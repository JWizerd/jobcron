<? 
/**
 * The logger class will interact with the php package Monolog
 * for handling error logs when they occur at runtime
 */

namespace JobCron\Utilities;

use Error;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

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

    private $instance;

    public static function start()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Logger('logger');
            self::$instance->pushHandler(new StreamHandler(__DIR__ . self::LOG_NAME, Logger::WARNING));
            return $instance;
        } 
    }

    public static function write(string $logType = 'error', string $logMessage) : void
    {
        try {
            if (array_key_exists($logType, self::$logTypes)) {
                self::$instance->warning(
                    [
                        'type' => $logType,
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