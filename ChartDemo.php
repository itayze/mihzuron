<?php
require_once('config.php');

session_start();
if(!isset($_SESSION['userName']))
{
header("Location:login.php");
    exit();
}



       $m=date('n');
       $m1=date('n')-1;
       $m2=date('n')-2;
       $m3=date('n')-3;
       
       
       
                $resm=getMonthRev($m,$conn);
       $resm1=getMonthRev($m1,$conn);
       $resm2=getMonthRev($m2,$conn);
       $resm3=getMonthRev($m3,$conn);

       
     function getMonthRev($mo,$conn){
         

         $sum=0;
      $sql="SELECT * from posts WHERE userName=
       '".$_SESSION['userName']."'AND MONTH(date)='".$mo."' OR paidUser='".$_SESSION['userName']."'AND MONTH(date)='".$mo."'";
         $result=$conn-> query($sql);
        if($result->num_rows>0)
        {
         $timestamp = strtotime($row['date']);   
         $month = date('F', $timestamp);
        
         
        while($row=$result->fetch_assoc())
          {
             $timestamp = strtotime($row['date']);   
         $month = date('F', $timestamp);
       
            if($row['paid']==1)
           
            
             {
            $sum+=$row['revenue'];
                                                             
             }
                                    
            }
             $sum=$sum/2;//TO EDIT 
            }
              
            return $sum;
          
     }
     

    
?>


<!DOCTYPE HTML>
<html>
<head>  
<meta charset="utf-8">
<script type="text/javascript">
 
  window.onload = function () {
    
     var month=<?php echo date('n')-1; ?>;
    
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
      	text: "רווחים על פי חודשים"
      },
     toolTip:{
   contentFormatter: function ( e ) {
               return "" +  e.entries[0].dataPoint.y;  
   }  
 },
       axisX:{ 
    valueFormatString: "MM.YY", 
    intervalType: "month",
    interval: 1
  },
  data: [
    {
      type: "line",
       lineColor:"#55ce63",
       lineThickness: 4,
       lineDashType: "shortDashDotDot",
        markerColor:"green",
         markerSize:15,
      dataPoints: [
        { x: new Date(2019,month-3), y:
      <?php
      echo $resm3;
      ?>
           
        },
        { x: new Date(2019, month-2), y: 
            <?php
      echo $resm2;
      ?>
        },
        { x: new Date(2019, month-1), y:
           <?php
      echo $resm1;
      ?>
        },
        { x: new Date(2019, month), y: 
           <?php
      echo $resm;
      ?>
        },
    
      ]
    }					
  ]
   });

    chart.render();
  }
  </script>
</head>
<body >
 <p></p>  
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>

