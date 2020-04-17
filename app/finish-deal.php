<?php
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
                $amountBot=$row['amountBot'];
            }
       }


$id=$_POST['id'];

 $sql="SELECT * from posts WHERE id='".$id."'
  ";
   $result=$conn-> query($sql);
       if($result->num_rows>0)
           {
           $row=$result->fetch_assoc();
           
            $code=$row['code'];
            $userPost= $row['paidUser'];
             $pathUserInvolved=$row['profilePic'];
            $amountBottlesInDeal=intval($row['amountA'])+intval($row['amountB']);
            $BonusBottleForConfirmation=$amountBottlesInDeal/10;
            $amountBotAfterBonus=$amountBot-$BonusBottleForConfirmation;
           }

                          $token=$_POST['fourCode'];
                          if($token==$code)
                          {
                           $sql="update users set amountBot='".$amountBotAfterBonus."' where userName='".$userName."'";
                              if (mysqli_query($conn, $sql))
   {
    }   
                              $sql="update posts set isConfirmed=1 where id='".$id."'";
                              if (mysqli_query($conn, $sql))
   {
                
         

    }      else{
        echo "There was an error uploading the file, please try again!";
    }
                          
               $my_date_time = date("Y-m-d H:i:s");                
              $sql = "INSERT INTO notifications (owner,user_involved,sort,date,isSeen,fullDate,profilePic) VALUES ('".$userName."','".$userPost."',3,CURDATE(),0,'".$my_date_time."','".$path."')";
             if (mysqli_query($conn, $sql))
   {
        }
        else
        {
            
        }
         $sql = "INSERT INTO notifications (owner,user_involved,sort,date,isSeen,fullDate,profilePic) VALUES ('".$userPost."','".$userName."',4,CURDATE(),0,'".$my_date_time."','".$pathUserInvolved."')";
             if (mysqli_query($conn, $sql))
   {
        }
        else
        {
            
        }
         echo'
           העסקה הצליחה!
           <br>
           <br>
                                 <div class="alert alert-success" style="text-align:right;" role="alert">
                                 <p style="font-size:16px;">
                             עודכנה לך הטבת בקבוקים לפרסום בגובה 10% מהבקבוקים בעסקה.
                             <br>
                             בכל פעם שתזין את קוד בן 4 הספרות תקבל את ההטבה.
                             <br>
                             ועוד דבר קטן,
                             <br>
                             כל הכבוד! המשך למחזר!
                            
</p></div>
           ';
                          }
                          else
                         echo "
                          אופס, נראה שהזנת קוד שגוי
                          ";
                          ?>