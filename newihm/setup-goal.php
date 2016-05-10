    <link type="text/css" rel="stylesheet" href="css/box2.css">
<?php
session_start();
$login=$_SESSION['login'];
$gain=$_REQUEST['risk'];
$gain=intval($gain);
include("config.php");
include("connect_db.php");
$SQL="select balance from balance where account='".$login."'";
$SS=mysql_query($SQL);
list($balance)=mysql_fetch_array($SS);

$balance_to_reach=$balance+$balance*$gain/100;
include("end_db.php");
?>
<script>
localStorage.setItem("gain",'<?php echo $gain;?>'); 
function onclickvalue()
{  
var value=$("input:text").val();
window.location.href='setup-goal-final.php?gain='+localStorage.getItem('gain')+'&days='+value;
//alert(value);
}
</script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="guide/css/slider.css">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css">
 <script src="guide/js/slider2.js"></script>

  <section id="content">
  <h1> STEP 2 - SET THE TIME GOAL !</h1><br>
  <h2><a href='nucleus.php' class='large green button'>Go back to gain choice </a> <a href='javascript:onclickvalue()' class='large green button'>Go to confirmation page, confirm your choices </a></h2><br>
  <h2> Your balance now : <?php echo $balance. " USD" ?></h2>
  <h2> The gain's objective you setuped : <?php echo $gain." %" ?></h2>
  <h2> The balance you want to reach : <?php echo intval($balance_to_reach)." USD"; ?></h2>


    <h1> In how many days you want to acheive this goal ?</h1>
  <div class="cube">
    <div class="a"></div>
    <div class="b"></div>
    <div class="c"></div>
    <div class="d"></div>
    <div id="slider-range-min"></div>
  </div>

  <input type="text" id="amount" />
