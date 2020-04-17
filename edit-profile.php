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
                $tel=$row['tel'];
                $city=$row['city'];
                $street=$row['street'];
                $streetnum=$row['houseNumber'];
                $path=$row['profilePic'];
            }
       }
      
        $flag=false; 
       
       if(isset($_POST['updateSubmit']))
       {
           if(!empty($_FILES['uploaded_file']))
  {
    $path = "uploads/";
    $path .= $userName;
    
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
      echo "The file ".  basename( $_FILES['uploaded_file']['name']). 
      " has been uploaded";
      
      $path = "http://eavni93.com/itay/uploads/";
    $path .= $userName;
 $sql = "UPDATE users SET profilePic='".$path."'
      WHERE email='".$email."'
      ";    
      
   if (mysqli_query($conn, $sql))
   {
                
         $flag=true;

    }     } else{
        echo "There was an error uploading the file, please try again!";
    }
  }
           
           
       }
   


       
      
      //topchy
      
      
      
   if(isset($_POST['updateSubmit'])){
       if(!empty($_POST['cityc'])){
        $cityn=$_POST['cityc'];
      $sql = "UPDATE users SET city='".$cityn."'  WHERE email='".$email."'
      "; 

    if ($conn->query($sql) === TRUE) {
    
        $flag=true;
    }
   else {
    echo "Error updating record: " . $conn->error;
    }
}
}

if(isset($_POST['updateSubmit'])){
       if(!empty($_POST['streetc'])){
        $streetn=$_POST['streetc'];
      $sql = "UPDATE users SET street='".$streetn."'  WHERE email='".$email."'
      "; 

    if ($conn->query($sql) === TRUE) {
    
        $flag=true;
    }
   else {
    echo "Error updating record: " . $conn->error;
    }
}
}

if(isset($_POST['updateSubmit'])){
       if(!empty($_POST['houseNumberc'])){
        $houseNumbern=$_POST['houseNumberc'];
      $sql = "UPDATE users SET houseNumber='".$houseNumbern."'  WHERE email='".$email."'
      "; 

    if ($conn->query($sql) === TRUE) {
    
         $flag=true;
    }
   else {
    echo "Error updating record: " . $conn->error;
    }
}
}

if(isset($_POST['updateSubmit'])){
       if(!empty($_POST['telc'])){
        $teln=$_POST['telc'];
      $sql = "UPDATE users SET tel='".$teln."'  WHERE email='".$email."'
      "; 

    if ($conn->query($sql) === TRUE) {
    
         $flag=true;
    }
   else {
    echo "Error updating record: " . $conn->error;
    }
}
}
if($flag==true)
{
    echo '<script language="javascript">';
echo 'alert("פרטיך עודכנו בהצלחה")';
echo '</script>';
}



?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo2.jpg">
    <title>עריכת פרופיל</title>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
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
                        <span class="user-img"><img class="rounded-circle" src=
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
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">עריכת פרופיל</h4>
                    </div>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="card-box">
                        <h3 class="card-title">ערוך פרטים</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-img-wrap">
                                    <img class="inline-block" src=
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
                                   
                                    alt="user">
                                    <div class="fileupload btn">
                                        <span class="btn-text">ערוך</span>

                                        <input class="upload" type="file" id="file" name="uploaded_file">
                                     
                                     
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">עיר</label>
                                                <input type="text" class="form-control floating" name="cityc">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">רחוב</label>
                                                <input type="text" class="form-control floating" name="streetc">
                                            </div>
                                        </div>
                                      <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">מספר בית</label>
                                                <input type="text" class="form-control floating" name="houseNumberc">
                                            </div>
                                        </div>
                                       <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">מספר טלפון</label>
                                                <input type="text" class="form-control floating" name="telc">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                
                    <div class="text-center m-t-20">
                        <button class="btn btn-primary btn-lg" type="submit" name="updateSubmit">שמירת שינויים</button>
                    </div>
                </form>
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