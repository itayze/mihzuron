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
            }
          
       }
       
       
       
       
       
       
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <title>מיחזורון-ההתראות שלי</title>
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
                <h3>מיחזורון</h3>
            </div>
            <a id="mobile_btn" class="mobile_btn pull-left" href="#sidebar"><i class="fa fa-bars" aria-hidden="true"></i></a>
            <ul class="nav user-menu pull-right">
                <li class="nav-item dropdown">
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
                            <a href="notificationList.php">
הצג את כל ההתראות                            
                            </a>
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
                        <span>
                            <?php
          echo $userName;
          ?>
                            
                        </span>
                    </a>
					<div class="dropdown-menu">
					    
						<a class="dropdown-item" href="profile.php">הפרופיל שלי</a>
						<a class="dropdown-item" href="edit-profile.php">ערוך פרופיל</a>
					
						<a class="dropdown-item" href="login.php">התנתק</a>
						
					</div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu pull-right">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.php">My Profile</a>
                    <a class="dropdown-item" href="edit-profile.php">Edit Profile</a>
                    <a class="dropdown-item" href="login.ph">Logout</a>
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
                        <li>
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
                        <h4 class="page-title">התראות</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="activity">
                            <div class="activity-box">
                                <ul class="activity-list">
                                    <?php
                                    
                               $sql="SELECT * from notifications where owner='".$userName."' ORDER BY id DESC LIMIT 40";
                                 $result=$conn-> query($sql);
                                                       if($result->num_rows>0)
                                                       {
                                                           
                                                           while($row=$result->fetch_assoc())
                                                           {
                                                               
                                                               //let's differentiate between different sorts of notification
                                                               
                                                               if($row['sort']==1) //1=someone bought my Mihzur
                                                               {
                                                                    $sql="SELECT * from users where userName='".$row['user_involved']."'";
                                                                   $result2=$conn-> query($sql);
                                                       if($result2->num_rows>0)
                                                       {
                                                         $row2=$result2->fetch_assoc();
                                                         $pathOfInvolved=$row2['profilePic'];
                                                       }  
                                                        
                                                                   
                                                                   //new
                                                                    echo '
                                                                    <li>
                                        <div class="activity-user">
                                            <a href="" title="" data-toggle="tooltip" class="avatar">
                                                <img alt="" src='; 
                                    if($pathOfInvolved !=NULL)
                                    {
                                        echo "$pathOfInvolved";
                                    }
                                    else
                                    {
                                        echo  "assets/img/user.jpg" ;
                                    }

                                                
                                                echo ' class="img-fluid rounded-circle">
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                                <a href="" class="name">'.$row['user_involved'].'</a> 
                                            קנה את המיחזור שלך, 
                                            היכנס עכשיו ל
												<a href="http://eavni93.com/itay/myPosts.php">
												מיחזורים שלי
                                        
                                         
                                                <span class="time">'.$row['fullDate'].'</span>
                                            </div>
                                        </div>
                                    </li> ';
                                                                   
                                                                   
                                                                   
                                                               }
                                                               else if($row['sort']==2) //i bought someone else's Mihzur
                                                               {
                                                                
                                                                $sql="SELECT * from users where userName='".$row['user_involved']."'";
                                                                   $result2=$conn-> query($sql);
                                                       if($result2->num_rows>0)
                                                       {
                                                         $row2=$result2->fetch_assoc();
                                                         $pathOfInvolved=$row2['profilePic'];
                                                       }  
                                                                      
                                                               
                                     echo '
                                                                    <li>
                                        <div class="activity-user">
                                            <a href="" title="" data-toggle="tooltip" class="avatar">
                                                <img alt="" src='; 
                                    if($pathOfInvolved !=NULL)
                                    {
                                        echo "$pathOfInvolved";
                                    }
                                    else
                                    {
                                        echo  "assets/img/user.jpg" ;
                                    }

                                                
                                                echo ' class="img-fluid rounded-circle">
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                                <a href="" class="name">'.$row['owner'].'</a> 
	קנית את המיחזור של
'.$row['user_involved'].'
	היכנס עכשיו ל
												<a href="http://eavni93.com/itay/paidRec.php">
											מחזורים שקניתי
												</a>
                                        
                                         
                                                <span class="time">'.$row['fullDate'].'</span>
                                            </div>
                                        </div>
                                    </li> ';
                                                                   
                                                                   
                                                               }
                                                               else if ($row['sort']==4)//someome else has aprroved his Mihzur from me
                                                               {
                                                                   $sql="SELECT * from users where userName='".$row['user_involved']."'";
                                                                   $result2=$conn-> query($sql);
                                                       if($result2->num_rows>0)
                                                       {
                                                         $row2=$result2->fetch_assoc();
                                                         $pathOfInvolved=$row2['profilePic'];
                                                       }   
                                                                    
                                                                    
                                            
                                       
                                     echo '
                                                                    <li>
                                        <div class="activity-user">
                                            <a href="" title="" data-toggle="tooltip" class="avatar">
                                                <img alt="" src='; 
                                    if($pathOfInvolved !=NULL)
                                    {
                                        echo "$pathOfInvolved";
                                    }
                                    else
                                    {
                                        echo  "assets/img/user.jpg" ;
                                    }

                                                
                                                echo ' class="img-fluid rounded-circle">
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                                <a href="" class="name">'.$row['user_involved'].'</a> 
	

													אישר את המיחזור
                                        
                                         
                                                <span class="time">'.$row['fullDate'].'</span>
                                            </div>
                                        </div>
                                    </li> ';                                                       
                                                                   
                                                                   
                                                               }
                                                                   else if ($row['sort']==3)//i approved someone else's Mihzur   not working (eliran) check in yaniv
                                                               {
                                                                   $sql="SELECT * from users where userName='".$row['user_involved']."'";
                                                                   $result2=$conn-> query($sql);
                                                       if($result2->num_rows>0)
                                                       {
                                                         $row2=$result2->fetch_assoc();
                                                         $pathOfInvolved=$row2['profilePic'];
                                                       }  
                                                                   
             echo '
                                                                    <li>
                                        <div class="activity-user">
                                            <a href="" title="" data-toggle="tooltip" class="avatar">
                                                <img alt="" src='; 
                                    if($pathOfInvolved !=NULL)
                                    {
                                        echo "$pathOfInvolved";
                                    }
                                    else
                                    {
                                        echo  "assets/img/user.jpg" ;
                                    }

                                                
                                                echo ' class="img-fluid rounded-circle">
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                                <a href="" class="name">'.$row['owner'].'</a> 
    אישרת את המיחזור מול	
	'.$row['user_involved'].'

										היכנס עכשיו ל		
												<a href="http://eavni93.com/itay/myPosts.php">
												מיחזורים שלי
											</a>
                                        
                                         
                                                <span class="time">'.$row['fullDate'].'</span>
                                            </div>
                                        </div>
                                    </li> ';                                                   
                                                                   
                                                               }
                                                               else if($row['sort']==5)//i just uploaded a new Mihzur
                                                               {
                                                                  
                                                               //new
                                                                   echo '
                                                                    <li>
                                        <div class="activity-user">
                                            <a href="" title="" data-toggle="tooltip" class="avatar">
                                                <img alt="Lesley Grauer" src='; 
                                    if($path !=NULL)
                                    {
                                        echo "$path";
                                    }
                                    else
                                    {
                                        echo  "assets/img/user.jpg" ;
                                    }

                                                
                                                echo ' class="img-fluid rounded-circle">
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                                <a href="" class="name">'.$row['owner'].'</a> 
	הוספת מיחזור חדש!
	היכנס עכשיו ל
												<a href="http://eavni93.com/itay/myPosts.php">
												מיחזורים שלי
                                        
                                         
                                                <span class="time">'.$row['fullDate'].'</span>
                                            </div>
                                        </div>
                                    </li> ';
                                                               
                                                               
                                                                   
                                                               }
                                                               
                                                               
                                                               
                                                              
                                                               
                                                               
                                                               
                                                           }
                                                       }
                                    
                                    ?>
                                    
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