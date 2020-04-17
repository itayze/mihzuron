<?php

require_once('config.php');

session_start();
if(!isset($_SESSION['userName']))
{
header("Location:login.php");
    exit();
}




    date_default_timezone_set("Asia/Jerusalem"); 


$sql="SELECT * FROM users WHERE userName=?";
       $stmt=mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql))
        {
             header('location: login.php?error=sqlerror');
       exit();
            
        }
        else
        {
            
            mysqli_stmt_bind_param($stmt,"s",$_SESSION['userName']);
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
                 $email=$row['email'];
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

if(isset($_POST['publishPost']))
{

    $amountA=intval($_POST['amountA']);
    $amountB=intval($_POST['amountB']);
    $sum=$amountA+$amountB;
    if($sum==NULL)
    {
         if($amountA==NULL && $amountB !=NULL)
    {
        $sum=$amountB;
    }
    else if ($amountB==NULL && $amountA !=NULL)
    {
                $sum=$amountA;

    }
    }
    if($amountA!=0 && $amountB==0)
{
    $sum= $amountA;
}
else if($amountB!=0 && $amountA==0)
{
    $sum= $amountB;
}
    if($sum<10 || $sum==NULL)
    {
        $beyondLimit=true;
    }
    else
    {
        
         $totalAmount=$amount;
    $amount=$amount+$sum;
    $totalAmount=$totalAmount+$amountA+$amountB;
    if($totalAmount<1000)
    {
    $revenue=(0.3*$amountA)+(1.2*$amountB);
     if($isProfilePic==true)
     {
          $path="uploads/".$userName;
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
    $successMessage = '<div class="alert alert-success" role="alert">Your message was sent, we\'ll get back to you ASAP!</div>';
   $my_date_time = date("Y-m-d H:i:s");
    $sql = "INSERT INTO notifications (owner,user_involved,sort,date,isSeen,fullDate,profilePic) VALUES ('".$userName."','".$userName."',5,CURDATE(),0,'".$my_date_time."','".$path."')";
     if (mysqli_query($conn, $sql))
   {
        }
        else
        {
            
        }
        
    
        $sql="update  users set amountBot='".$amount."' where userName='".$userName."'"; 
         if (mysqli_query($conn, $sql))
   {
        }
        else
        {
            
        }
    header("Location:feed.php");
} 
else 
{
    $error = '<div class="alert alert-danger" role="alert"><p><strong>Your message couldn\'t be sent - please try again later</div>';
}
}
else
{
    header("Location:packages.php");
    exit();
}
}

        
    }
    
   
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo2.jpg">
    <title>פרסום פוסט</title>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<body>
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                <a href="index.php" class="logo">
                     <img src="assets/img/logo2.jpg" width="60" height="50" alt="">
                </a>
            </div>
            <div class="page-title-box pull-left">
                <span id="updateNumOfNotifications"></span>
                <h3 >מיחזורון</h3>
            </div>
            <a id="mobile_btn" class="mobile_btn pull-left" href="#sidebar"><i class="fa fa-bars" aria-hidden="true"></i></a>
            <ul class="nav user-menu pull-right">
                <li class="nav-item dropdown d-none d-sm-block">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" id="notificationButton"><i class="fa fa-bell-o"></i> <span class="badge badge-pill bg-primary pull-right" id="numOfNotifications"></span></a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span>התראות</span>
                        </div>
                        <div class="drop-scroll">
                            <ul class="notification-list" id="notificationList">
                                
                              
                
                               
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="notificationList.php">הצג הכל</a>
                        </div>
                    </div>
                </li>
               
                 <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <span class="user-img">
							<img class="rounded-circle" src=
							        <?php
                                    if($path !=NULL)
                                    {
                                        echo "$path";
                                    }
                                    else
                                    {
                                        echo  "assets/img/user.jpg" ;
                                    }
                                    ?>
                        width="40" alt="Admin">
							<span class="status online"></span></span>
						</span>
						<span><?php
          echo $userName;
          ?></span>
                    </a>
					<div class="dropdown-menu">
					    
						<a class="dropdown-item" href="profile.php">הפרופיל שלי</a>
						<a class="dropdown-item" href="edit-profile.php">ערוך פרופיל</a>
					
						<a class="dropdown-item" href="login.php">התנתק</a>
						
					</div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu pull-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.php">הפרופיל שלי</a>
                    <a class="dropdown-item" href="edit-profile.php">ערוך פרופיל</a>
                 
                    <a class="dropdown-item" href="login.php">התנתק</a>
                </div>
            </div>
        </div>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">
                            ניווט
                        </li>
                        <li >
                            <a href="index.php"><i class="fas fa-home"></i> דף הבית</a>
                        </li>
                        <li>
                            <a href="feed.php"><i class="fa fa-recycle" aria-hidden="true"></i><b>פיד </b></a>
                        </li>
                        <li>
                             <a href="myPosts.php"><i class="fas fa-comment-dollar"></i>
                             מיחזורים שפרסמתי
                             </a>
                        </li>
                        <li>
                             <a href="paidRec.php"><i class="fas fa-file-invoice-dollar"></i>
                                מחזורים שקניתי
                             </a>
                        </li>
                        <li>
                             <a href="profile.php"><i class="fas fa-user"></i>
                            הפרופיל שלי            
                             </a>
                        </li>
                         <li>
                             <a href="help.php"><i class="fa fa-info"></i>
                            עזרה            
                             </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                       <?php
                       if($_GET['package']=="first")
                       {
                          
                            echo '
            <div class="alert alert-success" style="text-align:right;" role="alert">
                                  חבילת אלף בקבוקים עודכנה בהצלחה
</div>';
                       }
                       else if ($_GET['package']=="second")
                       {
                            echo '
            <div class="alert alert-success" style="text-align:right;" role="alert">
                                  חבילת שלושת אלפים בקבוקים עודכנה בהצלחה
</div>';
                           
                       }
                       else if ($_GET['package']=="third")
                       {
                            echo '
            <div class="alert alert-success" style="text-align:right;" role="alert">
                                  חבילת חמשת אלפים בקבוקים עודכנה בהצלחה
</div>';
                       }
                       
                       if($beyondLimit==true)
                       {
                           echo '
            <div class="alert alert-warning" style="text-align:right;" role="alert">
                                 הכמות המינימלית לפרסום בקבוקים היא עשרה בקבוקים
</div>';
                           
                       }
                       
                       
                       ?>
                        <h4 class="page-title">פוסט חדש</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                      

                        <form action=" " method="post"> 
                           
                            <div class="form-group">
                                <label>כמות בקבוקים מסוג 30 אגורות</label>
                                <input class="form-control" type="number" name="amountA" min="0" style="width:60%;">
                            </div>
                            <div class="form-group">
                                <label>כמות בקבוקים מסוג שקל ועשרים</label>
                                <input class="form-control" type="number" name="amountB" min="0" style="width:60%;">
                            </div>
                        
                            <div class="m-t-20 text">
                                <button class="btn btn-primary btn-lg" type="submit" name="publishPost" id="publishPost">הוסף לרשימת המיחזור</button>
                            </div>
                        </form>
                        <br>
                         <div class="alert alert-secondary" style="text-align:right;" role="alert">
לאחר שתלחץ על "הוסף לרשימת המיחזור"- הפוסט שלך יעלה לפיד ומשתמשים אחרים יוכלו לקנות את המיחזור שלך.
 <br>
 לאחר שמשתמש ירכוש את המיחזור שלך- הוא יקבל את פרטי הקשר שלך ויצור איתך קשר על מנת לתאם את איסוף הבקבוקים.
 <br>
 כאשר המיחזור שלך יירכש-תקבל התראה ופרטי הקשר של הקונה יוצגו בעמוד "המיחזורים שלי".
 <br>
 אם משהו עדיין לא ברור- אל תהסס להיעזר בעמוד 
 <b>
     <a href="http://eavni93.com/itay/help.php">העזרה</a>
 </b>
</div>
                    </div>
                </div>
            </div>
    
        </div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    <script type="text/javascript" src="assets/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="assets/js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.slimscroll.js"></script>
    <script type="text/javascript" src="assets/js/app.js"></script>
     <script>
        var userName='<?php echo $_SESSION['userName']; ?>';

         $(document).ready(function(){



        setInterval(function()
{ 

   $("#numOfNotifications").load("http://eavni93.com/itay/notifications.php", {
        action:"countNotifications",
       userName:userName
       
        
    });
    
      $("#notificationList").load("http://eavni93.com/itay/notifications.php", {
                userName:userName,
               action:"showNotifications"



        
    });



},2000);

//clear notifications after user clicked

$("#notificationButton").click(function(){
    
    
 $("#updateNumOfNotifications").load("http://eavni93.com/itay/notifications.php", {
                userName:userName,
               action:"clearNotifications"
    
});



});
         });
    
        
    </script>
</body>

</html>