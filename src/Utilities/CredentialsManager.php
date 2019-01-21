<?php

namespace JobCron\Utilities;

class CredentialsManager {
    public static function get($type) 
    {
        $creds = require '/var/www/html/credentials.php';

        try {
            if (array_key_exists($type, $creds)) {
                return $creds[$type];
            } 

            throw new Exception("Credentials for ${get_class($this)}");

        } catch (Exception $e) {
            /* @TODO implement monolog */
            return '';
        }
    }
}