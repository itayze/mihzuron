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
                $amountBot=$row['amountBot'];
            }
          
       }
       
       if(isset($_GET))
       {
           if($_GET['delete']=='true' && $_GET['id']!= NULL)
           {
               $sql="SELECT * FROM posts WHERE userName='".$_SESSION['userName']."' AND id='".$_GET['id']."'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) == 0) {
            header("Location: index.php");
            exit();
        }
        else 
        {
            $row = mysqli_fetch_assoc($result);
            $amountA=$row['amountA'];
            $amountB=$row['amountB'];
            $sum=$amountA+$amountB;
        }
        $amountBot=$amountBot-$sum;
        $sql="UPDATE users SET amountBot='".$amountBot."' WHERE userName='".$_SESSION['userName']."'";
        if ($conn->query($sql) == TRUE) {
                
                 } else {
                
                    }
               $sql="UPDATE posts SET isDeleted=1 WHERE id='".$_GET['id']."'";
               if ($conn->query($sql) == TRUE) {
                header("Location: myPosts.php");
                 } else {
                echo "Error deleting record: " . $conn->error;
                    }
            
                 $conn->close();
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
       
       //topchy 
       


//topchy
       
       
       
       

    //echo ((strtotime(date("Y-m-d")))-strtotime((date("Y-m-d", time() - 60 * 60 * 24))))/(60*60*24);
   
     $winWid=false;
         echo'<script type="text/javascript">
       if(window.innerWidth <= 800 && window.innerHeight <= 600) {
        $winWid=true;   
       }
       </script>';
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo2.jpg">
    <title>המיחזורים שלי</title>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.min.css">
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
                        <li class="active">
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
                        <h4 class="page-title">המיחזורים שלי</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <div class="card-block">
                                <h6 class="card-title text-bold">מיחזורים שפרסמתי</h6>
                                <p class="content-group">
                             כאן תוכל לראות את המיחזורים שפרסמת ותוכל ליצור קשר עם הקונה.
                                </p>
                                <table class="datatable table table-stripped" id="dtable">
                               <div class="contacts-list col-sm-8 col-lg-9">
                                                 <!--<ul class="contact-list" id="feed">-->
                              
                              <thead>
                                        <tr>
                                            <th>מספר מיחזור</th>
                                            <th>פרטי המיחזור</th>
                                            <th>סטאטוס</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                          <?php
                                                        
                                                        $sql="SELECT * from posts WHERE userName='".$_SESSION['userName']."' AND isDeleted='0' ORDER BY id LIMIT 250";
                                                       $result=$conn-> query($sql);
                                                       if($result->num_rows>0)
                                                       {
                                                           $i=1;
                                                           
                                                             while($row=$result->fetch_assoc())
                                                           {
                                                               echo '
                                                              <tr>
                                                              <td>'.$row['id'].'
                                                              </td>
                                                              <td>

                                                                <div class="contact-cont">
                                                            <div class="pull-left user-img m-r-10">
                                                                <a href="profile.php" title=""><img src=
                                                                '.$row['profilePic'].'
                                                                alt="" class="w-40 rounded-circle"><span class="status online"></span></a>
                                                            </div>
                                                            <div class="contact-info">
                                                                <span class="contact-name text-ellipsis">
                                                                 '  
                                                                 .$row['userName'].'<br>'   .getDateDiff($row['date']).'
                                                                    
                                                                   
                                                                </span>
                                                               
                                                                 <span class="contact-date">
                                                                שווי
                                                               </span>
                                                                <span class="contact-name text-ellipsis">
                                                                <strong>
                                                                 '.
                                                                 $row['revenue'].'</strong>
                                                                 </span>
                                                                  <span class="contact-date">
                                                                  רווח צפוי:
                                                                  </span>
                                                                   <span class="contact-name text-ellipsis">
                                                                  <strong>
                                                                  '.$row['revenue']/2 .'</strong> </span>
                                                                  </td>
                                                                <td>';
                                                                  
                                                                
                                                                if($row['paid']==1)
                                                                {
                                                                  if($row['isConfirmed']==0)
                                                                  {
                                                                    echo'  <span class="badge badge-info-border">
                                                                  נרכש
                                                                  </span>
                                                                  ' ;  
                                                                  }
                                                                  
                                                                  //
                                                                     $sql="SELECT * from users WHERE userName='".$row['paidUser']."'";
                                                       $result2=$conn-> query($sql);
                                                       if($result2->num_rows>0)
                                                       {
                        
                                                             $row2=$result2->fetch_assoc();
                                                                echo "<br> שם הקונה: ". $row2["userName"]. "
                                                                <br>
                                                                 טלפון: ". $row2["tel"]. " "  . "<br>";
                                                                                    
                                                                                } else {
                                                                                    echo "000 results";
                                                                                }
                                                                  
                                                                  //
                                                                }
                                                                else
                                                                {
                                                                 echo '  
                                                                 <span class="badge badge-warning-border">
                                                                 באוויר
                                                                 </span>
                                                                 ';
                                                                }
                                                              
                                                              echo' <br>';
                                                               if($row['paid']==0)
                                                               {
                                                               echo' <a href="edit-post.php?update=true&id='.$row['id'].'" class="btn btn-white btn-sm m-t-10">
                                                              ערוך מיחזור
                                                               </a><br>
                                                               
                                                              
                                                                   <a href="myPosts.php?delete=true&id='.$row['id'].'" class="btn btn-white btn-sm m-t-10" ">
                                                                מחק מיחזור
                                                               </a><br>';
                                                               }
                                                              if($row['isConfirmed']==0)
                                                              {
                                                                echo'
                                                               <!DOCTYPE HTML>
                                                               <html>
                                                               <head>
                                                               </head>
                                                               <body>
                                                               <br>
                                                              <form action="finish-deal.php" method="post">
                                                               <div class="form-group row form-focus">
                                                               <input type="hidden" value="'.$row['id'].'" name="id">
                                                               
                                                               
                                                               
                                                              <div class="col-xs-2">
                                                               <input class=" input-sm" type="text" style="width:80px;height:40px;" name="fourCode" id="fourCode" 
                                                               placeholder="קוד 4 ספרות">
                                                               </div>
                                                               <button class="btn btn-primary btn-sm" type="submit" style="height:40px" name="fourDigitSubmit">
                                                               אשר
                                                               </button>
                                                               </div>
                                                               </form>
                                                               </body></html>
                                                              </td>
                                                              </tr>
                                                                  ';  
                                                              }
                                                              else
                                                              {
                                                                echo'  <span class="badge badge-success-border">
                                                                  הושלם
                                                                  </span>';
                                                              }
                                                              
                                                                  
                                                          
                                                                     
                                                                        
                                                                                                                                                    
                                                                     

                                                           }
                                                       }
                                                           ?>
                                    
                                       
                                    </tbody>
                                </table>
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
    <script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="assets/js/dataTables.bootstrap4.min.js"></script>
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