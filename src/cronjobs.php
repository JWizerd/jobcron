<?php
// ex: run cron every 15 minutes
// * */2 * * * tail -f php /var/www/html/cron/job.php JobsController indeed

require __DIR__ . '../../vendor/autoload.php';

use JobCron\Controllers\JobsController;
use JobCron\Utilities\Logger;
use JobCron\Utilities\Mailer;

$job = $argv[1];
$action = $argv[2];

try {
    (new $job())->$action();
} catch(Throwable $e) {
    Logger::write($e->getMessage(), 'critical', true, true);
}