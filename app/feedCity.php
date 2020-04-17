<?php
header("Access-Control-Allow-Origin: *");
require_once('config.php');




$newFeedCount=$_POST['newFeedCount'];
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
                $city=$row['city'];
            }
          
       }
if($newFeedCount<=10)
{
    $newFeedCount=10;
}
  $sql="SELECT * from posts WHERE city='$city' AND paid=0 AND isDeleted='0'  ORDER BY id DESC LIMIT $newFeedCount";
 //  WHERE city='".$city."' AND paid=0 AND isDeleted='0'  ORDER BY id DESC LIMIT '".$newFeedCount."'";
                                                        $result=$conn-> query($sql);
                                                       if($result->num_rows>0)
                                                       {
                                                           $i=1;
                                                           while($row=$result->fetch_assoc())
                                                           {
                                                               echo '
                                                              <li>

                                                                <div class="contact-cont">
                                                            <div class="pull-left user-img m-r-10">
                                                               <a href="profile.html" title="">';
                                                                if($row['profilePic']!=null)
                                                                {
                                                                    echo '
                                                                     <img src="'.$row['profilePic'].'"
                                                                alt="" class="w-40 rounded-circle"><span class="status online"></span></a>
                                                                    ';
                                                                }
                                                                else
                                                                {
                                                                    echo ' 
                                                                    <img src="http://eavni93.com/app/assets/img/user.jpg"
                                                                alt="" class="w-40 rounded-circle"><span class="status online"></span></a>
                                                                    ';
                                                                }
                                                               echo '
                                                            </div>
                                                            <div class="contact-info">
                                                                <span class="contact-name text-ellipsis">
                                                                 '  .
                                                                      $row['userName'].'<br>'.getDateDiff($row['date']) 
                                                                    
                                                                   .'
                                                                </span>
                                                                <span class="contact-date">
                                                                 עיר:   
                                                             <strong>
                                                             '.  
                                                             $row['city'].'</strong>.'
                                                             .' '.
                                                            ' רחוב: '.
                                                             '<strong>'
                                                             . $row['street'].'</strong>'.
                                                             '
                                                                    
                                                                </span><br>
                                                                 <span class="contact-date">
                                                                 
                                                                שווי
                                                               
                                                                <strong>
                                                                 '.
                                                                 $row['revenue'].' ₪</strong>
                                                                 </span>
                                                                  <span class="contact-date">
                                                                  רווח צפוי:
                                                                  <strong>
                                                                  '.$row['revenue']/2 .' ₪</strong>
                                                                  </span>

                                                                  ';
                                                                   if($row['userName']!=$userName)
                                                                        {
                                                                             echo '
                                                                     <span class="contact-action">
<br><br>
<br>
                                                                           <form action="post.html">
                                                                           <input type="hidden" name="postId" value='.$row['id'].'>
                                                                           
                                                                              <button  style="position: relative; float:left; display:inline; border-radius:4px; padding:4px;" class="btn btn-primary" type="submit" id="pay">שלם
                                                                                <i class="fas fa-wine-bottle"></i>
                                                                                    
                                                                            </button></form> </span>
                                                                            ';
                                                                        }
                                                                  
                                                          echo'  </div>';
                                                            if($row['userName']==$userName)
                                                            {
                                                              echo '
                                                              <ul class="contact-action">
                                                                <li class="dropdown dropdown-action">
                                                                    <a href="" class="dropdown-toggle action-icon" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right" style="text-align:right;">
                                                                        <a class="dropdown-item" href="edit-post.html?update=true&id='.$row['id'].'" >ערוך</a>
                                                                        <a class="dropdown-item" href="myPosts.html?delete2=true&id='.$row['id'].'" >מחק</a>
                                                                        
                                                                        
                                                                    </div>
                                                                    
                                                                </li>
                                                            </ul>
                                                              
                                                              
                                                              
                                                              
                                                              '   ;
                                                            }
                                                           
                                                            echo ' <br>
                                                        </div> ';
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
      }