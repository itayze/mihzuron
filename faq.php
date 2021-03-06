<?php
require_once('config.php');

session_start();
if(!isset($_SESSION['userName']))
{
header("Location:login.php");
    exit();
}
 $sql="SELECT * FROM users WHERE userName=?";
       $stmt=mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql))
        {
             header('location: login.php?error=sqlerror');
       exit();
            
        }
        else
        {
            
            mysqli_stmt_bind_param($stmt,"s",$_SESSION['userName']);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            
            if($row=mysqli_fetch_assoc($result))
            {
                $userName= $row['userName'];
                $email=$row['email'];
                $path=$row['profilePic'];
            }
       } 
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo2.jpg">
    <title>שאלות ותשובות</title>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script>
		     var userName=localStorage.getItem("user");
		</script>
		<style>
.accordion {
  background-color: #00BF6F;
  color: white;
  cursor: pointer;
  padding: 10px;
  width: 100%;
  border: solid 1px white;
  margin:2px;
  border-radius:8px;
  text-align: right;
  outline: none;
  font-size: 16px;
  transition: 0.4s;
opacity:0.7;
  
}

.active2, .accordion:hover {
  background-color: #55CE63;
}

.accordion:after {
  content: '\002B';
  color: #777;
  font-weight: bold;
  float: right;
  margin-left: 5px;
}

.active2:after {
  content: "\2212";
}

.panel {
  padding: 0 18px;
  background-color: white;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
  background: transparent;
}
</style>
</head>

<body>
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                <a href="index.php" class="logo">
                    <img src="assets/img/logo2.jpg" width="60" height="50" alt="">
                </a>
            </div>
            <div class="page-title-box pull-left">
                <span id="updateNumOfNotifications"></span>
                <h3 >מיחזורון</h3>
            </div>
            <a id="mobile_btn" class="mobile_btn pull-left" href="#sidebar"><i class="fa fa-bars" aria-hidden="true"></i></a>
            <ul class="nav user-menu pull-right">
                <li class="nav-item dropdown d-none d-sm-block">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" id="notificationButton"><i class="fa fa-bell-o"></i> <span class="badge badge-pill bg-primary pull-right" id="numOfNotifications"></span></a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span>התראות</span>
                        </div>
                        <div class="drop-scroll">
                            <ul class="notification-list" id="notificationList">
                                
                              
                
                               
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="notificationList.php">הצג הכל</a>
                        </div>
                    </div>
                </li>
                
                 <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <span class="user-img">
							<img class="rounded-circle" src=
							      <?php
                                    if($path !=NULL)
                                    {
                                        echo "$path";
                                    }
                                    else
                                    {
                                        echo  "assets/img/user.jpg" ;
                                    }
                                    ?> 
                        width="40" alt= ""><span id="name"></span>
                         
							<span class="status online"></span></span>
						</span>
						<span><?php
          echo $userName;
          ?></span>
					
                    </a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="profile.php">הפרופיל שלי</a>
						<a class="dropdown-item" href="edit-profile.php">ערוך פרופיל</a>
					
						<a class="dropdown-item" href="login.php">התנתק</a>
					</div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu pull-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.php">הפרופיל שלי</a>
                    <a class="dropdown-item" href="edit-profile.php">ערוך פרופיל</a>
                 
                    <a class="dropdown-item" href="login.php">התנתק</a>
                </div>
            </div>
        </div>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">
                            ניווט
                        </li>
                        <li>
                            <a href="index.php"><i class="fas fa-home"></i> דף הבית</a>
                        </li>
                        <li>
                            <a href="feed.php"><i class="fa fa-recycle" aria-hidden="true"></i><b>פיד </b></a>
                        </li>
                        <li>
                             <a href="myPosts.php"><i class="fas fa-comment-dollar"></i>
                             מיחזורים שפרסמתי
                             </a>
                        </li>
                        <li>
                             <a href="paidRec.php"><i class="fas fa-file-invoice-dollar"></i>
                                מחזורים שקניתי
                             </a>
                        </li>
                        <li>
                             <a href="profile.php"><i class="fas fa-user"></i>
                            הפרופיל שלי            
                             </a>
                        </li>
                         <li>
                             <a href="help.php"><i class="fa fa-info"></i>
                            עזרה            
                             </a>
                        </li>
                        <li class="active" >
                             <a href="faq.php"> <i class="far fa-question-circle"></i>
                           שאלות ותשובות           
                             </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
