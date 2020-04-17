<?php
require_once('config.php');

session_start();
if(!isset($_SESSION['userName']))
{
header("Location:login.php");
    exit();
}
$userName=$_SESSION['userName'];



  $newFeedCount=$_POST['newFeedCount'];
  $sql="SELECT * from posts WHERE paid=0 AND isDeleted='0' ORDER BY id DESC LIMIT $newFeedCount";
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
                                                                <a href="" title=""><img src=
                                                                '.$row['profilePic'].'
                                                                alt="" class="w-40 rounded-circle"><span class="status online"></span></a>
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
                                                                 $row['revenue'].'</strong>
                                                                 </span>
                                                                  <span class="contact-date">
                                                                  רווח צפוי:
                                                                  <strong>
                                                                  '.$row['revenue']/2 .'</strong>
                                                                  </span>

                                                                  ';
                                                                   if($row['userName']!=$userName)
                                                                        {
                                                                              echo '
                                                                     <span class="contact-date">

                                                                           <form method="post" action="post.php">
                                                                           <input type="hidden" name="postId" value='.$row['id'].'>
                                                                              <button  style="position: relative;float:left; bottom:30px;display:inline;" class="btn btn-primary" type="submit" name="pay" id="pay">שלם
                                                                                <i class="fas fa-wine-bottle"></i>
                                                                                    
                                                                            </button> </span>
                                                                            </form>
                                                                            ';
                                                                        }
                                                                  
                                                          echo'  </div>';
                                                            if($row['userName']==$userName)
                                                            {
                                                              echo '
                                                              <ul class="contact-action">
                                                                <li class="dropdown dropdown-action">
                                                                    <a href="" class="dropdown-toggle action-icon" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" href="myPosts.php">ערוך\מחק</a>
                                                                        
                                                                        
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
    ?>
            