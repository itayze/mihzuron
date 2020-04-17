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
                        <h3 class="page-title">
                         
                          נראה כי עברת את כמות הבקבוקים המותרת לך לפירסום.
                          
                           </h3> 
                           <h4>
                               יש צורך בלקנות חבילה מאחת החבילות המוצאות כאן.
                           </h4>
                          
                                            </div>
                                        </div>
                                    </li>
                             
                                    
                                    
                                        
                                    
                                </ul>
                            </div>
                                     <div class="content container-fluid">
                <div class="row">
                    <div class="col-sm-8 col-4">
                        <h4 class="page-title">החבילות שלנו</h4>
                        <div id="updateStatus"></div>
                        <div id="buttonToAddPost"></div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                        <div class="pricing-box">
                            <h3 class="pricing-title">חינם</h3>
                            <h1 class="pricing-rate">0 ₪</h1>
                            <p>
חבילת הכרות- למשתמשים חדשים                                <br>
                                </p>
                            <ul>
                                <li><i class="fa fa-check" aria-hidden="true"></i> <b>1000 בקבוקים</b></li>
                                <li><i class="fa fa-check" aria-hidden="true"></i> צפייה ללא הגבלה בפיד </li>
                                <li><i class="fa fa-check" aria-hidden="true"></i> איתור מיחזורים הסמוכים לאזורכם
                              </li>
                               <li><i class="fa fa-check" aria-hidden="true"></i> אפשרות לרכישת פוסטים ללא הגבלה, כולל פוסטים שעלו בשעה האחרונה למערכת
                              </li>

                                <li>&nbsp;</li>
                            </ul>
                            
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                        <div class="pricing-box">
                            <h3 class="pricing-title">בסיסית</h3>
                            <h1 class="pricing-rate">10 ₪</h1>
                            <ul>
                                <li><i class="fa fa-check" aria-hidden="true"></i> <b>1000 בקבוקים נוספים לפירסום</b></li>
                                <li><i class="fa fa-check" aria-hidden="true"></i> צפייה ללא הגבלה בפיד </li>
                                <li><i class="fa fa-check" aria-hidden="true"></i> איתור מיחזורים הסמוכים לאזורכם
                              </li>
                               <li><i class="fa fa-check" aria-hidden="true"></i> אפשרות לרכישת פוסטים ללא הגבלה, כולל פוסטים שעלו בשעה האחרונה למערכת
                              </li>
                            </ul>
                                                                    <div id="paypal-button1-container"> </div>

                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                        <div class="pricing-box">
                            <h3 class="pricing-title">עסקית</h3>
                            <h1 class="pricing-rate">15 ₪</h1>
                            <ul>
                                <li><i class="fa fa-check" aria-hidden="true"></i> <b>3000 בקבוקים נוספים לפירסום</b></li>
                                <li><i class="fa fa-check" aria-hidden="true"></i> צפייה ללא הגבלה בפיד </li>
                                <li><i class="fa fa-check" aria-hidden="true"></i> איתור מיחזורים הסמוכים לאזורכם
                              </li>
                               <li><i class="fa fa-check" aria-hidden="true"></i> אפשרות לרכישת פוסטים ללא הגבלה, כולל פוסטים שעלו בשעה האחרונה למערכת
                              </li>
                            </ul>
                                                                    <div id="paypal-button2-container"> </div>

                        </div>
                    </div>
              <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                        <div class="pricing-box">
                            <h3 class="pricing-title">פרימיום</h3>
                            <h1 class="pricing-rate">18 ₪</h1>
                            <ul>
                                <li><i class="fa fa-check" aria-hidden="true"></i> <b>5000 בקבוקים נוספים לפירסום</b></li>
                                <li><i class="fa fa-check" aria-hidden="true"></i> צפייה ללא הגבלה בפיד </li>
                                <li><i class="fa fa-check" aria-hidden="true"></i> איתור מיחזורים הסמוכים לאזורכם
                              </li>
                               <li><i class="fa fa-check" aria-hidden="true"></i> אפשרות לרכישת פוסטים ללא הגבלה, כולל פוסטים שעלו בשעה האחרונה למערכת
                              </li>
                            </ul>
                                                                    <div id="paypal-button3-container"> </div>

                        </div>
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
    <script type="text/javascript" src="assets/js/app.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <script type="text/javascript" src="https://www.paypal.com/sdk/js?client-id=ASEkXsE1NUHmUybQs-1rTJNlutmDERCNBlVl9cT0xTeE7EPkWB2WGhXSthjbSTqhweo7B144hNkchRGO&currency=ILS&locale=he_IL"></script>
 <script>
        // Render the PayPal button into #paypal-button-container
     
             

            
        
        paypal.Buttons({
            style:{
                layout:'horizontal',
                color: 'silver',
                shape:'pill',
                label:'paypal',
                size:'responsive'
            },
            // Set up the transaction
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: 10
                        }
                    }]
                });
            },

            // Finalize the transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    $("#updateStatus").load("http://eavni93.com/itay/updatePackage.php", {
       package:"first"
    });
    
    
                    
                     window.location.replace("add-post.php?package=first");
                });
            }


        }).render('#paypal-button1-container');
        
          paypal.Buttons({
            style:{
                layout:'horizontal',
                color: 'silver',
                shape:'pill',
                label:'paypal',
                size:'responsive'
            },
            // Set up the transaction
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: 15
                        }
                    }]
                });
            },

            // Finalize the transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Show a success message to the buyer
                     $("#updateStatus").load("http://eavni93.com/itay/updatePackage.php", {
       package:"second"
    });
                     window.location.replace("add-post.php?package=second");
                });
            }


        }).render('#paypal-button2-container');
        
          paypal.Buttons({
            style:{
                layout:'horizontal',
                color: 'silver',
                shape:'pill',
                label:'paypal',
                size:'responsive'
            },
            // Set up the transaction
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: 18
                        }
                    }]
                });
            },

            // Finalize the transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Show a success message to the buyer
                     $("#updateStatus").load("http://eavni93.com/itay/updatePackage.php", {
       package:"third"
    });
                     window.location.replace("add-post.php?package=third");
                });
            }


        }).render('#paypal-button3-container');
      
    </script>
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