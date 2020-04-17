<?php
header("Access-Control-Allow-Origin: *");

require_once('config.php');

$userName=$_POST['userName'];
$package=$_POST['packageSort'];

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
                $userName=$row['userName'];
                $email=$row['email'];
                $path=$row['profilePic'];
                $amount=$row['amountBot'];
            }
            
            
          
       }

if($package=="first")
{
    //update first package
    $newAmount=$amount-1000;
   $sql="update users set amountBot='".$newAmount."' where userName='".$userName."' " ;
       if (mysqli_query($conn, $sql))
   {
       echo "
       חבילת אלף בקבוקים עודכנה בהצלחה
       ";
   }
    
}
else if ($package=="second")
{
    //update second package
        $newAmount=$amount-3000;
  $sql="update users set amountBot='".$newAmount."' where userName='".$userName."' " ;
       if (mysqli_query($conn, $sql))
   {
       echo "
       חבילת שלושת אלפים בקבוקים עודכנה בהצלחה
       ";
   
   }
    
    
}
else if ($package=="third")
{
    //update third package
        $newAmount=$amount-5000;

      $sql="update users set amountBot='".$newAmount."' where userName='".$userName."' " ;
       if (mysqli_query($conn, $sql))
   {
   echo "
       חבילת חמשת אלפים בקבוקים עודכנה בהצלחה
       ";
   }
    
}





?>