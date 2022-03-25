<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
header("Content-type:application/json");
require_once '../auth.php';
$db = new Auth();

$response = array();
 if(isset($_POST['timezone']) || isset($_POST['userid']) || isset($_POST['type']) || isset($_POST['post']) || isset($_POST['parentpost']) || isset($_FILES['images']) 
    || isset($_POST['replyowner']) || isset($_POST['repliedreply']) || isset($_POST['repliecommdes'])) {
    $timezonediff = $_POST['timezone'];
    $timezone_name = timezone_name_from_abbr("", $timezonediff*60, false);
    date_default_timezone_set($timezone_name);
    $timeofupload = date('Y-m-d H:i:s');
    $uploadtime = strtotime($timeofupload);
    $actualuploadtime = date("l d-m-Y h:ia",$uploadtime);

    $uid = $db->test_input($_POST['userid']);
    $type = $db->test_input($_POST['type']);
    $post = $db->test_input($_POST['post']);
    $parentpost = $db->test_input($_POST['parentpost']);
    $replyreplycomment = $db->test_input($_POST['repliedreply']);
    $replyowner = $db->test_input($_POST['replyowner']);
    $repliedcomdes = $db->test_input($_POST['repliecommdes']);
    if (!$_FILES) {
        $images = '';
            $checkpostupload = $db->makepost($uid,$type,$parentpost,$replyreplycomment,$repliedcomdes,$replyowner,$post,$images,$timeofupload);
            
            if ($checkpostupload === TRUE) {
                $response = array(
                    'status' => 'success',
                    'message' => 'You posted successfully'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Sorry!An error occured while posting'
                );
            }
    } else {
        $images = implode(",",$_FILES['images']['name']);
        $count = count($_FILES['images']['name']);
    
            $checkinsert = $db->makepost($uid,$type,$parentpost,$replyreplycomment,$repliedcomdes,$replyowner,$post,$images,$timeofupload);
    
            if ($checkinsert === TRUE) {
    
            for ($i=0; $i < $count; $i++) { 
            $filename = $_FILES['images']['name'][$i];
            $tempdir = $_FILES['images']['tmp_name'][$i];
            $targetpath = '../Uploads/'.$filename;
             move_uploaded_file($tempdir,$targetpath);  
            }
                $response = array(
                    "status" => "success",
                    "message" => "You have Succcessfully inserted a product" 
                );
            } else {
                $response = array(
                    "status" => "error",
                    "message" => "Sorry! An arror occured while uploading your product"
                );
            } 
    }
    echo json_encode($response); 
} 
/* $response = array(
    'status' => 'success',
    'message' => 'You have successfully posted something'
);
if (isset($_POST['userid']) || isset($_POST['type']) || isset($_POST['post']) || isset($_FILES['images'])) {
        $uid = $db->test_input($_POST['userid']);
        $type = $db->test_input($_POST['type']);
        $post = $db->test_input($_POST['post']);
        if (!$_FILES) {
           $images = '';
            $checkpostupload = $db->makepost($uid,$type,$post,$images);
            
            if ($checkpostupload === TRUE) {
                $response = array(
                    'status' => 'success',
                    'message' => 'You posted successfully'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Sorry!An error occured while posting'
                );
            } 
            
         } else {

            $count = $_FILES['images']['name'];
            $images = implode(',',$_FILES['images']['name']);

            $checkpostupload = $db->makepost($uid,$type,$post,$images);

            if ($checkpostupload === TRUE) {
                $response = array(
                    'status' => 'success',
                    'message' => 'You posted successfully'
                );

              for ($i=0; $i < $count; $i++) { 
                $filename = $_FILES['images']['name'][$i];
                $tempdir = $_FILES['images']['tmp_name'][$i];
                $targetpath = '../Uploads/'.$filename;
                move_uploaded_file($tempdir,$targetpath);  
                } 

            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Sorry!An error occured while posting'
                );
            }
        }
    echo json_encode($response);
} */

?>