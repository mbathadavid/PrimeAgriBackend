<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
    header("Content-type:application/json");
    require_once '../auth.php';
    $db = new Auth();

    $jsondata = file_get_contents("php://input");
    $postdata = json_decode(file_get_contents("php://input"),true);
    $email = $postdata['sendemail']; 
     
    $emailcount = $db->checkemailavailabilty($email);
    if ($emailcount > 0) {
        echo "Registered";
    } else {
        echo "Available";
    }
    
    

?>