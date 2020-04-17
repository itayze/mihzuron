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
    <title>מיחזורים שקניתי</title>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
 <style>
     #navButton
     {
         padding: 10px 10px 10px 36px;
    font-family: "Trebuchet MS", Arial, Verdana;   
    background: #e9e9e9 url(http://eavni93.com/app/uploads/Wazeicon.png) 1px 1px no-repeat;
    border-radius: 16px;
    border: 1px solid #d9d9d9;
    text-shadow: 1px 1px #fff;
	
	
     }
     #callButton
     {
         padding: 10px 10px 10px 36px;
    font-family: "Trebuchet MS", Arial, Verdana;   
    background: #e9e9e9 url(http://eavni93.com/app/uploads/phone.png) 7px 7px no-repeat;
    border-radius: 16px;
    border: 1px solid #d9d9d9;
    text-shadow: 1px 1px #fff;
    color:black;
     }
     
 </style>
	
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
                        <li>
                             <a href="myPosts.php"><i class="fas fa-comment-dollar"></i>
                             מיחזורים שפרסמתי
                             </a>
                        </li>
                        <li class="active">
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
                        <h4 class="page-title">מיחזורים שרכשת</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <div class="card-block">
                                <h6 class="card-title text-bold">מיחזורים שקניתי</h6>
                                <p class="content-group">
                                   כאן תוכל לצפות בכל המחזורים אשר קנית וליצור קשר עם בעלי הבקבוקים למיחזור.
                               בעת איסוף הבקבוקים מסור את קוד בן 4 הספרות על מנת להשלים את התהליך.
                                </p>
                                <table class="datatable table table-stripped" id="dtable">
                               <div class="contacts-list col-sm-8 col-lg-9">
                                                  <ul class="contact-list" id="feed">
                              
                              <thead>
                                        <tr>
                                            <th>מספר מיחזור</th>
                                            <th>פרטי המיחזור</th>
                                            <th>יצירת קשר</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                          <?php
                                                        
                                                        $sql="SELECT * from posts WHERE paidUser='".$_SESSION['userName']."' ORDER BY id LIMIT 250";
                                                       $result=$conn-> query($sql);
                                                       if($result->num_rows>0)
                                                       {
                                                           $i=0;
                                                             while($row=$result->fetch_assoc())
                                                           {
                                                              
                                                               echo '
                                                              <tr>
                                                              <td>'.$row['id'].'
                                                              </td>
                                                              <td>

                                                                <div class="contact-cont">
                                                            <div class="pull-left user-img m-r-10">
                                                                <a href="" title=""><img src=
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
                                                                <td>
                                                                 <span class="contact-date">
                                                                 עיר:   
                                                             </span>
                                                              <span class="contact-name text-ellipsis">
                                                             <strong>
                                                             '.  
                                                             $row['city'].'</strong>.'
                                                             .' 
                                                              </span>
                                                              <span class="contact-date">
                                                            רחוב:
                                                            </span>
                                                            <span class="contact-name text-ellipsis">
                                                             <strong>'
                                                             . $row['street'].'</strong>'.
                                                             '
                                                                </span>
                                                                 <span class="contact-date">
                                                                 מספר בית:
                                                                 </span>
                                                                 <span class="contact-name text-ellipsis">
                                                                 '.$row['houseNumber'].'
                                                                 </span>
                                                                 <span class="contact-date">
                                                                    מספר טלפון:
                                                                    </span>
                                                                    <span class="contact-name text-ellipsis">
                                                                   <strong>
                                                                   '.$row['tel'].'
                                                                   </strong></span>';
                                                                   $fullAdress= $row['street'].' '. $row['houseNumber'].' '.$row['city'];
                                                                   echo $fullAddress;
                                                                  ?>
                                                              <?php
                                                                        $useragent=$_SERVER['HTTP_USER_AGENT'];
                                                                        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
                                                                
                                                                        { 
                                                                         
                                                                                                           $phone = $row['tel'];
                                                                            echo '
                                                                            <br>
                                                                            <br>
                                                                            <span class="contact-date">
                                                                            <a href=tel:'.$phone.' id="callButton">
                                                                            לחץ לחיוג
                                                                            </a>'.'
                                                                            </span><br><br>

                                                                            <input type="hidden" value="'.$fullAdress.'" id='.$i.'>';
                                                                             echo '
                                                                               <span class="contact-date">
                                                                            <button type="submit" id="navButton" value="click to nav" onclick="encode('.$i.')">נווט</button></span<br>';
                                                                            $i++;
                                                                             echo'
   <script>
                     
                                                           
                         function nav(str)
                            {
                            var base="https://waze.com/ul?q=";
                            var search=base+str;
                            
                            window.open(search,"_self");
                                }
                                function encode(i)
                                {
                             var str=document.getElementById(i).value;
                             
                                
                                 var newStr=encodeURI(str);
  
                                 nav(newStr);
                                  }
                    
            
                    </script>
  ';
                                                                            
                                                                            
                                                                        }
                                                                        else{
                                                                            echo "";
                                                                        }
                                                                
                                                                 
                                                                   
                                                            
                                                                    echo'
                                                                   </script><br><br>
                                                                    <span class="contact-date">
                                                                   קוד בן 4 ספרות:
                                                                   </span>
                                                                   <span class="contact-name text-ellipsis">
                                                                   <strong>
                                                                   '.$row['code'].'
                                                                   </strong>
                                                                   
                                                                  </span>

                                                                  ';
                                                                   
                                                                  
                                                          echo'  </div>';
                                                            if($row['userName']==$userName)
                                                            {
                                                              echo '
                                                              <ul class="contact-action">
                                                                <li class="dropdown dropdown-action">
                                                                    <a href="" class="dropdown-toggle action-icon" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" href="javascript:void(0)">Edit</a>
                                                                        <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                                                        
                                                                        
                                                                    </div>
                                                                    
                                                                </td></tr>
                                                            </ul>
                                                              
                                                              
                                                              
                                                              
                                                              '   ;
                                                            }
                                                           
                                                            echo ' <br>
                                                        </div> ';
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