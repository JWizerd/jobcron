<?php
namespace JobCron;
require __DIR__ . '../../vendor/autoload.php';

use MongoDB\Client as Connection;

use JobCron\Utilities\Logger;
use JobCron\Utilities\CredentialsManager;

/* access db connection like so: App::get()->db(); */
class App 
{
    // Hold an instance of the class
    private static $instance;

    public static function db() 
    {
        return new Connection(
            CredentialsManager::get('mongo')['url']
        );
    }

    /**
     * Create the App singleton 
     */
    public static function get() 
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}

require 'router.php';


// print_r($connection);

// $collection = (new MongoDB\Client($dburl))->example->users;

// $result = $collection->insertMany([
//   [
//     'answer' => '42',
//     'color' => 'purple',
//     'mad' => 'wire'
//   ],
//   [
//     'elite' => '1337',
//     'color' => 'C0L0|2',
//     'foobar' => 'f00b4|2',
//     'mad' => 'm4d'
//   ],
// ]);

// hprint("Inserted " . $result->getInsertedCount() . " document(s)");

// hprint("Let's checkout the document with 'mad' -> 'wire' ...");

// $doc = $collection->findOne(['mad' => 'wire']);

// var_dump($doc);

// hprint("That might look better formatted...");

// foreach($doc as $key => $value) {
//   hprint($key . "-> " . $value);
// }



