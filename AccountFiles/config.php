<?php
Class Database {
    //private $dsn = "mysql:host=sql210.epizy.com:3306;dbname=epiz_30321818_primeagri";
    //private $dbuser = "epiz_30321818";
    //private $dbpass = "vQ5YSwk7IZ4h6F";

    private $dsn = "mysql:host=localhost:3306;dbname=primeagri";
    private $dbuser = "root";
    private $dbpass = "";

    public $conn;
    //Database Connection
    public function __construct(){
        try {
            $this->conn = new PDO($this->dsn,$this->dbuser,$this->dbpass);
        } catch (PDOException $e) {
            echo 'Error:'.$e->getMessage();
        }
        return $this->conn;
    } 

    //function to sanitize data
    public function test_input($data) {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

?>