<button class="accordion">
מה זה בעצם מיחזורון?
</button>
<div class="panel">
  <p>
  מיחזורון היא פלטפורמה טכנולוגית חדשנית המחברת בין משקי בית לבין ממחזרי בקבוקים שרוצים להרוויח, ליצור לעצמם הכנסה נוספת.
  מצד אחד, משקי בית יוכלו למחזר את הבקבוקים שברשותם מבלי לצאת מהבית
  ומצד שני, מישהו יוכל לאסוף את הבקבוקים ולהרוויח כסף על כך.
  שווי המיחזור יתחלק לשניים כאשר כל אחד מהצדדים יקבל חצי משווי המיחזור.
  לדוגמא: נקח את משפחת ישראלי שעקב אילוצי זמן נוהגת להשליך את בקבוקי המיחזור לפח
  ונקח לדוגמא את נדב, חייל שחוזר הביתה לסופ"ש ומעוניין בהכנסה נוספת.
  נדב נכנס למיחזורון, ורואה את הפרסום של משפחת ישראלי המתגורת סמוך אליו.
  נדב קונה את המיחזור, אוסף את הבקבוקים ממשפחת ישראלי.ומעביר להם מחצית משווי הבקבוקים.
  בסופו של דבר,
  משפחת ישראלי ביצעה מיחזור מבלי לצאת מהבית וקיבלה גמול כספי בעבור הבקבוקים שהיו נזרקים לפח
  ונדב, מיחזר וקיבל גמול כלכלי עבור איסוף הבקבוקים מבית משפחת ישראלי ומיחזורם
  </p>
</div>

<button class="accordion">איך מיחזורון עוזרת לי אם יש לי בקבוקים בבית ואני רוצה לקבל עבורם תשלום?</button>
<div class="panel">
  <p>
      תוכל להעלות את המיחזור שברשותך למיחזורון- ולחשוף אותו לקהל המשתמשים בפלטפורמה.
      באם ירצה בכך, אחד ממשתמשי המערכת יקנה את המיחזור שלך, יאסוף ממך את הבקבוקים ואתה תקבל כמחצית משווי הבקבוקים.
      לדוגמא: במידה ובביתך בקבוקים בשווי 50 שקלים- תוכל למחזר ולקבל כ25 ש"ח מבלי לצאת מהבית.
  </p>
</div>

<button class="accordion">
איך מיחזורון עוזרת לי אם אני מעוניין להרוויח כסף על ידי איסוף בקבוקים ממשתמשים שגרים בסביבה שלי?
</button>
<div class="panel">
  <p>
תוכל לחפש מיחזורים (פרסום של בקבוקים שמשתמשים אחרים העלו למערכת)
הנמצאים באזור מגוריך ולקנות את המיחזור
לאחר שרכשת את המיחזור, תוכל ליצור קשר עם המפרסם ולאסוף ממנו את הבקבוקים.
בנוסף על התרומה לכדור הארץ, תוכל להרוויח כמחצית משווי הבקבוקים של המיחזור שקנית.
לדוגמא: 
קנית מיחזור שהועלה מוקדם יותר באותו היום על ידי משתמש שגר רחוב אחד לידך
נניח ששווי הבקבוקים במיחזור שקנית הוא 50 שקלים
במידה ותקנה את המיחזור ותאסוף את הבקבוקים-תקבל גמול כספי כמחצית משווי המיחזור.
בעת האיסוף, עליך להעביר לבעל המיחזור כמחצית משווי המיחזור 
את החלק שלך תרוויח כאשר תמחזר את הבקבוקים :)

  </p>
</div>
<button class="accordion">
כמה עולה השימוש במיחזורון?
</button>
<div class="panel">
  <p>
      ניתן לפרסם עד אלף בקבוקים בחינם. לאחר סיום המכסה החינמית- תתבקש לרכוש אחת מהחבילות שלנו.
 <br>
      חבילת אלף בקבוקים נוספים לפרסום- 10 ₪
      <br>
      חבילת 3000 בקבוקים נוספים לפרסום- 15 ₪
            <br>

      חבילת 5000 בקבוקים נוספים לפרסום- 18 ₪
      <br>
קניית מיחזור-המחיר קבוע לקניה של כל מיחזור בודד.
המחיר הוא 1  ₪
לאחר הקניה תקבל את פרטי הקשר של בעל המיחזור ותוכל לבצע את המיחזור
            </p>
</div>
<button class="accordion">
 ?איך אוכל למחזר בקבוקים מבלי לצאת מהבית
</button>
<div class="panel">
  <p>
תוכל לפרסם פוסט, ולאחר שמשתמש אחר יקנה את המיחזור שהעלית- הוא יגיע לאסוף את הבקבוקים ויעביר לך את החלק שלך במיחזור.
כך שמלבד תרומה לכדור הארץ, תוכל להרוויח כמחצית משווי מיחזור הבקבוקים שלך.
      </p>
