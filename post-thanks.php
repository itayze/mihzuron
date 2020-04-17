<?php
require_once('config.php');

session_start();
if(!isset($_SESSION['userName']))
{
header("Location:login.php");
    exit();
}

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
                $email=$row['email'];
                $path=$row['profilePic'];
                $totalBottle=$row['totalBottle'];
            }
       }

if(isset($_GET['payment'])&&($_GET['username'])&&($_GET['postid']))
{
    $userName=$_GET['username'];
   $sql = "UPDATE posts SET paidUser='".$userName."' ,paid=1, datePaid=CURDATE()
      WHERE id='".$_GET['postid']."'
      "; 
       if (mysqli_query($conn, $sql))
   {
   
   }
  

  $sql="SELECT * from posts WHERE id='".$_GET['postid']."'";
        $result=$conn-> query($sql);
       if($result->num_rows>0)
           {
           $row=$result->fetch_assoc();
           
            $userPost=$row['userName'];
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
   $sql="SELECT * from users WHERE userName='".$userPost."'";
  $result=$conn-> query($sql);
       if($result->num_rows>0)
           {
               $totalBottle2=$row['totalBottle'];
               $pathUserInvolved=$row['profilePic'];
                
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
                    $my_date_time = date("Y-m-d H:i:s");
            $sql = "INSERT INTO notifications (owner,user_involved,sort,date,isSeen,fullDate,profilePic) VALUES ('".$userName."','".$userPost."',2,CURDATE(),0,'".$my_date_time."','".$path."')";

    if (mysqli_query($conn, $sql))
   {
        }
        else
        {
            
        }
           }
        
} 
?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo2.jpg">
    <title>סיום קנייה</title>
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
                          <li>
                             <a href="faq.php"> <i class="far fa-question-circle"></i>
                           שאלות ותשובות           
                             </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">
                            
                            תודה
                           <strong>
                            <?php
                            echo $userName;
                            ?>
                            </strong><br>
                            הפוסט שוריין בהצלחה, על מנת להשלים את התהליך אלו הן הפעולות אשר עליך לבצע:
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="activity">
                            <div class="activity-box">
                                <ul class="activity-list">
                                    <li>
                                        <div class="activity-user">
                                            <a  title="" data-toggle="tooltip" class="avatar">
                                               
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                              <strong>
                                              שלב 1
                                               </strong><br> 
                                              <a href="paidRec.php">
                                                  כעת תוכל לצפות בפרטי הקשר
                                           </a>
                                               
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="activity-user">
                                            <a class="avatar" title="" data-toggle="tooltip"></a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                               <strong>
                                                    שלב 2
                                               </strong><br> 
                                               צור קשר עם
                                              <strong>
                                               <?php
                                                
                                                 echo $userPost;
                                                ?>
                                                </strong>
                                               על מנת לקבוע פגישה.
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="activity-user">
                                             <a  title="" data-toggle="tooltip" class="avatar">
                                                
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                              <strong>
                                                  שלב 3
                                              </strong><br>
                                                במועד הפגישה, לאחר העברת הבקבוקים, מסור את קוד בן 4 הספרות ל 
                                               <strong>
                                                <?php
                                                echo $userPost;
                                                ?>
                                               </strong>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="activity-user">
                                             <a  title="" data-toggle="tooltip" class="avatar">
                                                
                                            </a>
                                            <br>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                               <strong>
                                                   שלב 4
                                               </strong><br>
                                                לך למחזר ותרום לכדור הארץ!
                                            </div>
                                        </div>
                                    </li>
                                    
                                    
                                        
                                    
                                </ul>
                            </div>
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