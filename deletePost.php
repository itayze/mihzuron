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
                window.location="http://eavni93.com/app/myPosts.html";
                </script>
                ';
                 } else {
                echo "Error deleting record: " . $conn->error;
                    }
            
                 $conn->close();
           }
           
           