<?php
header("Access-Control-Allow-Origin: *");

require_once('config.php');



if(isset($_GET['username'])&&($_GET['postId']))
{

    $userName=$_GET['username'];
    $postId=$_GET['postId'];
   $sql = "UPDATE posts SET paidUser='".$userName."',paid=1,datePaid=CURDATE()
      WHERE id='".$postId."'"; 
       if (mysqli_query($conn, $sql))
   {
   
   }
 

  $sql="SELECT * from posts WHERE id='".$postId."'
  ";
        $result=$conn-> query($sql);
       if($result->num_rows>0)
           {
           $row=$result->fetch_assoc();
           
            $userPost=$row['userName'];
           $pathUserInvolved=$row['profilePic'];
            $amountA=$row['amountA'];
            $amountB=$row['amontB'];
            $amountTotal=$amountA+$amountB;
            
            $newTotalBottle=$amountTotal+$totalBottle; //for user that paid

            $sql = "UPDATE users SET totalBottle='".$newTotalBottle."' 
      WHERE userName='".$userName."'
      "; 
       if (mysqli_query($conn, $sql))
   {
   
   }
           }
   $sql="SELECT * from users WHERE userName='".$userPost."'";
  $result=$conn-> query($sql);
       if($result->num_rows>0)
           {
               $totalBottle2=$row['totalBottle'];
                
           }
           $newTotalBottle2=$amountTotal+$totalBottle2;
   $sql = "UPDATE users SET totalBottle='".$newTotalBottle2."' WHERE userName='".$userPost."'"; 
       if (mysqli_query($conn, $sql))
   {
   
   }
    $my_date_time = date("Y-m-d H:i:s");
           $sql = "INSERT INTO notifications (owner,user_involved,sort,date,isSeen,fullDate,profilePic) VALUES ('".$userPost."','".$userName."',1,CURDATE(),0,'".$my_date_time."','".$pathUserInvolved."')";
             if (mysqli_query($conn, $sql))
   {
        }
        else
        {
            
        }
            $sql = "INSERT INTO notifications (owner,user_involved,sort,date,isSeen,fullDate) VALUES ('".$userName."','".$userPost."',2,CURDATE(),0,'".$my_date_time."','".$path."')";

    if (mysqli_query($conn, $sql))
   {
        }
        else
        {
            
        }
            
}      
        
        
?>