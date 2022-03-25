<?php
require_once 'config.php';
Class Auth extends Database {
    public function registernewuser($fname,$lname,$email,$pass,$profile,$datejoined,$lastlogin,$lastlogintime,$lastlogintimestring) {
        $sql = "INSERT INTO accounts(Fname,Lname,Email,Pass,profilephoto,datejoined,lastlogin,lastlogintime,lastlogintimestring) VALUES (:fname,:lname,:email,:pass,:profile,:datejoined,:lastlogin,:lastlogintime,:lastlogintimestring)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['fname'=>$fname,'lname'=>$lname,'email'=>$email,'pass'=>$pass,'profile'=>$profile,'datejoined'=>$datejoined,'lastlogin'=>$lastlogin,
        'lastlogintime'=>$lastlogintime,'lastlogintimestring'=>$lastlogintimestring]);
        return true;
    }
    public function checkemailavailabilty($email) {
        $sql = "SELECT * FROM accounts WHERE Email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email]);
        $rowcount = $stmt->rowCount();
        return $rowcount;
    }
    public function login($email) {
        $sql = "SELECT * FROM accounts WHERE Email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function insertproduct($owner,$psn,$category,$account,$productname,$producttype,$actualfarmprod,$farminputtype,$actualfarminput,$service,
    $brand,$model,$condition,$price,$description,$coverphoto,$moreimages) {
        $sql = "INSERT INTO products(aid,psn,category,account,productname,producttype,actualfarmprod,farminputtype,
        actualfarminput,service,brand,model,status,price,description,coverphoto,moreimages,dateuploded) 
        VALUES (:owner,:psn,:category,:account,:productname,:producttype,:actualfarmprod,:farminputtype,:actualfarminput,:service,:brand,:model,:condition,
        :price,:description,:coverphoto,:moreimages,NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['owner'=>$owner,'psn'=>$psn,'category'=>$category,'account'=>$account,'productname'=>$productname,'producttype'=>$producttype,'actualfarmprod'=>$actualfarmprod
        ,'farminputtype'=>$farminputtype,'actualfarminput'=>$actualfarminput,'service'=>$service,'brand'=>$brand,'model'=>$model,'condition'=>$condition,'price'=>$price,
        'description'=>$description,'coverphoto'=>$coverphoto,'moreimages'=>$moreimages]);
        return true;
    }
    //fetch products
    public function fetchproducts($id) {
        $sql = "SELECT * FROM products WHERE aid = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    //fetch number of products per user
    public function fetchproductnumberperuser($id) {
        $sql = "SELECT * FROM products WHERE aid = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        $rowcount = $stmt->rowCount();
        return $rowcount;
    }
    //fetch shops by id
    public function fetchshopbyId($id) {
        $sql = "SELECT * FROM selleraccounts WHERE ASN = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    //Register a new seller account
    public function createnewshop($owner,$shopname,$shoptype,$shopdescription,$profile) {
        $sql = "INSERT INTO selleraccounts(ASN,Name,shoptype,Description,profile,datecreated) 
        VALUES (:owner,:shopname,:shoptype,:shopdescription,:profile,NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['owner'=>$owner,'shopname'=>$shopname,'shoptype'=>$shoptype,'shopdescription'=>$shopdescription,'profile'=>$profile]);
        return true;
    }
    //get shopname
    public function getshoptype($sid,$userid) {
        $sql = "SELECT * FROM selleraccounts WHERE SN = :sid AND  ASN = :userid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['sid'=>$sid,'userid'=>$userid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;  
    }
    //fetch one product
    public function fetchoneproduct($pid) {
        $sql = "SELECT * FROM products WHERE SN = :pid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['pid'=>$pid]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    //delete a product
    public function deleteproduct($pid) {
        $sql = "DELETE FROM products WHERE SN = :pid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['pid'=>$pid]);
        return true;
    }
    //update product
    public function updateproduct($sn,$psn,$category,$account,$productname,$producttype,$actualfarmprod,
    $farminputtype,$actualfarminput,$service,$brand,$model,$status,$price,$description,$coverphoto,$moreimages) {
        $sql = " UPDATE products SET psn = :psn,category = :category,account = :account,productname = :productname,
        producttype = :producttype,actualfarmprod = :actualfarmprod,farminputtype = :farminputtype,actualfarminput = 
        :actualfarminput,service = :service,brand = :brand,model = :model,status = :status,price = :price,description = 
        :description,coverphoto = :coverphoto,moreimages = :moreimages WHERE SN = :sn";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['psn'=>$psn,'category'=>$category,'account'=>$account,'productname'=>$productname,'producttype'=>
        $producttype,'actualfarmprod'=>$actualfarmprod,'farminputtype'=>$farminputtype,'actualfarminput'=>$actualfarminput,
        'service'=>$service,'brand'=>$brand,'model'=>$model,'status'=>$status,'price'=>$price,'description'=>$description,
        'coverphoto'=>$coverphoto,'moreimages'=>$moreimages,'sn'=>$sn]);
        return true;
    }
    //fetch all products
    public function fetchallproducts(){
        $sql = "SELECT accounts.Fname,accounts.Lname,accounts.Phone,accounts.profilephoto,products.category,products.productname,
        products.producttype,products.actualfarmprod,products.farminputtype,products.actualfarminput,products.service,products.brand,
        products.model,products.status,products.price,products.description,products.coverphoto,products.moreimages,products.dateuploded FROM 
        products INNER JOIN accounts ON accounts.SN = products.aid"; 
        //$sql = "SELECT * FROM products";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    //upload a post
    public function makepost($uid,$type,$parentid,$replyreplycomment,$replyreplydes,$replyowner,$post,$images,$date) {
        $sql = "INSERT INTO socialmedia(aid,type,parentcomment,replyreplycomment,replyreplydes,replyreplyowner,Description,images,dateuploaded) VALUES (:uid,:type,:parentid,:replyreplycomment,:replyreplydes,:replyowner,:post,:images,:date)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid,'type'=>$type,'parentid'=>$parentid,'replyreplycomment'=>$replyreplycomment,'replyreplydes'=>$replyreplydes,'replyowner'=>$replyowner,'post'=>$post,'images'=>$images,'date'=>$date]);
        return true;
    }
    //update login time
    public function updatelogintime($userid,$date,$lastlogintime,$lastlogintimestring) {
        $sql = "UPDATE accounts SET lastlogin = :date, lastlogintime = :lastlogintime, lastlogintimestring = :lastlogintimestring WHERE SN = :userid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['userid'=>$userid,'date'=>$date,'lastlogintime'=>$lastlogintime,'lastlogintimestring'=>$lastlogintimestring]);
        return true;
    }
    //fetch other users
    public function fetchallotherusers($userid) {
        $sql = "SELECT * FROM accounts WHERE SN != :userid ORDER BY lastlogintime DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['userid'=>$userid]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    //fetch posts
    public function fetch_posts() {
        $sql = "SELECT accounts.Lname,accounts.Fname,accounts.profilephoto,socialmedia.SN,socialmedia.aid,socialmedia.type,
        socialmedia.parentcomment,socialmedia.Description,socialmedia.images,socialmedia.dateuploaded FROM socialmedia INNER JOIN accounts ON 
        socialmedia.aid = accounts.SN WHERE socialmedia.parentcomment < 1 ORDER BY socialmedia.dateuploaded DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
    //fetch replies
    public function fetch_replies() {
        $sql = "SELECT accounts.Lname,accounts.Fname,accounts.profilephoto,socialmedia.SN,socialmedia.aid,socialmedia.type,
        socialmedia.parentcomment,socialmedia.replyreplycomment,socialmedia.replyreplydes,socialmedia.replyreplyowner,socialmedia.Description,socialmedia.images,socialmedia.dateuploaded FROM socialmedia INNER JOIN accounts ON 
        socialmedia.aid = accounts.SN WHERE socialmedia.parentcomment > 0 ORDER BY socialmedia.dateuploaded ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;  
    }
    //fetch other products exept mine
    public function fetchotherproducts($id,$category) {
        $sql = "SELECT accounts.Fname,accounts.Lname,accounts.Email,accounts.Phone,accounts.county,accounts.profilephoto,products.SN,products.category,products.account,
        products.productname,products.producttype,products.actualfarmprod,products.farminputtype,products.actualfarminput,products.service,products.brand,products.model,
        products.status,products.price,products.description,products.coverphoto,products.moreimages,products.dateuploded FROM products INNER JOIN accounts ON products.aid = accounts.SN WHERE products.aid != :id AND products.category = :category";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id,'category'=>$category]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    //fetch one product
    public function fetchoneproductdetalis($psn){
        $sql = "SELECT accounts.Fname,accounts.Lname,accounts.Email,accounts.Phone,accounts.county,accounts.profilephoto,products.SN,products.category,products.account,
        products.productname,products.producttype,products.actualfarmprod,products.farminputtype,products.actualfarminput,products.service,products.brand,products.model,
        products.status,products.price,products.description,products.coverphoto,products.moreimages,products.dateuploded FROM products INNER JOIN accounts ON products.aid = accounts.SN WHERE products.SN = :psn";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['psn'=>$psn]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    //Update login token
    public function updatelogintoken($email,$token){
        $sql = "UPDATE accounts SET logintoken = :token WHERE Email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['token'=>$token,'email'=>$email]);
        return true;
    }
    //take last serial number
    public function checklastpostid() {
        $sql = "SELECT SN FROM socialmedia ORDER BY SN DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    //function to update resource id
    public function updateresourceid($token,$rid){
        $sql = "UPDATE accounts SET connectionid = :rid WHERE logintoken = :token";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['token'=>$token,'rid'=>$rid]);
        return true;
    }
    //Add chats
    public function addchats($name,$message) {
        $sql = "INSERT INTO chatroom(Name,Description) VALUES (:name,:message)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['name'=>$name,'message'=>$message]);
        return true;
    }
    //Fetch chats
    public function fetchchats() {
        $sql = "SELECT * FROM chatroom";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}

?>