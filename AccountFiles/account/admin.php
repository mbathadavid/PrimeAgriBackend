<?php 
require_once '../config.php';

Class Admin extends Database{
function fetching(){

    $sql= "SELECT * FROM accounts";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //$result= $this->conn->query($sql);
    return $result;
}
}


 ?>