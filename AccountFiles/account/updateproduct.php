<?php 
 header('Access-Control-Allow-Origin: *');
 header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
 header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
 header("Content-type:application/json");
 require_once '../auth.php';
 $db = new Auth();

 $response = array();
 if (!$_FILES) {
    $sn = $db->test_input($_POST['PSN']);
    $category = $db->test_input($_POST['category']);
    $usn = $db->test_input($_POST['usn']);
    $account = $db->test_input($_POST['account']);
    $prodname = $db->test_input($_POST['prodname']);
    $prodtype = $db->test_input($_POST['prodtype']);
    $actualfarmprod = $db->test_input($_POST['actualfarmprod']);
    $farminputtype = $db->test_input($_POST['farminputtype']);
    $actualfarminput = $db->test_input($_POST['actualfarminput']);
    $service = $db->test_input( $_POST['service']);
    $brand = $db->test_input($_POST['brand']);
    $model = $db->test_input($_POST['model']);
    $status = $db->test_input($_POST['status']);
    $price = $db->test_input($_POST['price']);
    $description = $db->test_input($_POST['description']);
    $coverphoto = $db->test_input($_POST['coverphoto']);
    $moreimages = implode(',',$_POST['images']);
    
    $checkupdate = $db->updateproduct($sn,$usn,$category,$account,$prodname,$prodtype,$actualfarmprod,
    $farminputtype,$actualfarminput,$service,$brand,$model,$status,$price,$description,$coverphoto,$moreimages);

    if ($checkupdate === TRUE) {
        $response = array(
         'status' => 'sucess',
         'message' => 'You have successfully updated your product'
        );
    } else {
      $response = array(
         'status' => 'error',
         'message' => 'An error occured while updating your product'
        );
    }
    

 } else {
   $sn = $db->test_input($_POST['PSN']);
   $category = $db->test_input($_POST['category']);
   $usn = $db->test_input($_POST['usn']);
   $account = $db->test_input($_POST['account']);
   $prodname = $db->test_input($_POST['prodname']);
   $prodtype = $db->test_input($_POST['prodtype']);
   $actualfarmprod = $db->test_input($_POST['actualfarmprod']);
   $farminputtype = $db->test_input($_POST['farminputtype']);
   $actualfarminput = $db->test_input($_POST['actualfarminput']);
   $service = $db->test_input( $_POST['service']);
   $brand = $db->test_input($_POST['brand']);
   $model = $db->test_input($_POST['model']);
   $status = $db->test_input($_POST['status']);
   $price = $db->test_input($_POST['price']);
   $description = $db->test_input($_POST['description']);
   $coverphoto = $_FILES['images']['name'][0];
   $moreimages = implode(',',$_FILES['images']['name']);
   $count = count($_FILES['images']['name']);

   $firsttmpdir = $_FILES['images']['tmp_name'][0];
   $targetpath = '../Uploads/'.$coverphoto;

   if(move_uploaded_file($firsttmpdir,$targetpath)) {
      $checkupdate = $db->updateproduct($sn,$usn,$category,$account,$prodname,$prodtype,$actualfarmprod,
      $farminputtype,$actualfarminput,$service,$brand,$model,$status,$price,$description,$coverphoto,$moreimages);

      if ($checkupdate === TRUE) {
         for ($i=0; $i < $count ; $i++) { 
            $filename = $_FILES['images']['name'][$i];
            $tmpdir = $_FILES['images']['tmp_name'][$i];
            $targetpath = '../Uploads/'.$filename;

            move_uploaded_file($tmpdir,$targetpath);
         }
         $response = array(
            'status' => 'sucess',
            'message' => 'You have successfully updated your product'
           );

      } else {
         $response = array(
            'status' => 'error',
            'message' => 'Sorry An error occured while updating your product'
         );
      }
      
   }
   else {
      $response = array(
         'status' => 'error',
         'message' => 'Sorry An error occured while updating your product'
      );
   }
 }
 echo json_encode($response);
 

?>