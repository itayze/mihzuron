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

if(isset($_POST['pay']))
{
     $postId=$_POST['postId'];

          $sql="SELECT * from posts WHERE id=$postId ";
          $result=$conn-> query($sql);
          if($result->num_rows>0)
          {
              $row=$result->fetch_assoc();
              $postId=$row['postId'];
         echo     $row['userName'];
          }
}

   if(isset ($_GET['savePost']))
{
$postId=$_GET['id'];
     header('location:post-thanks.php?payment=success&username='.$userName.'&postid='.$postId);
} 


?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo2.jpg">
    <title>תשלום</title>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/fullcalendar.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/plugins/light-gallery/css/lightgallery.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
	
	    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
                         <li >
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
                        <h4 class="page-title">פרטי הקנייה שלך</h4>
                    </div>
                </div>
                <div class="card-box">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="product-view">
                                <div class="proimage-wrap">
                                    <div class="pro-image" id="pro_popup">
                                        <a href="assets/img/product/product-01.jpg">
                                            <img class="img-fluid" src="assets/img/re.jpg" alt="">
                                        </a>
                                    </div>
                                    <ul class="proimage-thumb">
                                        <li>
                                            <a href="assets/img/re.jpg"><img src="assets/img/re.jpg"  alt=""></a>
                                        </li>
                                        <li>
                                            <a href="assets/img/re1.jpg"><img src="assets/img/re1.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="assets/img/re3.jpg" ><img src="assets/img/re3.jpg"  alt=""></a>
                                        </li>
                                        <li>
                                            <a href="assets/img/re4.jpg"><img src="assets/img/re4.jpg" alt=""></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="product-info">
                                <h2>
                                    <?php
                                             echo     $row['userName'];

                                    ?>
                                </h2>
                                <p>
                                   תאריך:
                                   <?php
                                   echo $row['date'];
                                   ?>
                                </p>
                                <div class="rating">
                                    <p>
                                        <span><i class="fa fa-star rated"></i></span>
                                     
                                        <span>מומלץ על ידי המערכת</span>
                                    </p>
                                </div>
                                <p class="product_price" style="font-size:20px; font-weight:400;">
                                    שווי:
                                    <?php
                                    echo 
                                    
                                    '<span> '.$row['revenue'].' ₪</span> ';
                                    ?>
                                </p>
                                <p class="product_price" style="font-size:20px;  font-weight:400;">
                                   רווח משוער:
                                    <?php
                                    echo 
                                    
                                    '<span id="price" style="color:green;  "> '.($row['revenue']/2) 
                                    
                                    .' </span>
                                    <span>
                                    ₪</span> ';
                                    ?>
                                    </p>
                                   <p class="product_price" style="font-size:17px;  font-weight:400; color: red">
                                       במידה ולאחר 48 שעות לא הוזן הקוד האישי פוסט זה יוחזר לפיד.
                                       </p>
                                    <small>
לאחר רכישת המיחזור תקבל את פרטי הקשר של בעל המיחזור, תוכל ליצור איתו קשר ולתאם איתו את איסוף המיחזור.

                                    </small>
                                    <br>
                                     <small>
לאחר שתרכוש את המיחזור, משתמשים אחרים כבר לא יוכלו לצפות בו ולרכוש אותו.
                                    </small>
                               
                                <p><b>זמינות המיחזור:</b> 
                                <?php
                                if ($row[paid]==0)
                                {
                                    echo '<span style="color:#55CE63; font-weight:bold;">
                                   זמינות מיידית 
                                </span>';
                                }
                                else
                                {
                                     echo '<span style="color:red; font-weight:bold;">
                                   לא זמין למיחזור 
                                </span>';
                                }
                                ?>
                                
                                </p>
                                <form>
                               <input type="hidden" name="id" value=<?php echo $row['id'] ;?>>
                               <button class="btn btn-primary" type="submit" name="savePost">שריין פוסט</button>
                               </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                           
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
    <script type="text/javascript" src="assets/plugins/light-gallery/js/lightgallery-all.min.js"></script>
    <script type="text/javascript" src="assets/js/app.js"></script>
  <script type="text/javascript" src="https://www.paypal.com/sdk/js?client-id=ASEkXsE1NUHmUybQs-1rTJNlutmDERCNBlVl9cT0xTeE7EPkWB2WGhXSthjbSTqhweo7B144hNkchRGO&currency=ILS&locale=he_IL"></script>

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