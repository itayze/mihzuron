<?php
header("Access-Control-Allow-Origin: *");
require_once('config.php');


$userName=$_POST['userName'];

$sql="SELECT * FROM users WHERE userName=?";
       $stmt=mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql))
        {
             header('location: login.php?error=sqlerror');
       exit();
            
        }
        else
        {
            
            mysqli_stmt_bind_param($stmt,"s",$userName);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            
            if($row=mysqli_fetch_assoc($result))
            {
                $userName= $row['userName'];
                $email=$row['email'];
                $path=$row['profilePic'];
            }
       }
       
           if(!empty($_FILES['file']))
  {
    $path = "eavni93.com/itay/uploads/";
    $path .= $userName;
    if ($_POST['action']=="getPath")
{
    echo json_encode($path) ;
}
    if(move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
      echo "The file ".  basename( $_FILES['file']['name']). 
      " has been uploaded";
      
 $sql = "UPDATE users SET profilePic='".$path."'
      WHERE email='".$email."'
      ";    
      
   if (mysqli_query($conn, $sql))
   {
                


    }     } else{
        echo "There was an error uploading the file, please try again!";
    }
  }
           
  if(!empty($_POST['city'])){
        $cityn=$_POST['city'];
      $sql = "UPDATE users SET city='".$cityn."'  WHERE email='".$userName."'
      "; 

    if ($conn->query($sql) === TRUE) {
    
        $flag=true;
    }
   else {
    echo "Error updating record: " . $conn->error;
    }
}          
 if(!empty($_POST['street'])){
        $streetn=$_POST['street'];
      $sql = "UPDATE users SET street='".$streetn."'  WHERE email='".$userName."'
      "; 

    if ($conn->query($sql) === TRUE) {
    
        $flag=true;
    }
   else {
    echo "Error updating record: " . $conn->error;
    }
}      
if(!empty($_POST['houseNumber'])){
        $houseNumbern=$_POST['houseNumber'];
      $sql = "UPDATE users SET houseNumber='".$houseNumbern."'  WHERE email='".$userName."'
      "; 

    if ($conn->query($sql) === TRUE) {
    
         $flag=true;
    }
   else {
    echo "Error updating record: " . $conn->error;
    }
}
 if(!empty($_POST['tel'])){
        $teln=$_POST['tel'];
      $sql = "UPDATE users SET tel='".$teln."'  WHERE email='".$userName."'
      "; 

    if ($conn->query($sql) === TRUE) {
    
         $flag=true;
    }
   else {
    echo "Error updating record: " . $conn->error;
    }
}
if($flag==true)
{
    echo '<script language="javascript">';
echo 'alert("פרטיך עודכנו בהצלחה")';
echo '</script>';
}


?>