<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
header("Content-type:application/json");
require_once '../auth.php';
$db = new Auth();

$jsonid = file_get_contents('php://input');
$id = json_decode($jsonid,true);
$userid = $id['action'];

 $posts = $db->fetchchats();
if ($posts != null) {
    echo json_encode($posts);
} else {
    echo "NoData";
} 

?>