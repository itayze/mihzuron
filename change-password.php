<?php

require_once('config.php');

header('Content-type: text/html; charset=UTF-8');





if(isset($_POST['newPassSubmit'])) //the user has entered a new pass- lets update it
{
    
      $password=$_POST["password"];
    $repeatPassword=$_POST['repeatPassword'];
    $email=$_POST['email'];
    $token=$_POST['token'];
    
     if( ($password==null) || ($repeatPassword==null))
    {
                header("Location: change-password.php?error=missingfields&email=".$email."&token=".$token);
        
       //$errorpassOrNewPassMissing=true; 
        exit();
    }
    else if(strlen($password)<8 || strlen($password)>12)
    {
      header("Location: change-password.php?error=invalidpass&email=".$email."&token=".$token);

       // $errorInvalidPass=true;
        exit();
        
    }
      else if ( $password !=  $repeatPassword)
    {
              header("Location: change-password.php?error=passnotmatch&email=".$email."&token=".$token);

        
       // $errorPassDontMatch=true;
        exit(); 
    }
    else{ //no errors-lets update the new pass


  $hashedPassword= password_hash($password,PASSWORD_DEFAULT);

 $sql = "UPDATE users SET password='".$hashedPassword."' ,passwordResetKey=NULL
      WHERE email='".$email."'
      ";    
      
   if (mysqli_query($conn, $sql))
   {
                 header("Location: login.php?success=resetsuccess");


    }         
        
        
    }
    
    
    
    
}



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo2.jpg">
    <title>מיחזורון-איפוס ססמא</title>
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
                <h3 class="account-title">שינוי ססמא</h3>
                <div class="account-box">
                    <div class="account-wrapper">
                        <div class="account-logo">
                            <a href="index.php">   <img src="assets/img/logo2.jpg" width="60" height="50" alt=""></a>
                        </div>
                        <?php
                        if(isset($_GET['error']))
    {
                $error="";

        if($_GET['error']=='missingfields')
        {
              $error.="
            
                אופס, נראה כי חלק מהשדות ריקים. אנא הזן את הססמא בשדות המיועדים לכך ולחץ על עדכן ססמא.
";
            echo '
            <div class="alert alert-danger" role="alert" style="text-align:right;">
            '.$error.'
</div>'; 
            
        }
        if($_GET['error']=='invalidpass')
        {
              $error.="
            
                אופס, נראה כי הססמא אינה תקינה.
";
            echo '
            <div class="alert alert-danger" role="alert" style="text-align:right;">
            '.$error.'
</div>'; 
            
            
        }
                if($_GET['error']=='passnotmatch')
                {
                    
                    
                     $error.="
            
                אופס, נראה כי הססמאות שהזנת אינן זהות.
";
            echo '
            <div class="alert alert-danger" role="alert" style="text-align:right;">
            '.$error.'
</div>'; 
                    
                }
    

        
        
        
        
        
        
    }
    
    if(isset($_GET['token'])) //if a token was recieved in url
    {
        //now lets create a query to compate the token was recieved with the token in user table
        
        
$email=$_GET['email'];
$token=$_GET['token'];

 $sql="SELECT passwordResetKey FROM users WHERE email=?;";
        $stmt= mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
            header('location: login.php?error=sqlerror');
       exit();
            
        }
        else
        {
            
            mysqli_stmt_bind_param($stmt,"s",$email);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            
            if($row=mysqli_fetch_assoc($result)) //there is a row with this email
            {
                
                if($row['passwordResetKey']==$_GET['token']) //if they equal- we let the user update his password
                {
                    
                    

         echo'           
                     <form method="post" action="" id="setNewPass">
                          <!--  <div class="form-group form-focus">
                                <label class="focus-label">Current Password</label>
                                <input class="form-control floating" type="password"> 
                            </div> -->
                            <div class="form-group form-focus">
                                <label class="focus-label">ססמא חדשה</label>
                                <input class="form-control floating" type="password" name="password">
                            </div>
                            <div class="form-group form-focus">
                                <label class="focus-label">חזור על הססמא החדשה</label>
                                <input class="form-control floating" type="password" name="repeatPassword">
                            </div>
                            <input type="hidden" name="email" value='.$email.'>
                            <input type="hidden" name="token" value='.$token.'>
                            <div class="form-group m-b-0 text-center">
                                <button class="btn btn-primary btn-block account-btn" type="submit" name="newPassSubmit">שנה ססמא</button>
                            </div>
                        </form>
              ';      
                    
                    
                    
                    
                    
                    
                    
                }
               else 
                {
                   // header("Location:login.php");
                    //exit();
                    
                    echo'
                    <p> 
                    אופס, נראה שהקישור לא תקין
                    <br>
                    נסה
                    <a href="login.php">
                    להתחבר לאתר 
                    </a>
                    
                    </p>';
                    
                }
               
                
            }
             
}

        
    }
     else 
                {
                   // header("Location:login.php");
                    //exit();
                    
                    echo'
                    <p> 
                    אופס, נראה שנכנסת בדרך לא נכונה
                    <br>
                    נסה
                    <a href="login.php">
                    להתחבר לאתר 
                    </a>
                    
                    </p>';
                    
                }
    
    
    ?>
                        
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