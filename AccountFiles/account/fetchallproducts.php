<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
    header("Content-type:application/json");
    require_once '../auth.php';
    $db = new Auth();

    $jsondata = file_get_contents("php://input");
    $postdata = json_decode(file_get_contents("php://input"),true);
    $action = $postdata['action']; 
     
    if ($action === "fetchall"){
        $products = $db->fetchallproducts();
            if($products !== null) {
                echo json_encode($products);
            } else {
                echo "No products";
            }
    } else {
        echo "No Request";
    }
    

?>