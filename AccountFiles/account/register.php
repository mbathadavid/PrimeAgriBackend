<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
header("Content-type:application/json");
require_once '../auth.php';
$db = new Auth();

$response = array();
if(isset($_POST['timezone']) || isset($_POST['firstname']) || isset($_POST['lastname']) && isset($_POST['email']) || isset($_POST['password'])) {
    $timeoffsetminutes = $_POST['timezone'];
    $timezone_name = timezone_name_from_abbr("", $timeoffsetminutes*60, false);
    date_default_timezone_set($timezone_name);
    
    $image = 'avatar.png';
    $date = date('Y-m-d h:i');
    $logintime = date('Y-m-d h:i:s');
    $lastlogindt = strtotime(date('h:i:sa M d Y'));
    $lastlogindate = date("l d-m-Y h:ia",$lastlogindt);

    $fname = $db->test_input($_POST['firstname']);
    $lname = $db->test_input($_POST['lastname']);
    $email = $db->test_input($_POST['email']);
    $password = $db->test_input($_POST['password']);

    $checkregistration = $db->registernewuser($fname,$lname,$email,$password,$image,$logintime,$date,$logintime,$lastlogindate);
        if ($checkregistration === TRUE) {
            $response = array(
                "status" => "success",
                "message" => "You have successfully Registered an account with us. Check your email to activate your account"
            );
        } else {
            $response = array(
                "status" => "error",
                "message" => "Sorry!!! An error occured while registering an account.Please try again later"
            );
        }

echo json_encode($response); 
}

?>