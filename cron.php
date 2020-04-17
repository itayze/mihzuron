<?php


require_once('config.php');
$sql="SELECT * from posts where isConfirmed=0 and paid=1 and isDeleted=0 and CURRENT_TIMESTAMP()-INTERVAL 2 DAY>fullDate ";
 $result=$conn-> query($sql);
                                                       if($result->num_rows>0)
                                                       {
                                                          
                                                           while($row=$result->fetch_assoc())
                                                           {
                                                             $sql = "INSERT INTO posts (userName,date,city,street,houseNumber,time,revenue, amountA, amountB,paid,profilePic,fullDate,code,isConfirmed,tel)
VALUES ('".$row['userName']."',CURDATE(),'".$row['city']."','".$row['street']."','".$row['houseNumber']."',CURTIME()+1,'".$row['revenue']."','".$row['amountA']."','".$row['amountB']."',FALSE, '".$row['path']."',CURTIME(),'".$row['code']."',0,'".$row['tel']."')";
  
  if (mysqli_query($conn, $sql)); 
                                            
                                 
                                                               
                                                           }
                                                           
                                                       }

$sql = "UPDATE posts SET isDeleted=1 , paidUser=NULL WHERE isConfirmed=0 and paid=1 and CURRENT_TIMESTAMP()-INTERVAL 2 DAY>fullDate";

if ($conn->query($sql) === TRUE) {
    echo "work";
} else {
    echo "Error updating record: " . $conn->error;
}
?>

