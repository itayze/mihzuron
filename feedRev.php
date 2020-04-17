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
   
           
       
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo2.jpg">
    <title>פיד בקבוקים</title>
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
	   $(document).ready(function(){
	       var feedCount=10;
  $("#reload").click(function(){
      feedCount= feedCount+10;
    $("#feed").load("loadFeedRev.php", {
        newFeedCount :feedCount
    });
  });
});
	</script>

</head>

<body>
    <datalist id="dlCities">
<option value="אבו ג'ווייעד )שבט)" /><option value="אבו גוש" /><option value="אבו סנאן" /><option value="אבו סריחאן )שבט)" /><option value="אבו עבדון )שבט)" /><option value="אבו עמאר )שבט)"/><option value="אבו עמרה )שבט)" /><option value="אבו קורינאת )שבט)" /><option value="אבו קרינאת )יישוב)" /><option value="אבו רובייעה )שבט)" /><option value="אבו רוקייק )שבט)" /><option value="אבו תלול" /><option value="אבטין" /><option value="אבטליון" /><option value="אביאל" /><option value="אביבים" /><option value="אביגדור" /><option value="אביחיל" /><option value="אביטל" /><option value="אביעזר" /><option value="אבירים" /><option value="אבן יהודה" /><option value="אבן מנחם" /><option value="אבן ספיר" /><option value="אבן שמואל" /><option value="אבני איתן" /><option value="אבני חפץ" /><option value="אבנת" /><option value="אבשלום" /><option value="אדורה" /><option value="אדירים" /><option value="אדמית" /><option value="אדרת" /><option value="אודים" /><option value="אודם" /><option value="אוהד" /><option value="אום אל-פחם" /><option value="אום אל-קוטוף" /><option value="אום בטין"<option value="אומן" /><option value="אומץ" /><option value="אופקים" /><option value="אור הגנוז" /><option value="אור הנר" /><option value="אור יהודה" /><option value="אור עקיבא" /><option value="אורה" /><option value="אורות" /><option value="אורטל" /><option value="אורים" /><option value="אורנים" /><option value="אורנית" /><option value="אושה" /><option value="אזור" /><option value="אחווה" /><option value="אחוזם" /><option value="אחוזת ברק" /><option value="אחיהוד" /><option value="אחיטוב" /><option value="אחיסמך" /><option value="אחיעזר" /><option value="אטרש )שבט(" /><option value="איבים" /><option value="אייל" /><option value="איילת השחר" /><option value="אילון" /><option value="אילות" /><option value="אילניה" /><option value="אילת" /><option value="אירוס" /><option value="איתמר" /><option value="איתן" /><option value="איתנים" /><option value="אכסאל" /><option value="אל סייד" /><option value="אל-עזי" /><option value="אל-עריאן" /><option value="אל-רום" /><option value="אלומה" /><option value="אלומות" /><option value="אלון הגליל" /><option value="אלון מורה" /><option value="אלון שבות" /><option value="אלוני אבא" /><option value="אלוני הבשן" /><option value="אלוני יצחק" /><option value="אלונים" /><option value="אלי-עד" /><option value="אליאב" /><option value="אליכין" /><option value="אליפז" /><option value="אליפלט" /><option value="אליקים" /><option value="אלישיב" /><option value="אלישמע" /><option value="אלמגור" /><option value="אלמוג" /><option value="אלעד" /><option value="אלעזר" /><option value="אלפי מנשה" /><option value="אלקוש" /><option value="אלקנה" /><option value="אמונים" /><option value="אמירים" /><option value="אמנון" /><option value="אמציה" /><option value="אניעם" /><option value="אסד )שבט)" /><option value="אספר" /><option value="אעבלין" /><option value="אעצם )שבט)" /><option value="אפיניש )שבט)" /><option value="אפיק" /><option value="אפיקים" /><option value="אפק" />
<option value="אפרת" /><option value="ארבל" /><option value="ארגמן" /><option value="ארז" /><option value="אריאל" /><option value="ארסוף" /><option value="אשבול" /><option value="אשבל" /><option value="אשדוד" /><option value="אשדות יעקב  )איחוד)" /><option value="אשדות יעקב  )מאוחד)" /><option value="אשחר" /><option value="אשכולות" /><option value="אשל הנשיא" /><option value="אשלים" /><option value="אשקלון" /><option value="אשרת" /><option value="אשתאול" /><option value="אתגר" /><option value="באקה אל-גרביה" /><option value="באר אורה" /><option value="באר גנים" /><option value="באר טוביה" /><option value="באר יעקב" /><option value="באר מילכה" /><option value="באר שבע" /><option value="בארות יצחק" /><option value="בארותיים" /><option value="בארי" /><option value="בוסתן הגליל" /><option value="בועיינה-נוג'ידאת" /><option value="בוקעאתא" /><option value="בורגתה" /><option value="בחן" /><option value="בטחה" /><option value="ביצרון" /><option value="ביר אל-מכסור" /><option value="ביר הדאג'" /><option value="ביריה" /><option value="בית אורן" /><option value="בית אל" /><option value="בית אלעזרי" /><option value="בית אלפא" /><option value="בית אריה" /><option value="בית ברל" /><option value="בית ג'ן" /><option value="בית גוברין" /><option value="בית גמליאל" /><option value="בית דגן" /><option value="בית הגדי" /><option value="בית הלוי" /><option value="בית הלל" /><option value="בית העמק" /><option value="בית הערבה" /><option value="בית השיטה" /><option value="בית זיד" /><option value="בית זית" /><option value="בית זרע" /><option value="בית חורון" /><option value="בית חירות" /><option value="בית חלקיה" /><option value="בית חנן" /><option value="בית חנניה" /><option value="בית חשמונאי" /><option value="בית יהושע" /><option value="בית יוסף" /><option value="בית ינאי" /><option value="בית יצחק-שער חפר" /><option value="בית לחם הגלילית" /><option value="בית מאיר" /><option value="בית נחמיה" /><option value="בית ניר" /><option value="בית נקופה" /><option value="בית עובד" /><option value="בית עוזיאל" /><option value="בית עזרא" /><option value="בית עריף" /><option value="בית צבי" /><option value="בית קמה" /><option value="בית קשת" /><option value="בית רבן" /><option value="בית רימון" /><option value="בית שאן" /><option value="בית שמש" /><option value="בית שערים" /><option value="בית שקמה" /><option value="ביתן אהרן" /><option value="ביתר עילית" /><option value="בלפוריה" /><option value="בן זכאי" /><option value="בן עמי" /><option value="בן שמן )כפר נוער)" /><option value="בן שמן )מושב)" /><option value="בני ברק" /><option value="בני דקלים" /><option value="בני דרום" /><option value="בני דרור" /><option value="בני יהודה" /><option value="בני נצרים" /><option value="בני עטרות" /><option value='בני עי"ש' /><option value="בני ציון" /><option value="בני ראם" /><option value="בניה" /><option value="בנימינה-גבעת עדה" /><option value='בסמ"ה' /><option value="בסמת טבעון" /><option value="בענה" /><option value="בצרה" /><option value="בצת" /><option value="בקוע" /><option value="בקעות" /><option value="בר גיורא" /><option value="בר יוחאי" /><option value="ברוכין" /><option value="ברור חיל" /><option value="ברוש" /><option value="ברכה" /><option value="ברכיה" /><option value="ברעם" /><option value="ברק" /><option value="ברקאי" /><option value="ברקן" /><option value="ברקת" /><option value="בת הדר" /><option value="בת חן" /><option value="בת חפר" /><option value="בת חצור" /><option value="בת ים" /><option value="בת עין" /><option value="בת שלמה" /><option value="ג'דיידה-מכר" /><option value="ג'ולס" /><option value="ג'לג'וליה" /><option value="ג'נאביב )שבט)" /><option value="ג'סר א-זרקא" /><option value="ג'ש )גוש חלב)" /><option value="ג'ת" /><option value="גאולי תימן" /><option value="גאולים" />
<option value="גאליה" /><option value="גבולות" /><option value="גבים" /><option value="גבע" /><option value="גבע בנימין" /><option value="גבע כרמל" /><option value="גבעולים" /><option value="גבעון החדשה" /><option value="גבעות בר" /><option value="גבעת אבני" /><option value="גבעת אלה" /><option value="גבעת ברנר" /><option value="גבעת השלושה" /><option value="גבעת זאב" /><option value='גבעת ח"ן' /><option value="גבעת חיים )איחוד)" /><option value="גבעת חיים )מאוחד)" /><option value="גבעת יואב" /><option value="גבעת יערים" /><option value="גבעת ישעיהו" /><option value='גבעת כ"ח' /><option value='גבעת ניל"י' /><option value="גבעת עוז " /><option value="גבעת שמואל" /><option value="גבעת שמש" /><option value="גבעת שפירא" /><option value="גבעתי" /><option value="גבעתיים" /><option value="גברעם" /><option value="גבת" /><option value="גדות" /><option value="גדיש" /><option value="גדעונה" /><option value="גדרה" /><option value="גונן" /><option value="גורן" /><option value="גורנות הגליל" /><option value="גזית" /><option value="גזר" /><option value="גיאה" /><option value="גיבתון" /><option value="גיזו" /><option value="גילון" /><option value="גילת" /><option value="גינוסר" /><option value="גיניגר" /><option value="גינתון" /><option value="גיתה" /><option value="גיתית" /><option value="גלאון" /><option value="גלגל" /><option value="גליל ים" /><option value="גלעד )אבן יצחק)" /><option value="גמזו" /><option value="גן הדרום" /><option value="גן השומרון" /><option value="גן חיים" /><option value="גן יאשיה" /><option value="גן יבנה" /><option value="גן נר" /><option value="גן שורק" /><option value="גן שלמה" /><option value="גן שמואל" /><option value="גנות" /><option value="גנות הדר" /><option value="גני הדר" /><option value="גני טל" /><option value="גני יוחנן" /><option value="גני מודיעין" /><option value="גני עם" /><option value="גני תקווה" /><option value="געש" /><option value="געתון" /><option value="גפן" /><option value="גרופית" /><option value="גשור" /><option value="גשר" /><option value="גשר הזיו" /><option value="גת )קיבוץ)" /><option value="גת רימון" /><option value="דאלית אל-כרמל" /><option value="דבורה" /><option value="דבוריה" /><option value="דבירה" /><option value="דברת" /><option value="דגניה א'" /><option value="דגניה ב'" /><option value='דוב"ב' /><option value="דולב" /><option value="דור" /><option value="דורות" /><option value="דחי" /><option value="דייר אל-אסד" /><option value="דייר חנא" /><option value="דייר ראפאת" /><option value="דימונה" /><option value="דישון" /><option value="דליה" /><option value="דלתון" /><option value="דמיידה" /><option value="דן" /><option value="דפנה" /><option value="דקל" /><option value="דריג'את" /><option value="האון" /><option value="הבונים" /><option value="הגושרים" /><option value="הדר עם" /><option value="הוד השרון" /><option value="הודיה" /><option value="הודיות" /><option value="הוואשלה )שבט)" /><option value="הוזייל )שבט)" /><option value="הושעיה" /><option value="הזורע" /><option value="הזורעים" /><option value="החותרים" /><option value="היוגב" /><option value="הילה" /><option value="המעפיל" /><option value="הסוללים" /><option value="העוגן" /><option value="הר אדר" /><option value="הר גילה" /><option value="הר עמשא" /><option value="הראל" /><option value="הרדוף" /><option value="הרצליה" /><option value="הררית" /><option value="ורד יריחו" /><option value="ורדון" /><option value="זבארגה )שבט)" /><option value="זבדיאל" /><option value="זוהר" /><option value="זיקים" /><option value="זיתן" /><option value="זכרון יעקב" /><option value="זכריה" /><option value="זמר" /><option value="זמרת" /><option value="זנוח" /><option value="זרועה" /><option value="זרזיר" /><option value="זרחיה" /><option value="ח'ואלד" /><option value="ח'ואלד )שבט)" /><option value="חבצלת השרון" /><option value="חבר" /><option value="חברון" /><option value="חגור" /><option value="חגי" /><option value="חגלה" /><option value="חד-נס" /><option value="חדיד" /><option value="חדרה" /><option value="חוג'ייראת )ד'הרה)" /><option value="חולדה" /><option value="חולון" /><option value="חולית" /><option value="חולתה" /><option value="חוסן" /><option value="חוסנייה" /><option value="חופית" /><option value="חוקוק" /><option value="חורה" /><option value="חורפיש" /><option value="חורשים" /><option value="חזון" /><option value="חיבת ציון" /><option value="חיננית" /><option value="חיפה" /><option value="חירות" /><option value="חלוץ" /><option value="חלמיש" /><option value="חלץ" /><option value="חמאם" /><option value="חמד" /><option value="חמדיה" /><option value="חמדת" /><option value="חמרה" /><option value="חניאל" /><option value="חניתה" /><option value="חנתון" /><option value="חספין" /><option value="חפץ חיים" /><option value="חפצי-בה" /><option value="חצב" /><option value="חצבה" /><option value="חצור הגלילית" /><option value="חצור-אשדוד" /><option value="חצר בארותיים" /><option value="חצרות חולדה" /><option value="חצרות יסף" /><option value='חצרות כ"ח' /><option value="חצרים" /><option value="חרב לאת" /><option value="חרוצים" /><option value="חריש" /><option value="חרמש" /><option value="חרשים" /><option value="חשמונאים" /><option value="טבריה" /><option value="טובא-זנגריה" /><option value="טורעאן" /><option value="טייבה" />
<option value="טייבה )בעמק)" /><option value="טירה" /><option value="טירת יהודה" /><option value="טירת כרמל" /><option value="טירת צבי" /><option value="טל שחר" /><option value="טל-אל" /><option value="טללים" /><option value="טלמון" /><option value="טמרה" /><option value="טמרה )יזרעאל)" /><option value="טנא" /><option value="טפחות" /><option value="יאנוח-ג'ת" /><option value="יבול" /><option value="יבנאל" /><option value="יבנה" /><option value="יגור" /><option value="יגל" /><option value="יד בנימין" /><option value="יד השמונה" /><option value="יד חנה" /><option value="יד מרדכי" /><option value="יד נתן" /><option value='יד רמב"ם' /><option value="ידידה" /><option value="יהוד-מונוסון" /><option value="יהל" /><option value="יובל" /><option value="יובלים" /><option value="יודפת" /><option value="יונתן" /><option value="יושיביה" /><option value="יזרעאל" /><option value="יחיעם" /><option value="יטבתה" /><option value='ייט"ב' /><option value="יכיני" /><option value="ינוב" /><option value="ינון" /><option value="יסוד המעלה" /><option value="יסודות" /><option value="יסעור" /><option value="יעד" /><option value="יעל" /><option value="יעף" /><option value="יערה" /><option value="יפיע" /><option value="יפית" /><option value="יפעת" /><option value="יפתח" /><option value="יצהר" /><option value="יציץ" /><option value="יקום" /><option value="יקיר" /><option value="יקנעם )מושבה)" /><option value="יקנעם עילית" /><option value="יראון" /><option value="ירדנה" /><option value="ירוחם" /><option value="ירושלים" /><option value="ירחיב" /><option value="ירכא" /><option value="ירקונה" /><option value="ישע" /><option value="ישעי" /><option value="ישרש" /><option value="יתד" /><option value="יתיר" /><option value="כאבול" /><option value="כאוכב אבו אל-היג'א" /><option value="כברי" /><option value="כדורי" /><option value="כדיתה" /><option value="כוכב השחר" /><option value="כוכב יאיר" /><option value="כוכב יעקב" /><option value="כוכב מיכאל" /><option value="כורזים" /><option value="כחל" /><option value="כחלה" /><option value="כיסופים" /><option value="כישור" /><option value="כליל" /><option value="כלנית" /><option value="כמאנה" /><option value="כמהין" /><option value="כמון" /><option value="כנות" /><option value="כנף" /><option value="כנרת )מושבה)" /><option value="כנרת )קבוצה)" /><option value="כסיפה" /><option value="כסלון" /><option value="כסרא-סמיע" /><option value="כעביה-טבאש-חג'אג'רה" /><option value="כפר אביב" /><option value="כפר אדומים" /><option value="כפר אוריה" /><option value="כפר אחים" /><option value="כפר ביאליק" /><option value='כפר ביל"ו' /><option value="כפר בלום" /><option value="כפר בן נון" /><option value="כפר ברא" /><option value="כפר ברוך" /><option value="כפר גדעון" /><option value="כפר גלים" /><option value="כפר גליקסון" /><option value="כפר גלעדי" /><option value="כפר דניאל" /><option value="כפר האורנים" /><option value="כפר החורש" /><option value="כפר המכבי" /><option value="כפר הנגיד" /><option value="כפר הנוער הדתי" /><option value="כפר הנשיא" /><option value="כפר הס" /><option value='כפר הרא"ה' /><option value='כפר הרי"ף' /><option value="כפר ויתקין" /><option value="כפר ורבורג" />
<option value="כפר ורדים" /><option value="כפר זוהרים" /><option value="כפר זיתים" /><option value='כפר חב"ד'/><option value="כפר חושן" /><option value="כפר חיטים" /><option value="כפר חיים" /><option value="כפר חנניה" /><option value="כפר חסידים א'" /><option value="כפר חסידים ב'" /><option value="כפר חרוב" /><option value="כפר טרומן" /><option value="כפר יאסיף" /><option value="כפר ידידיה" /><option value="כפר יהושע" /><option value="כפר יונה" /><option value="כפר יחזקאל" /><option value="כפר יעבץ" /><option value="כפר כמא" /><option value="כפר כנא" /><option value="כפר מונש" /><option value="כפר מימון" /><option value='כפר מל"ל' /><option value="כפר מנדא" /><option value="כפר מנחם" /><option value="כפר מסריק" /><option value="כפר מצר" /><option value="כפר מרדכי" /><option value="כפר נטר" /><option value="כפר סאלד" /><option value="כפר סבא" /><option value="כפר סילבר" /><option value="כפר סירקין" /><option value="כפר עבודה" /><option value="כפר עזה" /><option value="כפר עציון" /><option value="כפר פינס" /><option value="כפר קאסם" /><option value="כפר קיש" /><option value="כפר קרע" /><option value="כפר ראש הנקרה" /><option value="כפר רוזנואלד )זרעית)" /><option value="כפר רופין" /><option value="כפר רות" /><option value="כפר שמאי" /><option value="כפר שמואל" /><option value="כפר שמריהו" /><option value="כפר תבור" /><option value="כפר תפוח" /><option value="כרי דשא" /><option value="כרכום" /><option value="כרם בן זמרה" /><option value="כרם בן שמן" /><option value="כרם יבנה )ישיבה)" /><option value='כרם מהר"ל' /><option value="כרם שלום" /><option value="כרמי יוסף" /><option value="כרמי צור" /><option value="כרמי קטיף" /><option value="כרמיאל" /><option value="כרמיה" /><option value="כרמים" /><option value="כרמל" /><option value="לא רשום" /><option value="לבון" /><option value="לביא" /><option value="לבנים" /><option value="להב" /><option value="להבות הבשן" /><option value="להבות חביבה" /><option value="להבים" /><option value="לוד" /><option value="לוזית" /><option value="לוחמי הגיטאות" /><option value="לוטם" /><option value="לוטן" /><option value="לימן" /><option value="לכיש" /><option value="לפיד" /><option value="לפידות" /><option value="לקיה" /><option value="מאור" /><option value="מאיר שפיה" /><option value="מבוא ביתר" /><option value="מבוא דותן" /><option value="מבוא חורון" /><option value="מבוא חמה" /><option value="מבוא מודיעים" /><option value="מבואות ים" /><option value="מבועים" /><option value="מבטחים" /><option value="מבקיעים" /><option value="מבשרת ציון" /><option value="מג'ד אל-כרום" /><option value="מג'דל שמס" /><option value="מגאר" /><option value="מגדים" /><option value="מגדל" /><option value="מגדל העמק" /><option value="מגדל עוז" /><option value="מגדלים" /><option value="מגידו" /><option value="מגל" /><option value="מגן" /><option value="מגן שאול" /><option value="מגשימים" /><option value="מדרך עוז" /><option value="מדרשת בן גוריון" /><option value="מדרשת רופין" /><option value="מודיעין עילית" /><option value="מודיעין-מכבים-רעות" /><option value="מולדת" /><option value="מוצא עילית" /><option value="מוקייבלה" /><option value="מורן" /><option value="מורשת" /><option value="מזור" /><option value="מזכרת בתיה" /><option value="מזרע" /><option value="מזרעה" /><option value="מחולה" />
<option value="מחנה הילה" /><option value="מחנה טלי" /><option value="מחנה יהודית" /><option value="מחנה יוכבד" /><option value="מחנה יפה" /><option value="מחנה יתיר" /><option value="מחנה מרים" /><option value="מחנה תל נוף" /><option value="מחניים" /><option value="מחסיה" /><option value="מטולה" /><option value="מטע" /><option value="מי עמי" /><option value="מיטב" /><option value="מייסר" /><option value="מיצר" /><option value="מירב" /><option value="מירון" /><option value="מישר" /><option value="מיתר" /><option value="מכורה" /><option value="מכחול" /><option value="מכמורת" /><option value="מכמנים" /><option value="מלאה" /><option value="מלילות" /><option value="מלכיה" /><option value="מלכישוע" /><option value="מנוחה" /><option value="מנוף" /><option value="מנות" /><option value="מנחמיה" /><option value="מנרה" /><option value="מנשית זבדה" /><option value="מסד" /><option value="מסדה" /><option value="מסילות" /><option value="מסילת ציון" /><option value="מסלול" /><option value="מסעדה" /><option value="מסעודין אל-עזאזמה" /><option value="מעברות" /><option value="מעגלים" /><option value="מעגן" /><option value="מעגן מיכאל" /><option value="מעוז חיים" /><option value="מעון" /><option value="מעונה" /><option value="מעיליא" /><option value="מעין ברוך" /><option value="מעין צבי" /><option value="מעלה אדומים" /><option value="מעלה אפרים" /><option value="מעלה גלבוע" /><option value="מעלה גמלא" /><option value="מעלה החמישה" /><option value="מעלה לבונה" /><option value="מעלה מכמש" /><option value="מעלה עירון" /><option value="מעלה עמוס" /><option value="מעלה שומרון" /><option value="מעלות-תרשיחא" /><option value="מענית" /><option value="מעש" /><option value="מפלסים" /><option value="מצדות יהודה" /><option value="מצובה" /><option value="מצליח" /><option value="מצפה" /><option value='מצפה אבי"ב' /><option value="מצפה אילן" /><option value="מצפה יריחו" /><option value="מצפה נטופה" /><option value="מצפה רמון" /><option value="מצפה שלם" /><option value="מצר" /><option value="מקווה ישראל" /><option value="מרגליות" /><option value="מרום גולן" /><option value="מרחב עם" /><option value="מרחביה )מושב)" /><option value="מרחביה )קיבוץ)" /><option value="מרכז שפירא" /><option value="משאבי שדה" /><option value="משגב דב" /><option value="משגב עם" /><option value="משהד" /><option value="משואה" /><option value="משואות יצחק" /><option value="משכיות" /><option value="משמר איילון" /><option value="משמר דוד" /><option value="משמר הירדן" /><option value="משמר הנגב" /><option value="משמר העמק" /><option value="משמר השבעה" /><option value="משמר השרון" /><option value="משמרות" /><option value="משמרת" /><option value="משען" /><option value="מתן" /><option value="מתת" /><option value="מתתיהו" /><option value="נאות גולן" /><option value="נאות הכיכר" /><option value="נאות מרדכי" /><option value="נאות סמדר" /><option value="נאעורה" /><option value="נבטים" /><option value="נגבה" /><option value="נגוהות" /><option value="נהורה" /><option value="נהלל" /><option value="נהריה" /><option value="נוב" /><option value="נוגה" /><option value="נווה" /><option value="נווה אבות" /><option value="נווה אור" /><option value='נווה אטי"ב' /><option value="נווה אילן" /><option value="נווה איתן " /><option value="נווה דניאל" /><option value="נווה זוהר" /><option value="נווה זיו" /><option value="נווה חריף" /><option value="נווה ים" /><option value="נווה ימין" />
<option value="נווה ירק" /><option value="נווה מבטח" /><option value="נווה מיכאל" /><option value="נווה שלום" /><option value="נועם" /><option value="נוף איילון" /><option value="נופים" /><option value="נופית" /><option value="נופך" /><option value="נוקדים" /><option value="נורדיה" /><option value="נורית" /><option value="נחושה" /><option value="נחל עוז" /><option value="נחלה" /><option value="נחליאל" /><option value="נחלים" /><option value="נחם" /><option value="נחף" /><option value="נחשולים" /><option value="נחשון" /><option value="נחשונים" /><option value="נטועה" /><option value="נטור" /><option value="נטע" /><option value="נטעים" /><option value="נטף" /><option value="ניין" /><option value='ניל"י' /><option value="ניצן" /><option value="ניצן ב'" /><option value="ניצנה )קהילת חינוך)" /><option value="ניצני סיני" /><option value="ניצני עוז" /><option value="ניצנים" /><option value="ניר אליהו" /><option value="ניר בנים" /><option value="ניר גלים" /><option value="ניר דוד )תל עמל)" /><option value='ניר ח"ן' /><option value="ניר יפה" /><option value="ניר יצחק" /><option value="ניר ישראל" /><option value="ניר משה" /><option value="ניר עוז" /><option value="ניר עם" /><option value="ניר עציון" /><option value="ניר עקיבא" /><option value="ניר צבי" /><option value="נירים" /><option value="נירית" /><option value="נירן" /><option value="נמרוד" /><option value="נס הרים" /><option value="נס עמים" /><option value="נס ציונה" /><option value="נעורים" /><option value="נעלה" /><option value='נעמ"ה' /><option value="נען" /><option value="נצאצרה )שבט)" /><option value="נצר חזני" /><option value="נצר סרני" /><option value="נצרת" /><option value="נצרת עילית" /><option value="נשר" /><option value="נתיב הגדוד" /><option value='נתיב הל"ה' /><option value="נתיב העשרה" /><option value="נתיב השיירה" /><option value="נתיבות" /><option value="נתניה" /><option value="סאג'ור" /><option value="סאסא" /><option value="סביון" /><option value="סגולה" /><option value="סואעד )חמרייה)" /><option value="סואעד )כמאנה( )שבט)" /><option value="סולם" /><option value="סוסיה" /><option value="סופה" /><option value="סח'נין" /><option value="סייד )שבט)" /><option value="סלמה" /><option value="סלעית" /><option value="סמר" /><option value="סנסנה" /><option value="סעד" /><option value="סעוה" /><option value="סער" /><option value="ספיר" /><option value="סתריה" /><option value="ע'ג'ר" /><option value="עבדון" /><option value="עברון" /><option value="עגור" /><option value="עדי" /><option value="עדנים" /><option value="עוזה" /><option value="עוזייר" /><option value="עולש" /><option value="עומר" /><option value="עופר" /><option value="עופרה" /><option value="עוצם" /><option value="עוקבי )בנו עוקבה)" /><option value="עזוז" /><option value="עזר" /><option value="עזריאל" /><option value="עזריה" /><option value="עזריקם" /><option value="עטאוונה )שבט)" /><option value="עטרת" /><option value="עידן" /><option value="עיילבון" /><option value="עיינות" /><option value="עילוט" /><option value="עין איילה" /><option value="עין אל-אסד" /><option value="עין גב" /><option value="עין גדי" /><option value="עין דור" /><option value="עין הבשור" /><option value="עין הוד" /><option value="עין החורש" /><option value="עין המפרץ" /><option value='עין הנצי"ב' /><option value="עין העמק" /><option value="עין השופט" /><option value="עין השלושה" /><option value="עין ורד" /><option value="עין זיוון" /><option value="עין חוד" /><option value="עין חצבה" /><option value="עין חרוד )איחוד)" /><option value="עין חרוד )מאוחד)" /><option value="עין יהב" />
<option value="עין יעקב" /><option value='עין כרם-בי"ס חקלאי' /><option value="עין כרמל" /><option value="עין מאהל" /><option value="עין נקובא" /><option value="עין עירון" /><option value="עין צורים" /><option value="עין קנייא" /><option value="עין ראפה" /><option value="עין שמר" /><option value="עין שריד" /><option value="עין תמר" /><option value="עינת" /><option value="עיר אובות" /><option value="עכו" /><option value="עלומים" /><option value="עלי" /><option value="עלי זהב" /><option value="עלמה" /><option value="עלמון" /><option value="עמוקה" /><option value="עמיחי" /><option value="עמינדב" /><option value="עמיעד" /><option value="עמיעוז" /><option value="עמיקם" /><option value="עמיר" /><option value="עמנואל" /><option value="עמקה" /><option value="ענב" /><option value="עספיא" /><option value="עפולה" /><option value="עץ אפרים" /><option value="עצמון שגב" /><option value="עראבה" /><option value="עראמשה" /><option value="ערב אל נעים" /><option value="ערד" /><option value="ערוגות" /><option value="ערערה" /><option value="ערערה-בנגב" /><option value="עשרת" /><option value="עתלית" /><option value="עתניאל" /><option value="פארן" /><option value="פדואל" /><option value="פדויים" /><option value="פדיה" /><option value="פוריה - כפר עבודה " /><option value="פוריה - נווה עובד " /><option value="פוריה עילית" /><option value="פוריידיס" /><option value="פורת" /><option value="פטיש" /><option value="פלך" /><option value="פלמחים" /><option value="פני חבר" /><option value="פסגות" /><option value="פסוטה" /><option value='פעמי תש"ז' /><option value="פצאל" /><option value="פקיעין )בוקייעה( " /><option value="פקיעין חדשה" /><option value="פרדס חנה-כרכור" /><option value="פרדסיה" /><option value="פרוד" /><option value="פרזון" /><option value="פרי גן" /><option value="פתח תקווה" /><option value="פתחיה" /><option value="צאלים" /><option value="צביה" /><option value="צבעון" /><option value="צובה" /><option value="צוחר" /><option value="צופיה" /><option value="צופים" /><option value="צופית" /><option value="צופר" /><option value="צוקי ים" /><option value="צוקים" /><option value="צור הדסה" /><option value="צור יצחק" /><option value="צור משה" /><option value="צור נתן" /><option value="צוריאל" /><option value="צורית" /><option value="ציפורי" /><option value="צלפון" /><option value="צנדלה" /><option value="צפריה" /><option value="צפרירים" /><option value="צפת" /><option value="צרופה" /><option value="צרעה" /><option value="קבועה )שבט(" /><option value="קבוצת יבנה" /><option value="קדומים" /><option value="קדימה-צורן" /><option value="קדמה" /><option value="קדמת צבי" /><option value="קדר" /><option value="קדרון" /><option value="קדרים" /><option value="קודייראת א-צאנע)שבט(" /><option value="קוואעין )שבט(" /><option value="קוממיות" /><option value="קורנית" /><option value="קטורה" /><option value="קיסריה" /><option value="קלחים" /><option value="קליה" /><option value="קלנסווה" /><option value="קלע" /><option value="קציר" /><option value="קצר א-סר" /><option value="קצרין" /><option value="קרית אונו" /><option value="קרית ארבע" /><option value="קרית אתא" /><option value="קרית ביאליק" /><option value="קרית גת" /><option value="קרית טבעון" /><option value="קרית ים" />
<option value="קרית יערים" /><option value="קרית יערים)מוסד(" /><option value="קרית מוצקין" /><option value="קרית מלאכי" /><option value="קרית נטפים" /><option value="קרית ענבים" /><option value="קרית עקרון" /><option value="קרית שלמה" /><option value="קרית שמונה" /><option value="קרני שומרון" /><option value="קשת" /><option value="ראמה" /><option value="ראס אל-עין" /><option value="ראס עלי" /><option value="ראש העין" /><option value="ראש פינה" /><option value="ראש צורים" /><option value="ראשון לציון" /><option value="רבבה" /><option value="רבדים" /><option value="רביבים" /><option value="רביד" /><option value="רגבה" /><option value="רגבים" /><option value="רהט" /><option value="רווחה" /><option value="רוויה" /><option value="רוח מדבר" /><option value="רוחמה" /><option value="רומאנה" /><option value="רומת הייב" /><option value="רועי" /><option value="רותם" /><option value="רחוב" /><option value="רחובות" /><option value="רחלים" /><option value="ריחאניה" /><option value="ריחן" /><option value="ריינה" /><option value="רימונים" /><option value="רינתיה" /><option value="רכסים" /><option value="רם-און" /><option value="רמות" /><option value="רמות השבים" /><option value="רמות מאיר" /><option value="רמות מנשה" /><option value="רמות נפתלי" /><option value="רמלה" /><option value="רמת גן" /><option value="רמת דוד" /><option value="רמת הכובש" /><option value="רמת השופט" /><option value="רמת השרון" /><option value="רמת יוחנן" /><option value="רמת ישי" /><option value="רמת מגשימים" /><option value="רמת צבי" /><option value="רמת רזיאל" /><option value="רמת רחל" /><option value="רנן" /><option value="רעים" /><option value="רעננה" /><option value="רקפת" /><option value="רשפון" /><option value="רשפים" /><option value="רתמים" /><option value="שאר ישוב" /><option value="שבי דרום" /><option value="שבי ציון" /><option value="שבי שומרון" /><option value="שבלי - אום אל-גנם" /><option value="שגב-שלום" /><option value="שדה אילן" /><option value="שדה אליהו" /><option value="שדה אליעזר" /><option value="שדה בוקר" /><option value="שדה דוד" /><option value="שדה ורבורג" /><option value="שדה יואב" /><option value="שדה יעקב" /><option value="שדה יצחק" /><option value="שדה משה" /><option value="שדה נחום" /><option value="שדה נחמיה" /><option value="שדה ניצן" /><option value="שדה עוזיהו" /><option value="שדה צבי" /><option value="שדות ים" /><option value="שדות מיכה" /><option value="שדי אברהם" /><option value="שדי חמד" /><option value="שדי תרומות" /><option value="שדמה" /><option value="שדמות דבורה" /><option value="שדמות מחולה" /><option value="שדרות" /><option value="שואבה" /><option value="שובה" /><option value="שובל" /><option value="שוהם" /><option value="שומרה" /><option value="שומריה" /><option value="שוקדה" /><option value="שורש" /><option value="שורשים" /><option value="שושנת העמקים" /><option value="שזור" /><option value="שחר" /><option value="שחרות" /><option value="שיבולים" /><option value="שיטים" /><option value="שייח' דנון" /><option value="שילה" /><option value="שילת" /><option value="שכניה" /><option value="שלווה" /><option value="שלווה במדבר" /><option value="שלוחות" /><option value="שלומי" /><option value="שלומית" /><option value="שמיר" /><option value="שמעה" /><option value="שמרת" /><option value="שמשית" /><option value="שני" /><option value="שניר" /><option value="שעב" /><option value="שעורים" /><option value="שעל" /><option value="שעלבים" /><option value="שער אפרים" /><option value="שער הגולן" /><option value="שער העמקים" /><option value="שער מנשה" /><option value="שערי תקווה" /><option value="שפיים" /><option value="שפיר" /><option value="שפר" /><option value="שפרעם" /><option value="שקד" /><option value="שקף" /><option value="שרונה" /><option value="שריגים )לי-און( " /><option value="שריד" /><option value="שרשרת" /><option value="שתולה" /><option value="שתולים" /><option value="תאשור" /><option value="תדהר" /><option value="תובל" /><option value="תומר" /><option value="תושיה" /><option value="תימורים" /><option value="תירוש" /><option value="תל אביב - יפו" /><option value="תל יוסף" /><option value="תל יצחק" /><option value="תל מונד" /><option value="תל עדשים" /><option value="תל קציר" /><option value="תל שבע" /><option value="תל תאומים" /><option value="תלם" /><option value="תלמי אליהו" /><option value="תלמי אלעזר" /><option value='תלמי ביל"ו' /><option value="תלמי יוסף" /><option value="תלמי יחיאל" /><option value="תלמי יפה" /><option value="תלמים" /><option value="תמרת" /><option value="תנובות" /><option value="תעוז" /><option value="תפרח" /><option value="תקומה" /><option value="תקוע" /><option value="תראבין א-צאנע )שבט(" /><option value="תראבין א-צאנע)ישוב(" /><option value="תרום" />

        
     </datalist>
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
                        width="40" alt="Admin">
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
                        <li >
                            <a href="index.php"><i class="fas fa-home"></i> דף הבית</a>
                        </li>
                        <li class="active">
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
                         <li >
                             <a href="help.php"><i class="fa fa-info"></i>
                            עזרה            
                             </a>
                        </li>
                        <li>
                             <a href="faq.php"> <i class="far fa-question-circle"></i>
                           שאלות ותשובות           
                             </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-wrapper">
            <div class="chat-main-row">
                <div class="chat-main-wrapper">
                    <div class="col-lg-12 message-view">
                        <div class="chat-window">
                            <div class="fixed-header">
                                <div class="row">
                                    <div class="col-4">
                                        <h4 class="page-title m-b-0 m-t-5">פיד בקבוקים</h4>
                                    </div>
                                    <div class="col-8">
                                       <form method="post" action="feedSearch.php">
                                        <div class="navbar justify-content-end">
                                            <div class="search-box m-t-0">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" placeholder="חפש לפי שם עיר" id="searchCity" name="searchCity" list="dlCities">
                                                    <span class="input-group-append">
														<button class="btn" type="button"><i class="fa fa-search"></i></button>
													</span>
                                                </div>
                                            </div>
                                            <ul class="nav pull-right custom-menu"  >
                                                <li class="nav-item dropdown dropdown-action">
                                                   <button class="btn btn-primary"  type="submit" id="submitSearch" name="submitSearch">
                                                       חפש
                                                   </button>
                                                </li>
                                            </ul>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-contents">
                                <div class="chat-content-wrap">
                                    <div class="chat-wrap-inner">
                                        <div class="contact-box">
                                        <div class="row">
                                            <div class="contact-cat col-sm-4 col-lg-3">
                                                <a href="add-post.php" class="btn btn-primary btn-block"> צור פוסט <i class="fa fa-plus"></i></a>
                                                <div class="roles-menu">
                                                    <ul>
                                                        <li><a href="feed.php">הכל</a></li>
                                                        <li><a href="feedCity.php">בעיר שלי</a></li>
                                                        <li class="active"><a href="feedRev.php">שווי</a></li>
                                                       
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="contacts-list col-sm-8 col-lg-9">
                                                <ul class="contact-list" id="feed">
                                                        <?php
                                                        
                                                        $sql="SELECT * from posts WHERE paid=0 AND isDeleted='0'   ORDER BY revenue DESC LIMIT 10";
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
                                                                   <div class="dropdown-menu dropdown-menu-right" style="text-align:right;">
                                                                        <a class="dropdown-item" href="edit-post.php?update=true&id='.$row['id'].'" >ערוך</a>
                                                                        <a class="dropdown-item" href="myPosts.php?delete=true&id='.$row['id'].'" >מחק</a>
                                                                        
                                                                        
                                                                    </div>
                                                                    
                                                                </li>
                                                            </ul>
                                                              
                                                              
                                                              
                                                              
                                                              '   ;
                                                            }
                                                           
                                                            echo ' <br>
                                                        </div> ';
                                                           }
                                                       }
            
                                                        
                                                        
                                                        ?>
                                                       
                                                </ul>
                                               
                                               
                                                <button class="btn btn-primary btn-block"  name="reload" id="reload"> 
                                                טען עוד
                                                <i class="fa fa-plus"></i>
                                                </button>
                                                
                                            </div>
                                      
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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