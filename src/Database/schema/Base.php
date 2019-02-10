<?php 
declare(strict_types=1);

namespace JobCron\Database\schema;
use JobCron\App;

abstract class Base {
    private $connection;

    function __construct() {
        $connection = $this->getConnection();
        $get_collection = $this->collection_name();
        return $get_collection;
    }

    function getConnection(string $dbname) :  MongoDB\Database
    {
        if(empty($this->connection)) {
            $this->connection = App::get()->db();
        }
        return $this->connection;
    }

    abstract protected function collection_name();
    
}



?>