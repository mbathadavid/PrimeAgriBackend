<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require '../AccountFiles/auth.php';

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo "Server started";
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

       /* $querystring = $conn->httpRequest->getUri()->getQuery();
        parse_str($querystring, $queryarray);
        $db = new \Auth;
        $token = $queryarray['token'];
        $rid = $conn->resourceId;
        $db->updateresourceid($token,$rid); */

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
   
            $db = new \Auth;
         
      /*  $lastid = $db->checklastpostid();
        $id = $lastid['SN']+1; */

        $msgdetails = json_decode($msg,true);
    /*    $timezonediff = $msgdetails['timezone'];
        $timezone_name = timezone_name_from_abbr("", $timezonediff*60, false);
        date_default_timezone_set($timezone_name);
        $timeofupload = date('Y-m-d H:i:s');
        $uploadtime = strtotime($timeofupload);
        $actualuploadtime = date("l d-m-Y h:ia",$uploadtime);

        $uid = $db->test_input($msgdetails['userid']);
        $type = $db->test_input($msgdetails['type']);
        $post = $db->test_input($msgdetails['post']);
        $parentpost = $db->test_input($msgdetails['parentpost']);
        $replyreplycomment = $db->test_input($msgdetails['reliedreply']);
        $replyowner = $db->test_input($msgdetails['replyowner']);
        $repliedcomdes = $db->test_input($msgdetails['repliedcomdes']);
        $images = '';

        $checkpostupload = $db->makepost($uid,$type,$parentpost,$replyreplycomment,$repliedcomdes,$replyowner,$post,$images,$timeofupload);
        if ($checkpostupload === TRUE) {
            $post = array(
                'Fname' => $msgdetails['Fname'],
                'Lname' => $msgdetails['Lname'],
                'profilephoto' => $msgdetails['profilephoto'],
                'SN' => $id,
                'aid' => $uid,
                'type' => $type,
                'parentcomment' => $parentpost,
                'Description' => $post,
                'images' => $images,
                'dateuploaded' => $timeofupload          
            );

            $jsonpost = json_encode($post);
            
            foreach ($this->clients as $client) {
                    $client->send($jsonpost);
            }
        } else {
            
        }
        */
        $name = $db->test_input($msgdetails['Name']);
        $message = $db->test_input($msgdetails['Description']);
        $image = $db->test_input($msgdetails['Image']); 
        $imagestr = explode(',',$image);
        $actualimagestr = $imagestr[1];

        $fp = fopen("E:/xampp/htdocs/PrimeAgriBackend/AccountImages/base_64".rand(0,100).".jpg","w+");
        fwrite($fp,base64_decode($actualimagestr));
        fclose($fp);

        //$db->addchats($name,$message);

            foreach ($this->clients as $client) {
                //if ($from !== $client) {
                    $client->send($actualimagestr);
                //}
            }

      /*  foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($message);
            }
        } */
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
?>