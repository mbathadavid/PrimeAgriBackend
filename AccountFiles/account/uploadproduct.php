<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
header("Content-type:application/json");
require_once '../auth.php';
$db = new Auth();

$response = array();
 if(isset($_POST['owner']) || isset($_POST['shopid']) || isset($_POST['shoptype']) || isset($_POST['account']) || isset($_POST['productname']) || isset($_POST['farmproducttype']) 
|| isset($_POST['actualfarmproduct']) || isset($_POST['brand']) || isset($_POST['model']) || isset($_POST['condition']) || isset($_POST['description'])
|| isset($_POST['price']) || isset($_POST['service']) || isset($_FILES['images'])) {

    $owner = $db->test_input($_POST['owner']);
    $psn = $db->test_input($_POST['shopid']);
    $category = $db->test_input($_POST['shoptype']);
    $account = $db->test_input($_POST['account']);
    $productname = $db->test_input($_POST['productname']);
    $farmprodtype = $db->test_input($_POST['farmproducttype']);
    $actualfarmprod = $db->test_input($_POST['actualfarmproduct']);
    $brand = $db->test_input($_POST['brand']);
    $model = $db->test_input($_POST['model']);
    $condition = $db->test_input($_POST['condition']);
    $description = $db->test_input($_POST['description']);
    $price = $db->test_input($_POST['price']);
    $service = $db->test_input($_POST['service']);
    $firstimage = $_FILES['images']['name'][0];
    $filename = time().$firstimage;
    $firsttmpdir = $_FILES['images']['tmp_name'][0];
    $targetpath = '../Uploads/'.$filename;
    
    $filenames = implode(",",$_FILES['images']['name']);
    $count = count($_FILES['images']['name']);

    if (move_uploaded_file($firsttmpdir,$targetpath)) {
        $checkinsert = $db->insertproduct($owner,$psn,$category,$account,$productname,$farmprodtype,$actualfarmprod,$farminputtype,$actualfarminput,$service,
        $brand,$model,$condition,$price,$description,$filename,$filenames);

        if ($checkinsert === TRUE) {

        for ($i=0; $i < $count; $i++) { 
        $filename = $_FILES['images']['name'][$i];
        $tempdir = $_FILES['images']['tmp_name'][$i];
        $targetpath = '../Uploads/'.$filename;
         move_uploaded_file($tempdir,$targetpath);  
        }
      /* array_push($response,array(
                "status" => "success",
                "message" => "You have Succcessfully inserted a product"
            )); */
            $response = array(
                "status" => "success",
                "message" => "You have Succcessfully inserted a product" 
            );
        } else {
            array_push($response,array(
                "status" => "error",
                "message" => "Sorry! An arror occured while uploading your product"
            ));
        }
           
    } else {
        $response = array(
                "status" => "error",
                "message" => "An error occured while uploading your product,please try again later"
            );
    }
    echo json_encode($response); 
} 

?>