<?php
header("Access-Control-Allow-Origin: *");
require_once('config.php');



$userName=$_POST['userName'];


    date_default_timezone_set("Asia/Jerusalem"); 


  $sql="SELECT * FROM users WHERE userName='".$userName."'";
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
                $city=$row['city'];
                $street=$row['street'];
                $houseNumber=$row['houseNumber'];
                $tel=$row['tel'];
                $path=$row['profilePic'];
                
                                 $amount=$row['amountBot'];

               if($row['profilePic']!=NULL)
               {
                   $isProfilePic=true;
                 
               }
               else
               {
                   $isProfilePic=false;
               }
            }
}


 $amountA=$_POST['amountA'];
    $amountB=$_POST['amountB'];
   
    $sum=$amountA+$amountB;
    $totalAmount=$amount;
    $amount=$amount+$sum;
    $totalAmount=$totalAmount+$amountA+$amountB;
    if($totalAmount<1000)
    {
     $revenue=(0.3*$amountA)+(1.2*$amountB);
     if($isProfilePic==true)
     {
          
     }
    else
    {
        $path="assets/img/user.jpg";
    }
    $code=rand(pow(10, 3), pow(10, 4)-1);
$sql = "INSERT INTO posts (userName,date,city,street,houseNumber,time,revenue, amountA, amountB,paid,profilePic,fullDate,code,isConfirmed,tel)
VALUES ('".$userName."',CURDATE(),'".$city."','".$street."','".$houseNumber."',CURTIME()+1,'".$revenue."','".$amountA."','".$amountB."',FALSE, '".$path."',CURTIME(),'".$code."',0,'".$tel."')";

 /*   $sql="INSTERT into posts (id,userName, date, city, street, houseNumber, time, revenue, amountA, amountB, paid) VALUES (null,'".$userName."',
    CURDATE(),'".$city."','".$street."','".$houseNumber."',CURTIME(),'".$revenue."','".$amountA."','".$amountB."',FALSE)
    ";
    */
    if (mysqli_query($conn, $sql))
   {
        $sql="update  users set amountBot='".$amount."' where userName='".$userName."'"; 
         if (mysqli_query($conn, $sql))
   {
        }
        else
        {
        }
        $my_date_time = date("Y-m-d H:i:s");
        $sql = "INSERT INTO notifications (owner,user_involved,sort,date,isSeen,fullDate,profilePic) VALUES ('".$userName."','".$userName."',5,CURDATE(),0,'".$my_date_time."','".$path."')";
     if (mysqli_query($conn, $sql))
   {
        }
        else
        {
            
        }
    echo json_encode("yes");
} 
else 
{
   echo json_encode("error");
}
}
else
{
    echo json_encode("toPackages");
}

?>