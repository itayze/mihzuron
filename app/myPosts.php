<?php
header("Access-Control-Allow-Origin: *");

require_once('config.php');


$userName=$_POST['userName'];




$sql="SELECT * FROM users WHERE userName=?";
       $stmt=mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql))
        {
             header('location: login.php?error=sqlerror');
       exit();
            
        }
        else
        {
            
            mysqli_stmt_bind_param($stmt,"s",$userName);
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
       
      if($_POST['delete2']=="true")
           {
                $sql="SELECT * FROM posts WHERE id='".$_POST['id']."'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) == 0) {
           
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
        $sql="UPDATE users SET amountBot='".$amountBot."' WHERE userName='".$userName."'";
        if ($conn->query($sql) == TRUE) {
                
                 } else {
                
                    }
               
               $sql="UPDATE posts SET isDeleted=1 WHERE userName='".$userName."' AND id='".$_POST['id']."'";
               if ($conn->query($sql) == TRUE) {
                echo' 
                <script>
                window.location="myPosts.html";
                </script>
                ';
                 } else {
                echo "Error deleting record: " . $conn->error;
                    }
            
                 $conn->close();
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


                                                        
                                                        $sql="SELECT * from posts WHERE userName='".$userName."' AND isDeleted='0' ORDER BY id LIMIT 250";
                                                       $result=$conn-> query($sql);
                                                       if($result->num_rows>0)
                                                       {
                                                           $i=1;
                                                           
                                                             while($row=$result->fetch_assoc())
                                                           {
                                                               echo '
                                                              <tr>
                                                              <td class="narrowInMobile">'.$row['id'].'
                                                              </td>
                                                              <td>

                                                                <div class="contact-cont">
                                                            <div class="pull-left user-img m-r-10">
                                                                <a href="profile.html" title=""><img src=
                                                                '.$row['profilePic'].'
                                                                alt="" class="w-40 rounded-circle"><span class="status online"></span></a>
                                                            </div>
                                                            <div class="contact-info narrowInMobile">
                                                                <span class="contact-date">
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
                                                                  $sql="SELECT * from users WHERE userName='".$row['paidUser']."'";
                                                       $result2=$conn-> query($sql);
                                                       if($result2->num_rows>0)
                                                       {
                        
                                                             $row2=$result2->fetch_assoc();
                                                                echo " <span class='contact-date'>
                                                                שם הקונה: 
                                                                </span><br>". $row2["userName"]. "
                                                                <br>
                                                                <span class='contact-date'>
                                                                 טלפון:</span><br> ". $row2["tel"]. " "  . "<br>";
                                                                                    
                                                                                } else {
                                                                                    echo "000 results";
                                                                                }
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
                                                               echo' <a href="edit-post.html?update=true&id='.$row['id'].'" class="btn btn-white btn-sm m-t-10">
                                                              ערוך מיחזור
                                                               </a><br>
                                                               
                                                              
                                                                   <a href="myPosts.html?delete2=true&id='.$row['id'].'" class="btn btn-white btn-sm m-t-10" >
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
                                                              <form action="finish-deal.html" >
                                                               <div class="form-group row form-focus">
                                                               <input type="hidden" value="'.$row['id'].'" name="id">
                                                               <input type="hidden" value="'.$row['userName'].'" name="userName">
                                                              <div class="col-xs-2">
                                                              
                                                               <input class=" input-sm" type="text" style="width:80px;height:40px;" name="fourCode" id="fourCode" 
                                                               placeholder="קוד 4 ספרות">
                                                               </div>
                                                               <button class="btn btn-primary btn-sm" type="submit" style="height:40px" >
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
                                                           
                                                           
<!DOCTYPE HTML>
<html>
    <head>
       <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
 <style>
     
     @media only screen and (max-width: 600px) {
  .narrowInMobile {
      padding:0px;
  }
  
}
 </style>
    </head>
    <body>
       <script type="text/javascript" src="assets/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="assets/js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.slimscroll.js"></script>
    <script type="text/javascript" src="assets/js/app.js"></script>
    </body>
</html>
                                        