<?php
session_start();
$login=$_SESSION['login'];
$gain=$_REQUEST['gain'];
$days=$_REQUEST['days'];
$gain=intval($gain);
include("config.php");
include("connect_db.php");
$SQL="select balance from balance where account='".$login."'";
$SS=mysql_query($SQL);
list($balance)=mysql_fetch_array($SS);
$days=intval($days);
$balance_to_reach=$balance+$balance*$gain/100;
$gainbyday= intval(($balance_to_reach-$balance)/$days);
$risk=($gainbyday/$balance)*100;
$risk=round($risk,2);
$mrisk=1;
if ($risk<0.25) {$kind_risk="Conservative";$mrisk=1;}
if ( ($risk>0.2499) and ($risk<0.9)) {$kind_risk="Moderate";$mrisk=2;}
if (($risk>0.89) and ($risk<1.99)) {$kind_risk="High";$mrisk=4;}
if ($risk>1.989) {$kind_risk="Gambling mode";$mrisk=8;}
$date = date("Y-m-d");
//increment 2 days
$mod_date = strtotime($date."+ ".$days." days");
$Date2=date("Y-m-d",$mod_date) . "\n";


include("end_db.php");
?>  <link type="text/css" rel="stylesheet" href="css/box2.css">
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="guide/css/slider.css">
 
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css">
 <script src="guide/js/slider2.js"></script>

  <section id="content">
  <h1> STEP 3 - CONFIRM YOUR GOALS AND START  !</h1><br>
     <h1><a href='javascript:document.getElementById("confirm").submit();' class='large green button'> CONFIRM YOUR CHOICE BY CLICKING HERE --- SAVE YOUR CHOICE AND START !</a></h1><br>
  <h2> Your balance now is <?php echo "<font color=red>".$balance. " USD</font>" ?></h2>
  <h2> The gain's objective you setuped is <?php echo "<font color=red>".$gain." %</font>" ?></h2>
  <h2> The balance level you want to reach is <?php echo "<font color=red>".intval($balance_to_reach)." USD</font>"; ?></h2>
  <h2> You want to reach this level in <?php echo "<font color=red>".intval($days)." days</font>"; ?></h2>
  <h2> With an absolute gain of  <?php echo "<font color=red>".intval($balance_to_reach-$balance)." USD</font>"; ?></h2>
    <h2> Then gaining around <?php echo "<font color=red>".intval(($balance_to_reach-$balance)/$days)." USD by day</font>"; ?></h2>
    <h2> We need to start with a <?php echo "<font color=red>".$risk." % by day</font>"; ?></h2>
    <h2> We consider the risk you want to take as a(an) <?php echo "<font color=red>".$kind_risk."</font> Risk"; ?>
    <h2> Today is the <?php echo "<font color=red>".$date."</font>";?>
    <h2> Nucleus will run until <?php echo "<font color=red>".$Date2."</font> and stop at this date to give you back the result</h2>"; ?>
   <br> 
   <form id='confirm' action="savenucleuschoice.php">
   <input type='hidden' name='dateend' value='<?php echo trim($Date2) ?>'>
    <input type='hidden' name='balancereach' value='<?php echo $balance_to_reach ?>'>
    <input type='hidden' name='risktotake' value='<?php echo $mrisk ?>'>
   </form>

   <br>
    <h2><a href="setup-goal.php?risk=<?php echo $gain ?>"> Go back to the time choice </a>  | <a href="nucleus.php"> Start from 0 with the gain choice </a></h2>