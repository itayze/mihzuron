<?php
header("Access-Control-Allow-Origin: *");
require_once('config.php');

/*use PHPMailer\PHPMailer;
               use PHPMailer\Exception;
               require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail=new PHPMailer\PHPMailer();

$mail->IsSMTP();
$mail->CharSet="UTF-8";
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->Username = 'eavnitayze@gmail.com';
$mail->Password = 'jePuc-*qO9';
$mail->SMTPAuth = true;
$mail->SMTPKeepAlive = true;   
$mail->Mailer = “smtp”; // don't change the quotes!

$mail->From = 'support@recycle.co.il';
$mail->FromName = 'מחזורון';
$mail->AddAddress('eavni93@gmail.com');
$mail->AddReplyTo('support@recycle.co.il', '');

$mail->IsHTML(true);
$mail->Subject    ="reset your password";
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
$mail->Body    ='
'.$_POST['name'].'
';

if(!$mail->Send())
{
  echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
  echo "Message sent!";
}
$user=$_POST['name'];
echo $_POST['name'];

echo json_encode($user);*/

$name=$_POST['name'];
$pass=$_POST['password'];

if(empty($name) || empty($pass))
    {
        echo json_encode('emptyfields');
        exit();
        
    }
    else
    {
        $sql="SELECT * FROM users WHERE userName=? OR email=?;";
        $stmt= mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
             echo json_encode('sqlerror');
             
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
                     echo json_encode('wrongpassword');
                     
                       exit();
                    
                }
                else if($pwdCheck==true)
                {
                    session_start();
                    $_SESSION['userName']=$row['userName'];
                    $_SESSION['userEmail']=$row['email'];
                  $login=array('login' => 'success', 'userName' => $row['userName']);
                echo json_encode($login);

                    
                }
                else
                {
                    echo json_encode('wrongpassword');
                    
                     exit();
                    
                }
            }
            else
            {
                 echo json_encode('nouser');
                 
       exit();
                
            }
            
        }
        
        
    }


?>
