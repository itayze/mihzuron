<?php
header("Access-Control-Allow-Origin: *");
require_once('config.php');

$userName=$_GET['userName'];

$src = $_FILES['file']['tmp_name'];
$targ = "eavni93.com/itay/uploads/'.$userName";
move_uploaded_file($src, $targ);
$sql = "UPDATE users SET profilePic='".$targ."' WHERE userName='".$userName."'";    
      
   if (mysqli_query($conn, $sql))
   {
          echo json_encode($userName)  ;    


    }      else{
        echo "There was an error uploading the file, please try again!";
    }