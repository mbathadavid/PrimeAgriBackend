<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
header("Content-type:application/json");
require_once '../auth.php';
$db = new Auth();

$response = array();
if(isset($_POST['owner']) || isset($_POST['shopname']) && isset($_POST['shoptype']) || 
isset($_POST['description']) || isset($_FILES['shopcoverphoto'])) {
    if (!$_FILES['shopcoverphoto']) {
        $defaultfile = "avatar.png";
        $owner = $db->test_input($_POST['owner']);
        $shopname = $db->test_input($_POST['shopname']);
        $shoptype = $db->test_input($_POST['shoptype']);
        $description = $db->test_input($_POST['description']);

        $checkshopcreate = $db->createnewshop($owner,$shopname,$shoptype,$description,$defaultfile);

        if ($checkshopcreate === TRUE) {
            $response = array(
                'status' => 'success',
                'message' => 'You have successfully registered a new selling account'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Sorry! Something went wrong,Please try again later'
            );
        }
        
    } else { 
       $filename = $_FILES['shopcoverphoto']['name'];
       $tmpdir = $_FILES['shopcoverphoto']['tmp_name'];
       $targetpath = "Uploads".$filename;

       if (!move_uploaded_file($tmpdir,$targetpath)) {
        $response = array(
            'status' => 'error',
            'message' => 'Sorry! Something went wrong,Please try again later'
        );
       } else {
        $owner = $db->test_input($_POST['owner']);
        $shopname = $db->test_input($_POST['shopname']);
        $shoptype = $db->test_input($_POST['shoptype']);
        $description = $db->test_input($_POST['description']); 

        $checkshopcreate = $db->createnewshop($owner,$shopname,$shoptype,$description,$filename);

        if ($checkshopcreate === TRUE) {
            $response = array(
                'status' => 'success',
                'message' => 'You have successfully registered a new selling account'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Sorry! Something went wrong,Please try again later'
            );
        }

       }
       
}
        echo json_encode($response);
}

?>