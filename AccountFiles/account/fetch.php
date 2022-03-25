<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTION, DELETE, PUT');
header('Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding');
header('Content-Type:application/json');


require_once "admin.php";
$num = new Admin();
$action0 = file_get_contents("php://input");
$action1 =  json_decode($action0,true);
$action2 = $action1['action'];
//echo 'we are listening';
if($action2 === "fetch"){
$row = $num->fetching();
echo json_encode($row);
}
//json_encode($row);
 ?>