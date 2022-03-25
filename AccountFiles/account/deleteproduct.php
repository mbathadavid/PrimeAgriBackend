<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
    header("Content-type:application/json");
    require_once '../auth.php';
    $db = new Auth();

    $response = array();
    $jsondata = file_get_contents("php://input");
    $postdata = json_decode(file_get_contents("php://input"),true);
    $pid = $postdata['pid']; 
         
    $checkdel = $db->deleteproduct($pid);

    if ($checkdel === TRUE) {
        $response= array(
            'status' => 'success',
            'message' => 'Product Deleted Successfully'
        );
    } else {
        $response= array(
            'status' => 'error',
            'message' => 'Sorry! A problem occured while deleting a product'
        );
    }
    echo json_encode($response);

?>