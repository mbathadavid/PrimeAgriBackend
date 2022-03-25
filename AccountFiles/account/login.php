<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
header("Content-type:application/json");
require_once '../auth.php';
$db = new Auth();

$response = array();

if(isset($_POST['username']) && isset($_POST['password'])) {
    $token = md5(uniqid());
    $username = $_POST['username'];
    $pass = $_POST['password'];
    $db->updatelogintoken($username,$token);
    $loggedinuser = $db->login($username);
    if ($loggedinuser['Pass'] !== $pass) {
        $response = array(
            'status' => 'failed',
            'message' => 'You provided incorrect password'
        );
    } else {
        $response = array(
        'status' => 'success',
        'message' => $loggedinuser
        );
    }
    echo json_encode($response);
}


?>