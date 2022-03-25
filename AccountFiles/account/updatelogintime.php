<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
    header("Content-type:application/json");
    require_once '../auth.php';
    $db = new Auth();

    $jsondata = file_get_contents("php://input");
    $postdata = json_decode(file_get_contents("php://input"),true);
    $userid = $postdata['cuser']; 
    $timezoneoffsetminute = $postdata['timezone'];
    
    $timezone_name = timezone_name_from_abbr("", $timezoneoffsetminute*60,false); 
    date_default_timezone_set($timezone_name);

    $date = date('Y-m-d h:i');
    $logintime = date('Y-m-d h:i:s');
    $lastlogindt = strtotime(date('h:i:sa M d Y'));
    $lastlogindate = date("l d-m-Y h:ia",$lastlogindt);

    //$date = date('Y-m-d h:i');
    //$lastlogintime = date('Y-m-d h:i:s');
    //$lastlogintimestring = strtotime($lastlogintime);
    //$actaullastlogindate = date("l d-m-Y h:ia",$lastlogintimestring);
    
    if ($userid !== "") {
        $db->updatelogintime($userid,$date,$logintime,$lastlogindate);
    }

?>