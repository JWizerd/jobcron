<?

use Database\Connection;

require __DIR__ . '../../vendor/autoload.php';

$dburl = "mongodb://" . getenv('dbname') . ":27017";

