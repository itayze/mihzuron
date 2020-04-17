<?php
require_once('config.php');


header('Content-type: text/html; charset=UTF-8');




if (isset($_POST['loginButton']))
{

    $name=$_POST['name'];
    $pass=$_POST['password'];
    
    
    if(empty($name) || empty($pass))
    {
        header('location: login.php?error=emptyfields');
       exit();
        
    }
    else
    {
        $sql="SELECT * FROM users WHERE userName=? OR email=?;";
        $stmt= mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
             header('location: login.php?error=sqlerror');
       exit();
            
        }
        else
        {
            
            mysqli_stmt_bind_param($stmt,"ss",$name,$name);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            
            if($row=mysqli_fetch_assoc($result))
            {
                
                
                $pwdCheck= password_verify($pass,$row['password']);
                if($pwdCheck==false)
                {
                     header('location: login.php?error=wrongpassword');
                       exit();
                    
                }
                else if($pwdCheck==true)
                {
                    session_start();
                    $_SESSION['userName']=$row['userName'];
                    $_SESSION['userEmail']=$row['email'];
                  header('location: index.php?login=success');

                    
                }
                else
                {
                    header('location: login.php?error=wrongpassword');
                     exit();
                    
                }
            }
            else
            {
                 header('location: login.php?error=nouser');
       exit();
                
            }
            
        }
        
        
    }
    

}
else
{
    
      //header('location: login.php');
       //exit();

    
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo2.jpg">
    <title>מיחזורון-התחבר לאתר</title>
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
        <div class="account-page">
            <div class="container">
                <h3 class="account-title">התחבר לאתר</h3>
                <div class="account-box">
                    <div class="account-wrapper">
                        <div class="account-logo">
                            <a href="index.php"><img src="assets/img/logo2.jpg" alt=""></a>
                        </div>
                        <?php //show error messages to user when trying to log in
    
    if(isset ($_GET['success']))
    {
        if($_GET['success']=='resetsuccess')
        {
            echo '
            <div class="alert alert-success" style="text-align:right;" role="alert">
  הססמא שונתה בהצלחה, כעת אתה יכול להתחבר עם הפרטים החדשים
</div>';
            
        }
        
        
        
        
    }
    
    
    if(isset($_GET['error']))
    {
        $error="";
        
        if($_GET['error']=='emptyfields')
        {
            $error="
              אופס, נראה כי השדות ריקים. אנא מלא את פרטי הכניסה ולחץ התחבר
";
            echo '
            <div class="alert alert-danger" role="alert" style="text-align:right;">
            '.$error.'
</div>'; 
            
        }
        else if ($_GET['error']=='wrongpassword' ||  $_GET['error']=='nouser' || $_GET['error']=='sqlerror' )
        { 
            $error="
            אופס,פרטי ההתחברות שגויים. אנא נסה שוב או לחץ על שכחתי ססמא
            ";
              echo '
            <div class="alert alert-danger" role="alert" style="text-align:right;">
            '.$error.'
</div>'; 
            
        }
        
        
    }
    
    
    
    ?>
                        <form method="post" action="" id="contactForm">
                            <div class="form-group form-focus">
                                <label class="focus-label">שם משתמש או כתובת מייל</label>
                                <input class="form-control floating" type="text" id="name" name="name">
                            </div>
                            <div class="form-group form-focus">
                                <label class="focus-label">ססמא</label>
                                <input class="form-control floating" type="password" id="password"
name="password">
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary btn-block account-btn" type="submit" id="loginButton" name="loginButton">כניסה</button>
                            </div>
                            <div class="text-center">
                                <a href="forgot-password.php">שכחתי ססמא</a>
                                
                            </div>
                        </form>
                        <form action="register.php"  method="post">
     <input class="btn btn-primary btn-block account-btn" type="submit"
 value="הרשמה לאתר" id="signUp" name="signUp" >
     
 </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="assets/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="assets/js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/app.js"></script>
</body>

</html>