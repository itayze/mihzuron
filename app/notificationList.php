<?php
header("Access-Control-Allow-Origin: *");
require_once('config.php');

$userName=$_POST['userName'];




$sql="SELECT * FROM users WHERE userName=?";
       $stmt=mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql))
        {
            
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
            }
          
       }
       
       
       
       
       
       



                                   
                                    
                               $sql="SELECT * from notifications where owner='".$userName."' ORDER BY id DESC LIMIT 20";
                                 $result=$conn-> query($sql);
                                                       if($result->num_rows>0)
                                                       {
                                                           
                                                           while($row=$result->fetch_assoc())
                                                           {
                                                               
                                                               //let's differentiate between different sorts of notification
                                                               
                                                               if($row['sort']==1) //1=someone bought my Mihzur
                                                               {
                                                                    $sql="SELECT * from users where userName='".$row['user_involved']."'";
                                                                   $result2=$conn-> query($sql);
                                                       if($result2->num_rows>0)
                                                       {
                                                         $row2=$result2->fetch_assoc();
                                                         $pathOfInvolved=$row2['profilePic'];
                                                       }  
                                                        
                                                                   
                                                                   //new
                                                                    echo '
                                                                    <li>
                                        <div class="activity-user">
                                            <a href="" title="" data-toggle="tooltip" class="avatar">';
                                                
                                               if($row2['profilePic']!=null)
                                                                {
                                                                    echo '
                                                                     <img src="http://eavni93.com/itay/'.$row2['profilePic'].'"
                                                                alt="" class="w-40 rounded-circle"><span class="status online">
                                                                    ';
                                                                }
                                                                else
                                                                {
                                                                    echo ' 
                                                                    <img src="http://eavni93.com/app/assets/img/user.jpg"
                                                                alt="" class="w-40 rounded-circle"><span class="status online">
                                                                    ';
                                                                }echo'
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                                <a href="" class="name">'.$row['user_involved'].'</a> 
                                            קנה את המיחזור שלך, 
                                            היכנס עכשיו ל
												<a href="http://eavni93.com/itay/myPosts.html">
												מיחזורים שלי
                                        
                                         
                                                <span class="time">'.$row['fullDate'].'</span>
                                            </div>
                                        </div>
                                    </li> ';
                                                                   
                                                                   
                                                                   
                                                               }
                                                               else if($row['sort']==2) //i bought someone else's Mihzur
                                                               {
                                                                
                                                                $sql="SELECT * from users where userName='".$row['user_involved']."'";
                                                                   $result2=$conn-> query($sql);
                                                       if($result2->num_rows>0)
                                                       {
                                                         $row2=$result2->fetch_assoc();
                                                         $pathOfInvolved=$row2['profilePic'];
                                                       }  
                                                                      
                                                               
                                     echo '
                                                                    <li>
                                        <div class="activity-user">
                                            <a href="" title="" data-toggle="tooltip" class="avatar">';
                                                if($row2['profilePic']!=null)
                                                                {
                                                                    echo '
                                                                     <img src="http://eavni93.com/itay/'.$row2['profilePic'].'"
                                                                alt="" class="w-40 rounded-circle"><span class="status online">
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
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                                <a href="" class="name">'.$row['owner'].'</a> 
	קנית את המיחזור של
'.$row['user_involved'].'
	היכנס עכשיו ל
												<a href="paidRec.html">
											מחזורים שקניתי
												</a>
                                        
                                         
                                                <span class="time">'.$row['fullDate'].'</span>
                                            </div>
                                        </div>
                                    </li> ';
                                                                   
                                                                   
                                                               }
                                                               else if ($row['sort']==4)//someome else has aprroved his Mihzur from me
                                                               {
                                                                   $sql="SELECT * from users where userName='".$row['user_involved']."'";
                                                                   $result2=$conn-> query($sql);
                                                       if($result2->num_rows>0)
                                                       {
                                                         $row2=$result2->fetch_assoc();
                                                         $pathOfInvolved=$row2['profilePic'];
                                                       }   
                                                                    
                                                                    
                                            
                                       
                                     echo '
                                                                    <li>
                                        <div class="activity-user">
                                            <a href="" title="" data-toggle="tooltip" class="avatar">';
                                                if($row2['profilePic']!=null)
                                                                {
                                                                    echo '
                                                                     <img src="http://eavni93.com/itay/'.$row2['profilePic'].'"
                                                                alt="" class="w-40 rounded-circle"><span class="status online">
                                                                    ';
                                                                }
                                                                else
                                                                {
                                                                    echo ' 
                                                                    <img src="http://eavni93.com/app/assets/img/user.jpg"
                                                                alt="" class="w-40 rounded-circle"><span class="status online">
                                                                    ';
                                                                }

                                                
                                                echo ' 
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                                <a href="" class="name">'.$row['user_involved'].'</a> 
	

													אישר את המיחזור
                                        
                                         
                                                <span class="time">'.$row['fullDate'].'</span>
                                            </div>
                                        </div>
                                    </li> ';                                                       
                                                                   
                                                                   
                                                               }
                                                                   else if ($row['sort']==3)//i approved someone else's Mihzur   not working (eliran) check in yaniv
                                                               {
                                                                   $sql="SELECT * from users where userName='".$row['user_involved']."'";
                                                                   $result2=$conn-> query($sql);
                                                       if($result2->num_rows>0)
                                                       {
                                                         $row2=$result2->fetch_assoc();
                                                         $pathOfInvolved=$row2['profilePic'];
                                                       }  
                                                                   
             echo '
                                                                    <li>
                                        <div class="activity-user">
                                            <a href="" title="" data-toggle="tooltip" class="avatar">';
                                               if($row2['profilePic']!=null)
                                                                {
                                                                    echo '
                                                                     <img src="http://eavni93.com/itay/'.$row2['profilePic'].'"
                                                                alt="" class="w-40 rounded-circle"><span class="status online">
                                                                    ';
                                                                }
                                                                else
                                                                {
                                                                    echo ' 
                                                                    <img src="http://eavni93.com/app/assets/img/user.jpg"
                                                                alt="" class="w-40 rounded-circle"><span class="status online">
                                                                    ';
                                                                }

                                                
                                                echo ' 
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                                <a href="" class="name">'.$row['owner'].'</a> 
    אישרת את המיחזור מול	
	'.$row['user_involved'].'

										היכנס עכשיו ל		
												<a href="myPosts.html">
												מיחזורים שלי
											</a>
                                        
                                         
                                                <span class="time">'.$row['fullDate'].'</span>
                                            </div>
                                        </div>
                                    </li> ';                                                   
                                                                   
                                                               }
                                                               else if($row['sort']==5)//i just uploaded a new Mihzur
                                                               {
                                                                  
                                                               //new
                                                                   echo '
                                                                    <li>
                                        <div class="activity-user">
                                            <a href="" title="" data-toggle="tooltip" class="avatar">';
                                               if($row['profilePic']!=null)
                                                                {
                                                                    echo '
                                                                     <img src="http://eavni93.com/itay/'.$row['profilePic'].'"
                                                                alt="" class="w-40 rounded-circle"><span class="status online">
                                                                    ';
                                                                }
                                                                else
                                                                {
                                                                    echo ' 
                                                                    <img src="http://eavni93.com/app/assets/img/user.jpg"
                                                                alt="" class="w-40 rounded-circle"><span class="status online">
                                                                    ';
                                                                }

                                                
                                                echo ' 
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                                <a href="" class="name">'.$row['owner'].'</a> 
	הוספת מיחזור חדש!
	היכנס עכשיו ל
												<a href="myPosts.html">
												מיחזורים שלי
                                        
                                         
                                                <span class="time">'.$row['fullDate'].'</span>
                                            </div>
                                        </div>
                                    </li> ';
                                                               
                                                               
                                                                   
                                                               }
                                                               
                                                               
                                                               
                                                              
                                                               
                                                               
                                                               
                                                           }
                                                       }
                                    
                                    ?>
                                    
                              

