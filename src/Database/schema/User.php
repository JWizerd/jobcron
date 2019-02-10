<?php 
namespace JobCron\Database\schema;
use JobCron\Database\schema\Base;


class User extends Base{
    function __construct() {
       return  parent::__construct();
    }

    function collection_name() {
        return "users";
    }
    
}

?>