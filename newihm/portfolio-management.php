 <!DOCTYPE html>
<html>
 <head>
 <meta charset="UTF-8">
 <title> Portfolio Management | Forex professional signals with ThirdBrainFx since 2010</title>
<meta name="description" content="ThirdBrainFx has been operating since 2010 and is a software application designed to buy and sell foreign currencies automatically.This software is made up of multiple programmes called strategies, each of which is independent of the others, and which are essentially based on mathematical algorithms.">
<meta name="keywords" content="mirror trading, social trading, trading, forex, automated forex strategies, forex strategies, forex account, broker">
<meta name="author" content="ThirdBrain SA">
</head>
<body>
<?php
session_start();
?>
<?php 
if (!(isset($_SESSION['partner'])))
{
?>
<center>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- LeaderBoard -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-5349092563133123"
     data-ad-slot="4367566495"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></center>
<?php
}
global $profit_lm,$dd_lm;
if (isset($_SESSION['login']))
{
 $login=$_SESSION['login'];
 $token=$_SESSION['token'];
 $password=$_SESSION['password'];
 $balance=$_SESSION['balance'];
$ok=1;$guest=0;
 }
 else
 {
 $ok=0;
 $time=time();
 $login=md5($time);
 $token=$login;
 $balance=50000;
  $password=$login;
  $ok=1;
  $guest=1;
 }
 //echo "<li>".$login;
?>
<link rel="stylesheet" href="css/onoff.css">
<link type="text/css" rel="stylesheet" href="css/message.css">
<link rel="stylesheet" href="css/signal.css">
<link type="text/css" rel="stylesheet" href="css/box.css">
 <link type="text/css" rel="stylesheet" href="css/table.css">
 <link rel="stylesheet" href="font/css/font-awesome.min.css">
 <script src="js/sortable.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
 <script type="text/javascript" src="js/manage.js?time=<?php echo time() ?>"></script>
<?php
include ("config.php");
include ("connect_db.php");
$SQL="select instrument,strategy,whenopen,profit,count,dayprofit,drawdown,winningperc,awt,alt,tbx_score from ranking order by tbx_score desc,profit desc";
$R=mysql_query($SQL);
echo mysql_error();
?>
<div id='message'></div>
<?php


$month_today=date("n");
	$year_today=date("Y");

// Month before for consolidation
$month=$month_today-1;
if ($month_today<1)
	{
		$month=12;
		$year=$year_today-1;
	}
	else
	{
	
	$year=$year_today;
	
	}
$_ERROR=0;$message="";


?>
<script>
setInterval(function(){ getbackriskandgain('<?php echo $token;?>','<?php echo $balance; ?>'); } , 1000);
</script>

