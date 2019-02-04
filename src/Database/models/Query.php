<?php 
namespace JobCron\Database\models;
use JobCron\Database\Connection;

class Query extends Base {
    public function __construct() {
        parent::__construct();
        $this->set_collection($this->getTableName());
    }

    function getTableName() {
        return "query";
    }
}

?>