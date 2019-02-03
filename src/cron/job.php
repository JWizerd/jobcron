<?php
// ex: run cron every 15 minutes
// * */2 * * * tail -f php /var/www/html/cron/job.php JobsController indeed
require __DIR__ . '../../../vendor/autoload.php';

use JobCron\Controllers\JobsController;
use JobCron\Utilities\Logger;
use JobCron\Utilities\Mailer;

$action = $argv[1];

try {
    $class = "JobCron\Controllers\JobsController";

    // must be an instance of controller and have an action
    if (class_exists($class) && method_exists($class, $action)) {
        (new JobsController)->$action();
    } else {
        throw new Exception(
            "{$class} doesn't exist or method
            {$method} doesn't exist in class"
        );
    }
} catch(Throwable $e) {
    Logger::write($e, 'critical', true, true);
}