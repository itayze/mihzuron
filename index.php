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
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo2.jpg">
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
                        <li class="active">
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
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-success"><i class="fa fa-money" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h4>
                                    <?php
                                    $sum=0;
                                     $sql="SELECT * from posts WHERE userName=
                                     '".$_SESSION['userName']."' OR paidUser='".$_SESSION['userName']."'";
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
                                    echo '₪'.
                                    $sum;
                                    ?>
                                    
                                </h4>
                                <span> <br>רווח משוער </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-info"><i class="fa fa-user-o" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h4>
                                    <?php
                                   
                                     $sql="SELECT * from posts WHERE userName=
                                     '".$_SESSION['userName']."' ";
                                                       $result=$conn-> query($sql);
                                                       
                                                          
                                                          echo $result->num_rows;
                                    ?>
                                    
                                    
                                </h4>
                              <span>
                                  מחזורים שפרסמתי
                              </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-warning"><i class="fa fa-files-o"></i></span>
                            <div class="dash-widget-info">
                                <h4>
                                    <?php
                                     $sql="SELECT * from posts WHERE paidUser=
                                     '".$_SESSION['userName']."' ";
                                                       $result=$conn-> query($sql);
                                                       
                                                          
                                                          echo $result->num_rows;
                                    
                                    
                                    ?>
                                    
                                </h4>
                               <span>
                                   
                                   מחזורים שקניתי
                               </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-danger"><i class="fa fa-tasks" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h4>
                                    <?php
                                    $sql="SELECT * from posts WHERE date=
                                     CURDATE() ";
                                                       $result=$conn-> query($sql);
                                                       
                                                          
                                                          echo $result->num_rows;
                                    
                                    ?>
                                    
                                </h4>
                                <span>
                                    
                                    מחזורים היום
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                           <iframe src="ChartDemo.php" height="400" width="100%"></iframe>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card activity-panel">
                            <div class="card-body">
                                <h4 class="card-title">מיחזורים אחרונים</h4>
                                <div class="activity-box">
                                    <ul class="activity-list">
                                          <div class="contacts-list">
                                                <ul class="contact-list">
                                        <?php
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
                                                                <a href="" title=""><img src=
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
                                                       
                                                       
                                         ?>  
                                                </ul>
                                            </div>                                      
                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="card-footer text-center bg-white">
                                <a href="feed.php" class="text-muted">
                                    צפייה בכל המיחזורים
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card activity-panel">
                            <div class="card-body">
                                <h4 class="card-title">מידע נוסף </h4>
                                <div class="activity-box">
                                    <ul class="activity-list">
                                          <div class="contacts-list">
                                                <ul class="contact-list">
                                       <h4 class="card-title">הרמה שלך :</h4>
                               
                                  
                                        
                                           <div class="staff-id">  <?php
                                                        
                                               
                                               if($sum<1&&$sum>=0){
                                                           echo'<i class="fas fa-chess-pawn fa-3x"></i>';
                                                           echo'<br> <h4>
                                                           ממחזר מתחיל
                                                           <h4>';
                                               }
                                                           else if($sum>1&&$sum<=50){
                                                            echo'<i class="fas fa-chess-knight fa-3x"></i>';
                                                                 echo'<br> <h4>ממחזר מתקדם<h4>';
                                                           }
                                                             else if($sum>50){
                                                            echo'<i class="fas fa-chess-king fa-3x"></i>';
                                                                 echo'<br> <h4>ממחזר מלך<h4>';
                                                             }
                                                            else{ echo $sum ;}
                                                             
                                               ?>
                                                  </div> 
                                                
                       <!-- גודל  -->       
                     
                         <hr>
                         
                         <h3> עזרה</h3>
                         <a href="help.php"><i class="fa fa-info fa-3x"></i>
                           <br> לחץ כאן לעזרה             
                             </a>
                             
                            <hr>
                            <a href ="faq.php"><i class="far fa-question-circle fa-3x"></i>

 <br>
                            שאלות ותשובות
                            </a>
                                                </ul>
                                            </div>                                      
                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="card-footer text-center bg-white">
                                <a href="profile.php" class="text-muted">
                           צפייה בפרופיל שלי
                                </a>
                            </div>
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
    <script type="text/javascript" src="assets/js/select2.min.js"></script>
    <script type="text/javascript" src="assets/js/moment.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="assets/plugins/morris/morris.min.js"></script>
    <script type="text/javascript" src="assets/plugins/raphael/raphael-min.js"></script>
    <script type="text/javascript" src="assets/js/app.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
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