</div>
<button class="accordion">
איך אני מפרסם את הבקבוקים שנמצאים ברשותי? 
</button>
<div class="panel">
  <p>
כדי לפרסם את הבקבוקים כנס לדף "פיד" ולאחר מכן לחץ על "צור פוסט חדש" 
בדף יצירת הפוסט תתבקש למלא כמה בקבוקים יש לך מכל סוג
לאחר לחיצה על "הוסף לרשימת המיחזור"
הפוסט החדש שלך יהיה באוויר ומשתמשים יוכלו לרכוש אותו.
      </p>
</div>
<button class="accordion">
איך אני צופה בפרסומים של משתמשים אחרים אשר מתגוררים באיזור המגורים שלי?
</button>
<div class="panel">
  <p>
על מנת לצפות בפרסומים של משתמשים שגרים בסביבך המגורים שלך, היכנס לדף "פיד" ולחץ על "בעיר שלי" מצד ימין.
<br>
המערכת תציג לך את המיחזורים שנמצאים בסביבת המגורים שלך לנוחיותך
      </p>
</div>
<button class="accordion">
איך אני צופה בפוסטים אשר נמצאים בעיר שבה אני נוכח באותו זמן?
</button>
<div class="panel">
  <p>
בכל העמודים של "פיד" יש למעלה סרגל חיפוש ובו ניתן לחפש את העיר שבה אתה נוכח כרגע.
<br>
לאחר לחיצה על חפש תופיע רשימת פוסטים ששייכים לעיר הרצויה.
      </p>
</div>
<button class="accordion">
למה חשוב למחזר ולשמור על כדור הארץ?
</button>
<div class="panel">
  <p>
כדור הארץ הוא מקום המגורים שלנו. ויש לנו רק אחד ממנו.
אם אנחנו לא נשמור עליו ונטפח אותו במידת האפשר, איך נוכל להמשיך להנות ממנו?
      </p>
</div>
<button class="accordion">
איך אוכל לקבל בונוס של בקבוקים למיחזור?
</button>
<div class="panel">
  <p>
לאחר שפירסמת מיחזור ובוצע איסוף הבקבוקים, בקש את קוד בן ה-4 ספרות מהמשתמש אשר אסף ממך את הבקבוקים
<br>
הזן את הקוד בעמוד המיחזורים שלי בשורת המיחזור המתאימה ותקבל בונוס בקבוקים לפרסום בשווי 10% מהבקבוקים באותו המיחזור
 <br>
 לדוגמא: במיחזור היו 100 בקבוקים, והזנת את הקוד בן 4 הספרות
 תקבל בונוס של 10 בקבוקים נוספים למיחזור בחינם.
 
      </p>
</div>
<button class="accordion">
בשביל מה אני זקוק לקוד בן ה-4 ספרות?
</button>
<div class="panel">
  <p>
על מנת לקבל בונוס של בקבוקים נוספים למיחזור, עליך להזין את הקוד בן 4 הספרות בעמוד "המיחזורים שלי"
<br>
לדוגמא: במיחזור היו 100 בקבוקים והזנת את הקוד בן 4 הספרות
 תקבל בונוס של 10 בקבוקים נוספים למיחזור בחינם.
 
      </p>
</div>
<button class="accordion">
אם הייתי חלק ממירמה או בכללי רוצה ליצור קשר עם בעלי מיחזורון, כיצד אוכל לעשות זאת?
</button>
<div class="panel">
  <p>

אתם תמיד מוזמנים ליצור איתנו קשר עם המייל הבא
<br>
<a href="mailto:eavnitayze@gmail.com">eavnitayze@gmail.com</a>
      </p>
</div>




<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active2");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
</script>
                </div>
               </div>
            </div>
         
        </div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    <script type="text/javascript" src="assets/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="assets/js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.slimscroll.js"></script>
    <script type="text/javascript" src="assets/js/app.js"></script>
     <script>
      var userName=localStorage.getItem("user");

    </script>
    <script>
        var userName='<?php echo $_SESSION['userName']; ?>';

         $(document).ready(function(){



        setInterval(function()
{ 

   $("#numOfNotifications").load("http://eavni93.com/itay/notifications.php", {
        action:"countNotifications",
       userName:userName
       
        
    });
    
      $("#notificationList").load("http://eavni93.com/itay/notifications.php", {
                userName:userName,
               action:"showNotifications"



        
    });



},2000);

//clear notifications after user clicked

$("#notificationButton").click(function(){
    
    
 $("#updateNumOfNotifications").load("http://eavni93.com/itay/notifications.php", {
                userName:userName,
               action:"clearNotifications"
    
});



});
         });
    
        
    </script>
</body>

</html>