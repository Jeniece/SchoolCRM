<?php
  class DB {

    private static $db = null;
    private static $server_name = 'localhost';
    private static $username = 'root';
    private static $password = '123ABC!@#defg';
    public $conn = null;

    private function __construct(){

    }

    public static function getInstance(){
      if($db == null){
        $db = new DB();
      }
      return $db;
    }
  }
?>
