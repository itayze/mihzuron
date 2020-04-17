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
       
       
            function getDateDiff($dateRecive)
      {
     
       $day=(strtotime(date("Y-m-d"))-strtotime($dateRecive))/(60*60*24);
    
      $yesterday=strtotime((date("Y-m-d", time() - 60 * 60 * 24)));
      if((strtotime($dateRecive)-$yesterday)/(60*60*24)==0)
      {
          $isYesterday=true;
      }
      if($day==0 && $isYesterday!=true )
       {
           return 'היום';
       }
        if($isYesterday==true)
       {
           return 'אתמול';
       }
       else
       {
           
           return $dateRecive;
       }
       

    //echo ((strtotime(date("Y-m-d")))-strtotime((date("Y-m-d", time() - 60 * 60 * 24))))/(60*60*24);
   
           
       
}

if($_GET['rev']=="true")
{
$sum=0;
   $sql="SELECT * from posts WHERE userName=
    '".$userName."' OR paidUser='".$userName."'";
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
            echo '₪';
           echo $sum;    
}
if($_GET['posts']=="true")
{
 $sql="SELECT * from posts WHERE userName='".$userName."' ";
     $result=$conn-> query($sql);
      echo $result->num_rows;
}
if($_GET['paid']=="true")
{
$sql="SELECT * from posts WHERE paidUser='".$userName."' ";
     $result=$conn-> query($sql);
     echo $result->num_rows;    
}
if($_GET['today']=="true")
{
 $sql="SELECT * from posts WHERE date= CURDATE()";
  $result=$conn-> query($sql);
echo $result->num_rows;    
}
if($_GET['feed']=="true")
{
$sql="SELECT * from posts WHERE paid=0 AND isDeleted='0' ORDER BY id DESC LIMIT 3";
                            $result=$conn-> query($sql);
                          if($result->num_rows>0)
                           {
                          $i=1;
                          while($row=$result->fetch_assoc())
                         {
                         echo '
                                                              
                        <li>
                             <div class="contact-cont">
                            <div class="pull-left user-img m-r-10">
                            <a href="profile.html" title="John Doe"><img src=
                           '.$row['profilePic'].' alt="" class="w-40 rounded-circle"><span class="status online"></span></a>
                          </div>
                                                            
                        <div class="contact-info">
                       <span class="contact-name text-ellipsis">'.$row['userName'].'</span>
                     <span class="contact-date">'.getDateDiff($row['date']) .'</span>
                   <span class="contact-name text-ellipsis">
                   שווי:
            '.$row['revenue'].'</span>

<span class="contact-name text-ellipsis">';
           $timestamp = strtotime($row['date']);
          $month = date('F', $timestamp);
         echo $month.'
        </span>
       </div>
                                                        
     </div>
    </li>
                                                              
    ';
                                                               
     }
      }   
}

if($_GET['level']=="true")
{
$sum=0;
   $sql="SELECT * from posts WHERE userName=
    '".$userName."' OR paidUser='".$userName."'";
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
if($sum<1&&$sum>=0){
  echo'<i class="fas fa-chess-pawn fa-3x"></i>';
    echo'<br> <h3>ממחזר מתחיל<h3>';
   }
    else if($sum>1&&$sum<=50){
     echo'<i class="fas fa-chess-knight fa-3x"></i>';
     echo'<br> <h3>ממחזר מתקדם<h3>';
       }
        else if($sum>50){
       echo'<i class="fas fa-chess-king fa-3x"></i>';
        echo'<br> <h3>ממחזר מתקדם<h3>';
         }
        else{ echo $sum ;}    
}
?>