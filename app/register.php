<?php
header("Access-Control-Allow-Origin: *");
require_once('config.php');



//if (isset($_POST['registerButton'])|| isset($_GET['pressed']) ||isset($_POST['signUp']))



   
         
    $name=$_POST["name"];
    $password=$_POST["password"];
    $repeatPassword=$_POST["repeatPassword"];
    $email=$_POST["email"];
    $city=$_POST["city"];
    $street=$_POST["street"];
    $houseNumber=$_POST["houseNumber"];
    $tel=$_POST["tel"];
    
    if(($name==null) || ($password==null) || ($repeatPassword==null) || ($email==null))
    {
        echo json_encode("missingfields");
        exit();
    }
    else if (!filter_var($email,FILTER_VALIDATE_EMAIL)&& !preg_match("/^[a-zA-Z0-9]*$/",$name))
    {
         echo json_encode("invalidemailanduser");
        exit();
    }
  
    else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
         echo json_encode("invalidemail");
        exit();
        
    }
    
    else if (!preg_match("/^[a-zA-Z0-9]*$/",$name))
    {
          echo json_encode("invalidusername");
        
        exit();
    }
    else if(strlen($password)<8 || strlen($password)>12)
    {
        echo json_encode("passwordlength");
        
        exit(); 
    }
    else if ( $password !=  $repeatPassword)
    {
       echo json_encode("passwordCheck");
      
        exit(); 
    }
   else
   {
       $sql="SELECT * FROM users WHERE userName=? OR email=?";
       $stmt=mysqli_stmt_init($conn);
       if (!mysqli_stmt_prepare($stmt,$sql))
       {
           echo json_encode("sqlerror");
           
        exit();
       }
       else
       {
           mysqli_stmt_bind_param($stmt,"ss",$name, $email);
           mysqli_stmt_execute($stmt);
           mysqli_stmt_store_result($stmt);
           $result=mysqli_stmt_num_rows($stmt);
           if($result >0)
           {
                echo json_encode("useralreadytaken");
               
        exit();
           }
           else
           {
              $sql="INSERT INTO users (userName, password, email, city, street, houseNumber, dateRegister,tel) VALUES (?,?,?,?,?,?,CURDATE(),?)"; 
                 $stmt=mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt,$sql))
                 {
                  echo json_encode("sqlerror");
                 
                 exit();
                }
                else
                {
                   $hashedPassword= password_hash($password,PASSWORD_DEFAULT);
                   
                   
                    mysqli_stmt_bind_param($stmt,"sssssss",$name,$hashedPassword, $email,$city,$street,$houseNumber,$tel);
                    mysqli_stmt_execute($stmt);
                     echo json_encode("success");
                   
                    exit();
                }
           }
       }
   }
       mysqli_stmt_close($stmt);
       mysqli_close($conn);
     
   


/*else if(!isset($_GET['pressed'])&& !isset($_POST['registerButton']) && !isset($_GET['error']))
{
    header ("Location: index.html");
    exit();
}*/


    
    
   /* if(isset($_GET['error']))
    {
        $error="";
        
        if($_GET['error']=='missingfields')
        {
            $error.="
            
                אופס, נראה כי חלק מהשדות ריקים. אנא מלאו את כל פרטי ההרשמה ולחץ על הרשם.
";
$errorMissingFields=true;
            echo '
            <div class="alert alert-danger" role="alert" style="text-align:right;">
            '.$error.'
</div>'; 
            
        }
         if ($_GET['error']=='wrongpassword' ||  $_GET['error']=='nouser' || $_GET['error']=='sqlerror' )
        { 
            $error.="
                    אופס, פרטי ההרשמה שגויים, אנא נסה שוב.

            ";
              echo '
            <div class="alert alert-danger" role="alert" style="text-align:right;">
            '.$error.'
</div>'; 
            
        }
        if($_GET['error']=='invalidemailanduser')
        {
            $error.="
            אופס המייל ושם המשתמש לא תקינים
            ";
            $errorInvalidMail=true;
            $errorinvalidusername=true;
        }
         if ($_GET['error']=='invalidemail' )
        { 
            $error="
                  נראה שהזנת מייל לא תקין, אנא נסה שנית 
            ";
            $errorInvalidMail=true;

              echo '
            <div class="alert alert-danger" role="alert" style="text-align:right;">
            '.$error.'
</div>'; 
            
        }
        
         if ($_GET['error']=='useralreadytaken' )
        { 
            $error="
          אופס נראה כי כבר שם משתמש או מייל תפוסים
            ";
           // $errorInvalidMail=true;

              echo '
            <div class="alert alert-danger" role="alert" style="text-align:right;">
            '.$error.'
</div>'; 
            
        }
         if ($_GET['error']=='invalidusername')
        {
            $error="
          אופס, נראה כי שם המשתמש אינו תקין
            ";
            $errorinvalidusername=true;
            echo '
            <div class="alert alert-danger" role="alert" style="text-align:right;">
            '.$error.'
</div>'; 
        }
        
         if ($_GET['error']=='passwordlength')
        {
            $error="
          אופס נראה כי הססמא לא תקינה
            ";
            $errorpasswordlength=true;
            echo '
            <div class="alert alert-danger" role="alert" style="text-align:right;">
            '.$error.'
</div>'; 
        }
         if ($_GET['error']=='passwordCheck')
        {
            $error="
          אופס, נראה כי הסיסמאות לא תואמות
            ";
            //$errorpasswordChecke=true;
            echo '
            <div class="alert alert-danger" role="alert" style="text-align:right;">
            '.$error.'
</div>'; 
        }
    }
    

  if($errorinvalidusername==true)
  {
      echo '
      <small class="text-danger" style="padding-top:2px;"> 
      על שם המשתמש להכיל אותיות ו/או מספרים בלבד
      </small>';
  }

   
  if($errorInvalidMail==true)
  {
      echo '
      <small class="text-danger" style="padding-top:2px;"> 
       me@example.com
      
כתובת מייל תקינה עשויה להיות, לדוגמא     
      </small>';
  }
    
 
     if($errorpasswordlength==true)
  {
      echo '
      <small class="text-danger" style="padding-top:-2px;"> 
    על הססמא להכיל בין 8-12 תווים
      </small>';
  }*/
  ?>

