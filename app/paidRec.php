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






 





            

  
                                                        $sql="SELECT * from posts WHERE paidUser='".$userName."' ORDER BY id LIMIT 250";
                                                       $result=$conn-> query($sql);
                                                       if($result->num_rows>0)
                                                       {
                                                           $i=1;
                                                             while($row=$result->fetch_assoc())
                                                           {
                                                               echo '
                                                              <tr style="padding:0;">
                                                              <td style="padding:0;">'.$row['id'].'
                                                              </td>
                                                              <td>

                                                                <div class="contact-cont">
                                                            <div class="pull-left user-img m-r-10">
                                                             <a href="profile.html" title="">';
                                                                if($row['profilePic']!=null)
                                                                {
                                                                    echo '
                                                                     <img src="http://eavni93.com/itay/'.$row['profilePic'].'"
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
                                                            <div class="contact-info" style="padding:0;">
                                                                
                                                                <span class="contact-date">
                                                                 '  
                                                                 .$row['userName'].'<br>'   .getDateDiff($row['date']).'
                                                                    
                                                                   </span>
                                                                
                                                               
                                                                 <span class="contact-date">
                                                                שווי
                                                               </span>
                                                                <span class="contact-name text-ellipsis">
                                                                <strong>
                                                                 ₪'.
                                                                 $row['revenue'].'</strong>
                                                                 </span>
                                                                  <span class="contact-date">
                                                                  רווח צפוי:
                                                                  </span>
                                                                   <span class="contact-name text-ellipsis">
                                                                  <strong>
                                                                  ₪'.$row['revenue']/2 .'</strong> </span>
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
                                                                   </script><br>
                                                                   <br>
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
<!DOCTYPE HTML>
<html>
    <head>
       <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
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
       <script type="text/javascript" src="assets/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="assets/js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.slimscroll.js"></script>
    <script type="text/javascript" src="assets/js/app.js"></script>
    
    </body>
</html>