<script type="text/javascript" src="js/meter.js"></script>
<script>
function blinkIt() {
    if (!document.all) return;
    else {
        for(i=0;i<document.all.tags('blink').length;i++){
            s=document.all.tags('blink')[i];
            s.style.visibility=(s.style.visibility=='visible') ?'hidden':'visible';
        }
    }
}
</script>
<!--<link type="text/css" rel="stylesheet" href="css/meter.css">-->
<?php
require("config.php");
include("connect_db.php");
if (isset($_SESSION['login'])) {$login=$_SESSION['login'];}
if (isset($_GET['login'])) {$login=$_GET['login'];}
if (isset($_GET['balance'])) {$balance=$_GET['balance'];} else {$balance=0;}

if ((strlen($login)!=6) and (strlen($login)!=7)) {exit;}

$B="select goal,whenstop from nucleusrun where account='".$login."'";
$BB=mysql_query($B);
list($goal,$whenstop)=mysql_fetch_array($BB);
if ($goal!="")
{
if ($balance==0) {
$L="select balance from balance where account='".$login."'";
$LL=mysql_query($L);
list($balance)=mysql_fetch_array($LL);
}
$pourc=($balance/$goal)*100;
if ( ($pourc>=100) || ($whenstop==date("Y-m-d")))
	{
		// GOAL IS REACHED
		$success=1;
		//Echo"GOAL RACHED:".$pourc." ".$whenstop;
		$R="select goal,winsertdata,whenstop,moderisk,result,code from resultrun where account='".$login."' order by timeinsert desc limit 0,1";
		$RR=mysql_query($R);
		list($goal,$winsertdata,$whenstop,$moderisk,$result,$code)=mysql_fetch_array($RR);
		
	}
	else
	{
		$success=0;
	}
//echo"<li>".$pourc;
$pourc=round($pourc,2);
}
else
{
	$pourc="N/A";
	$goal="<a href='nucleus.php' class='large green button'>SETUP YOUR GOAL NOW !</a>";
}
include("end_db.php");
?>
<style media="screen" type="text/css">
#countdown-wrap {
  width: 100%;
  height: 100px;
  //border: 1px solid black;
  padding: 20px;
  font-family: arial;
}

#goal {
  font-size: 48px;
  text-align: right;
  width: 80%;
  @media only screen and (max-width : 640px) {
    text-align: center;  
  }
  
}

#glass {
  width: 80%;
  height: 20px;
  background: #c7c7c7;
  border-radius: 10px;
  float: left;
  overflow: hidden;
}

#progress {
  float: left;
  width: <?php echo $pourc;?>%;
  height: 20px;
  background: #AB2430;
  z-index: 333;
  //border-radius: 5px;
}

.goal-stat {
  width: 20%;
  height: 30px;
  padding: 10px;
  float: left;
  margin: 0;
  
  @media only screen and (max-width : 640px) {
    width: 40%;
    text-align: center;
  }
}

.goal-number, .goal-label {
  display: block;
}

.goal-number {
  font-weight: bold;
}
</style>
<?php
global $success;
if ($success==0)
{
?>
<div id=countdown-wrap align=center>
  <div id="goal">$<?php echo $goal;?></div>
  <div id="glass">
    <div id="progress">
    </div>
  </div>
  <div class="goal-stat">
    <span class="goal-number"><?php 
	if ($success==1) {echo "<div id='blink'>";}
   echo $pourc;
   if ($success==1) {echo"</div>";}
    
    
    ?>%</span>
    <span class="goal-label">Successfull</span>
  </div>
  <div class="goal-stat">
    <span class="goal-number">$<?php echo $balance;?></span>
    <span class="goal-label">Already secured</span>
  </div>
  <div class="goal-stat">
    <span class="goal-number"><div id="countdown"></div></span>
    <span class="goal-label">Days to Go</span>
  </div>
  <div class="goal-stat">
  <!--  <span class="goal-number">38</span>
    <span class="goal-label">Sponsors</span>-->
  </div>
</div>
<script>
    CountDownTimer('<?php echo $whenstop ?>', 'countdown');
    //CountDownTimer('12/20/2014 10:1 AM', 'newcountdown');
</script>
<?php
}
else
{
if ($code==1)
	{
?>
<h1>YOUR FINANCIAL GOAL HAS BEEN REACHED THE <?php echo $whenstop ?></h1>
<?php
	}
else
	{

?>
<h1> YOU FAILED TO REACH YOUR GOAL THE <?php echo $whenstop ?></h1>
<?php

	}
}
?>