<?php
echo "<table width=100% cellpadding=0 cellspacing=0 border=0 class=\"sortable\">";
echo "<CAPTION>";
echo"<div id='riskandgain'></div>";
if ($guest==1)
{
if (!(isset($_SESSION['partner'])))
{
echo"<div id='receiveitbymail'>Receive signal directly to your email or your trading account by <a href='http://www.thirdbrainfx.com/go-beyond-financial-dashboard-go-live'>by signing up for a live account clicking here</a></div>";
}
}
else
{
$state="unchecked";
?>
<!--EMAIL TO SWITCH LATER
  <div class="onoffswitch">
    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" onClick="changeEmail('<?php echo $token ?>');" <?php echo $state ?>>
    <label class="onoffswitch-label" for="myonoffswitch" >
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>
-->
<?php
}
echo"</CAPTION>";
echo "<thead><th>Add/Remove from portfolio</th><th>Graph</th><th>Instrument</th><th>Strategy</th><th>Month profit</th><th>Last Month Profit</th><th>Month Drawdown</th><th>Last Month Drawdown</th><th>Trades</th><th> % win</th><th> Tbx score</th></thead>";
while (list($instrument,$strategy,$whenopen,$profit,$count,$dayprofit,$drawdown,$winninperc,$awt,$alt,$tbx_score)=mysql_fetch_array($R))
{
	$SS="select SUM(profit), COUNT(id) from tradedb where instrument='".$instrument."' AND strategy='".$strategy."' and digit!=99";
   	$Q=mysql_query($SS,$mysql);
	list ($sumprofit,$traderunning)=mysql_fetch_array($Q);
	if ($ok==1)
	{	
	
		$SQL="select pips,drawdown,trades_win,trades_loose from datastats where month='".$month."' AND year='".$year."' AND instrument='".$instrument."' AND strategy='".$strategy."'";
		//echo "<li>".$SQL;
		$R2=mysql_query($SQL);
		list ($profit_lm,$dd_lm,$trade_w,$trade_l)=mysql_fetch_array($R2);
		if ($profit_lm=="") {$profit_lm="N/A";}
		if ($dd_lm=="") {$dd_lm="N/A";}
		$total_trades=$trade_w+$trade_l;

if ($total_trades<10) {$frequency="Low";}
if (($total_trades>9) && ($total_trades<30)) {$frequency="medium";}
if (($total_trades>29) && ($total_trades<90)) {$frequency="high";}
if ($total_trades>89) {$frequency="very high";}
if ($total_trades=="") {$frequency="N/A";}
	
	        $id_portfolio="";$lot_size="";
		if (strlen($login)!=32)
		{
		$SSS="select id,lot,accountpwd from portofolio_dashboard where accountid='".$login."' and instrument='".$instrument."' and strategy='".$strategy."'";
		}
		else
		{
		$SSS="select id,lot,accountpwd from portofolio_dashboard_guest where accountid='".$login."' and instrument='".$instrument."' and strategy='".$strategy."'";
		
		}
		//echo "<li>".$SSS;
		$rrr=mysql_query($SSS);
		list($id_portfolio,$lot_size,$_password_inside)=mysql_fetch_array($rrr);
		if (($_password_inside!=$password) && ($_password_inside!=""))
		{
			$message=" Your portfolio was created with an another password for your account. We have detected 2 passwords differents, we need to state on what is the good ones for security reasons. You need to re-synchronize by login giving the right password, logout and login again <a href='logout.php'>Logout</a>. <br> If you made a change directly inside xStation, please contact support at support@thirdbrain.ch, we will check and change the password inside your portfolio. During this time the trade are blocked and won't be send (except close orders).";
			$_ERROR=1;$addhtml="AUTOTRADING DISABLED";
			
		}
		//if (($password==$login) && ($login!="")) {$_ERROR=1;}
		if ($_ERROR!=1)
		{
		
		//if (in_array($instrument,$_FX))
		// {
		
		if ($id_portfolio=="")
			{
			$addhtml="<div id='por_".$strategy.$instrument."'><a href=\"javascript:registerPortfolio('".$login."','".$token."','".$strategy."','".$instrument."');\"'><i class=\"fa fa-square-o fa-2x\"></i></a></div>";
			$addhtml.="<div id='lot_".$strategy.$instrument."'></div>";
			
			}
		else
			{
			$addhtml="<div id='por_".$strategy.$instrument."'><a href=\"javascript:removePortfolio('".$login."','".$token."','".$strategy."','".$instrument."');\"><i class=\"fa fa-check-square fa-2x\"></i></a></div>";
			$addhtml.="<div id='lot_".$strategy.$instrument."'><a href=\"javascript:changelotsizedown('".$lot_size."','".$login."','".$token."','".$strategy."','".$instrument."');\"'><i class=\"fa fa-sort-desc fa-2x\"></i></a> ".$lot_size."</a> <a href=\"javascript:changelotsizeup('".$lot_size."','".$login."','".$token."','".$strategy."','".$instrument."');\"'><i class=\"fa fa-sort-asc fa-2x\"></i></a></div>";
		
			}
		 //}
		//else
		 //{

		//	$addhtml="<div id='por_".$strategy.$instrument."'>Not available for autotrading</div>";
			

		 //}
	        }
		
	 }
	 else
	 {
	 $addhtml="";
	 }
	echo"<tr><td>".$addhtml."</td><td><a href='charts.php?strategy=".$strategy."&instrument=".$instrument."'><i class='fa fa-bar-chart fa-2x'></i></a></td><td><div id='eachcurrencyboard'><h2>".str_replace("_4","",$instrument)."</h2></td><td><div id='eachcurrencyboard'><h2>".$strategy."</h2></div></td><td>".$profit."</td><td>".$profit_lm."</td><td>".$drawdown."</td><td>".$dd_lm."<td> ".$count."</td><td>".$winninperc."</td><td>".$tbx_score."</div></td></tr>";

}
echo"</table>";


if ($_ERROR==1)
{
 ### BLOCK PORTFOLIO

 $SQL="insert into blockportfolio values('".$login."','1')";
 mysql_query($SQL);
 echo mysql_error();

 ###

?>
<script>
document.getElementById("message").innerHTML="<div class='warning'><?php echo $message ?></div>";
</script>

<?php
}
include("end_db.php");
?>
<?php
include("tracking.php");
?>
</body>
</html>