<?php
namespace JobCron;
require __DIR__ . '../../vendor/autoload.php';
require "./credentials.php";

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
        $credentials = require './credentials.php';
        $db = $credentials['mongo']['url'];
        $connection =  new Connection($db);
        //check if db exists/if not create
        $database_instance = $connection->selectDatabase($credentials['mongo']['db']);
        return $database_instance;
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


