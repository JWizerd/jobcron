<?
/**
 * this class will be used to connect to the mongo instance
 * it should only return an mongo db instance to interface 
 * with the db. It should not handle data operations only access.
 */

use MongoDB\Client as Mongo;

class Connection 
{
    private $connection;

    public function __construct() 
    {
        $this->setConnection();
    }

    private function setConnection() 
    {
        if (getenv('dbname')) {
            $dbUrl = sprintf(
              "mongodb://%s:27017",
              getenv('dbname')
            );

            $this->connection = new MongoDB\Client($dburl);
        } else {
            /** either log error or monlog entry here indicated issue connecting */
        }
    }

    public function get() {
        if (empty($this->connection)) {
            $this->setConnection();
            return $this->connection;
        }

        return $this->connection;
    }   
}