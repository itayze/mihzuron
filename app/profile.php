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
                $tel=$row['tel'];
                $city=$row['city'];
                $street=$row['street'];
                $streetnum=$row['houseNumber'];
                $path=$row['profilePic'];
            }
       }
       
       
       
       if($_GET['tel']=="true")
       {
       echo $tel;
       
       
       }
       
       
        if($_GET['city']=="true")
       {
       echo $city;
       
       
       } 
       if($_GET['housenum']=="true")
       {
       
       echo $streetnum;
       
       }
       
       
            if($_GET['userName']=="true")
       {
       
       echo $userName;
       
       }
       
          if($_GET['email']=="true")
       {
       
       echo $email;
       
       }
       if($_GET['check']=="true")
       {
           $sum=0;
   $sql="SELECT * from posts WHERE userName='".$userName."' OR paidUser='".$userName."'";
      $result=$conn-> query($sql);
      if($result->num_rows>0)
       {
                                                          
        while($row=$result->fetch_assoc())
        {
        if($row['paid']==1)
        {
          $sum+=$row['revenue'];
                                                                
          }
                                    
          }
           $sum=$sum/2;//TO EDIT 
             }
if($sum<1 && $sum>=0){
  echo'<i class="fas fa-chess-pawn fa-2x"></i>';
    echo'<br> <h3>ממחזר מתחיל<h3>';
   }
    else if($sum>1 && $sum<=50){
     echo'<i class="fas fa-chess-knight fa-2x"></i>';
     echo'<br> <h3>ממחזר מתקדם<h3>';
       }
        else if($sum>50){
       echo'<i class="fas fa-chess-king fa-2x"></i>';
        echo'<br> <h3>ממחזר מתקדם<h3>';
         }
        else{ echo $sum ;} 
       }
       
              if($_POST['action']=="showLevel")
{
    
$sum=0;
   $sql="SELECT * from posts WHERE userName='".$userName."' OR paidUser='".$userName."'";
      $result=$conn-> query($sql);
      if($result->num_rows>0)
       {
                                                          
        while($row=$result->fetch_assoc())
        {
        if($row['paid']==1)
        {
          $sum+=$row['revenue'];
                                                                
          }
                                    
          }
           $sum=$sum/2;//TO EDIT 
             }
if($sum<1 && $sum>=0){
  echo'<i class="fas fa-chess-pawn fa-3x"></i>';
    echo'<br> <h3>ממחזר מתחיל<h3>';
   }
    else if($sum>1 && $sum<=50){
     echo'<i class="fas fa-chess-knight fa-3x"></i>';
     echo'<br> <h3>ממחזר מתקדם<h3>';
       }
        else if($sum>50){
       echo'<i class="fas fa-chess-king fa-3x"></i>';
        echo'<br> <h3>ממחזר מתקדם<h3>';
         }
        else{ echo $sum ;}    
        
        
        echo "hello";
}
    if($_GET['street']=="true")
       {
       
       echo $city.' '.$street.' '.$streetnum;
       
       }
       
            if($_GET['pic']=="true")
       {
       
       echo json_encode($path) ;
       
       }
       
     
       
?>

<!DOCTYPE HTML>
<html>
    
    <head>
         <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo2.jpg">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <title>דף הבית</title>
   
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/fullcalendar.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="assets/plugins/morris/morris.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    </head>
    <body>
        
    </body>
</html>
