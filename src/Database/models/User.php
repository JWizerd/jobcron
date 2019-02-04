<?php 
namespace JobCron\Database\models;
use JobCron\Database\Connection;

class User extends Base {
    public function __construct() {
        parent::__construct();
        $this->set_collection($this->getTableName());
    }

    function getTableName() {
        return "users";
    }
}

?>