<?php 
namespace JobCron\Database\models;
use JobCron\App;
use JobCron\Utilities\CredentialsManager;

class Base {
    private $database_connection;

    private $collection_connection;
    //connect to the database
    protected function __construct() {
        if(empty($this->database_connection)) {
          $this->database_connection = App::get()->db()->{$this->getDB()};
          $this->init();
        }
    }

    //connect to the appropriate collection
    private function init() {
        $this->get_collection();
    }

    private function getDB() {
        return CredentialsManager::get('mongo')['db'];
    }


    protected function set_collection(string $collection_name) {
        if(empty($this->collection_connection)) {
            $this->collection_connection = $this->database_connection->selectCollection($collection_name);
        }
    }

    protected function get_collection() {
        return $this->collection_connection;
    }
    
    //find records based on specified param
    public function find(array $conditions)  {
        return $this->get_collection()->find($conditions);
    }

    //find one record
    public function findOne(array $conditions) {
        return $this->get_collection()->findOne($conditions);
    }

    public function insert(array $conditions){
        return $this->get_collection()->insertOne($conditions);
    }

    public function delete(array $conditions){
        return $this->get_collection()->deleteOne($conditions);
    }
}

?>