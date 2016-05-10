 <!DOCTYPE html>
<html>
 <head>
 <meta charset="UTF-8">
 <title> Forex professional signals with ThirdBrainFx since 2010</title>
<meta name="description" content="ThirdBrainFx has been operating since 2010 and is a software application designed to buy and sell foreign currencies automatically.This software is made up of multiple programmes called strategies, each of which is independent of the others, and which are essentially based on mathematical algorithms.">
<meta name="keywords" content="mirror trading, social trading, trading, forex, automated forex strategies, forex strategies, forex account, broker">
<meta name="author" content="ThirdBrain SA">

 <?php
 session_start();
 if (isset($_SESSION['partner']))
 {
 header("location:iframe.php?partner=".$_SESSION['partner']);
 
 }
 global $balance;
 $_SESSION['form']=1;
 $token=0;$message="";
 include("config.php");

if (isset($_SESSION['login']))
{
	include("connect_db.php");
	$S="select account from abook where account='".$_SESSION['login']."'";
	$SS=mysql_query($S);
	list($account)=mysql_fetch_array($SS);
	if ($account!="") {$_SESSION['xapi']=1;}
	include("end_db.php");
}
if (isset($_GET['balance']))
 {
	$balance=strip_tags(trim($_GET['balance']));
	$_SESSION['balance']=intval($balance);
	//print_r($_SERVER);
 }
 else
 {
	//$_SESSION['balance']=50000;
	
	include("connect_db.php");
	if (isset($_SESSION['login']))
	{
	$L="select balance from balance where account='".$_SESSION['login']."'";
	$LL=mysql_query($L);
	list($balance)=mysql_fetch_array($LL);
	}
	if ($balance!="")
		{
			$_SESSION['balance']=$balance;
		
		}
		else
		{
		
			$_SESSION['balance']=50000;
		
		}
	
	include("end_db.php");
 }
 
 if ($_SENDCOMMAND==1)
 {
 ?>
 <link type="text/css" rel="stylesheet" href="css/message.css">
 <link rel="stylesheet" href="css/onoff2.css">
 <?php
 //print_r($_POST);
 
 if (isset($_GET['userID']))
	{
		if ($_GET['userID']=="XXX")
			{
					session_unset() ;
			}
	}
 if (isset($_POST['login']))
 {
 
$login=intval(strip_tags(trim($_POST['login'])));
$valid_login=0;
if ($login==0)
	{
		$message="<div class='warning'> Your login is not a valid login, please enter a valid login. <a href='?userID=XXX'> Go back and login again</a></div>";
		
		$valid_login=1;
	}
 $_SESSION['login']=$login;
 //echo "<li>".$login;
 $_SESSION['password']=strip_tags(trim($_POST['password']));
 
 
 
 if ($valid_login==0)
 {
		$time=time()+microtime();
		$login=$_SESSION['login'];
		$password=$_SESSION['password'];
		$token=md5($time.$login.$password."ifjiewjfiwejkfwekjfkwejfkjmxmx,nm");
		$_SESSION['token']=$token;
		include("config.php");
		include("connect_db.php");
		$SQL2="delete from temp_login where login='".$login."'";
		mysql_query($SQL2);
		$ip=$_SERVER['REMOTE_ADDR'];
		$SQL="insert into temp_login values('','".$token."','".$login."','".$password."','0.01','".$ip."',NOW())";
		mysql_query($SQL,$mysql);
		include("end_db.php");
		$message= "<div class='success'><i class=\'fa fa-lock\'></i> The trade will be sent now to the account : ".$_POST['login']. " if the password is correct, with <a href='?changelot'>default lot size : 0.01 </a>,<a href='logout.php'><i class=\'fa fa-sign-out\'></i> logout</a>";
		$message.="</div>";
 }
 }
 else
 {
 if ( (!(isset($_SESSION['login']))) || strlen($_SESSION['login'])==32 )
 {
		if (isset($_GET['userID'])) 
		{ 
		$userID=strip_tags(trim($_GET['userID']));
		if ($userID=="XXX")
		{
		$message= "<div class='warning'> You are not log in with any account - you need to have a valid credential login and password to send this order to a trading account.";
		$userID="Please provide a valid account";
		}
		else
		{
		$message="<div class='info'> You need to give the password linked to your account you want to send this trade, you need only to do one time for this session. Becarefull we won't validate your credential. What is the password for ".$userID. " ?";
		}
		
$message.="<form method=POST action='".$_URL_LOGIN."/index-login-dashboard.php'><i class=\'fa fa-unlock\'></i> <input type=\'text\' name=\'login\' value=\'Your account ID\'>  Password : <input type=\'password\' name=\'password\'><input type='submit'></form>";
$message.="</div>";
		} 
}
else
{
if (isset($_SESSION['password']))
{
?>

<?php

		$time=time()+microtime();
		$login=$_SESSION['login'];
		$password=$_SESSION['password'];
		include("connect_db.php");
		// IF PASSWORD HAVE CHANGED WE UPDATE ALL
	
		$token=md5($time.$login.$password."ifjiewjfiwejkfwekjfkwejfkjmxmx,nm");
		$_SESSION['token']=$token;
	    
		include("connect_db.php");
		$ip=$_SERVER['REMOTE_ADDR'];
		$SQL2="delete from temp_login where login='".$login."'";
		mysql_query($SQL2);
	
		$SQL="insert into temp_login values('','".$token."','".$login."','".$password."','0.01','".$ip."',NOW())";
		mysql_query($SQL,$mysql);
		
		$SQL="select id from clientdata where accountid='".$login."'";
		//echo "<li>".$SQL;
		$RR=mysql_query($SQL);
		echo mysql_error();
		list ($id_cd)=mysql_fetch_array($RR);
	
		if (isset($_GET['xapi']))
		{
		if ($id_cd=="")
			{
						$SQLi="insert into clientdata values('','xAPIlogin','".$login."','".$password."','1','','')";
						mysql_query($SQLi);
						
						$SQLi="insert into balance values('".$login."','".$balance."',NOW())";
						mysql_query($SQLi);
			}
			else
			{
						$SQLi="update clientdata set accountpwd='".$password."' where id=".$id_cd;
						mysql_query($SQLi);
						//echo mysql_Error();
						$SQLi="update balance set balance='".$balance."' where account='".$login."'";
						mysql_query($SQLi);
						//echo mysql_error();
						$SQLi="update portofolio_dashboard set accountpwd='".$password."' where accountid='".$login."'";
						mysql_query($SQLi);
						//echo mysql_error();
			
			}
		}
		
		//echo mysql_error();
		include("end_db.php");
		$message= "<div class='success'><i class=\'fa fa-lock\'> The trade will be sent to the account : ".$_SESSION['login']. ""; 
		
		if (isset($_POST['lotsize']))
		{
			
		include("config.php");
		include("connect_db.php");
		$lotsize=strip_tags(trim($_POST['lotsize']));
		$SQL_LOT="update temp_login set lotsize=".$lotsize." where token='".$token."' and login='".$login."'";
		mysql_query($SQL_LOT);
		$RZ="select id from temp_login where token='".$token."' and login='".$login."'";
		$RZ1=mysql_query($RZ);
		list ($id)=mysql_fetch_array($RZ1);
		if ($id!="")
			{
				$RZZ="update automated set automated='".$lotsize."' where account='".$login."'";
				mysql_query($RZZ);
				
			}
		//echo "<li>".$SQL_LOT;
		//echo mysql_error();
		include("end_db.php");
				$message.=" with <a href='?changelot'>default lot size : ".$lotsize." </a>";
		}
		else
		{
		if (isset($_GET['changelot']))
			{
			$message.="<form method=POST>Changing the lot size by default <input type=\'text\' name=\'lotsize\' value=\'Enter a lot size\'><input type='submit'></form>";

			
			}
			else
			{
			$message.=" with <a href='?changelot'>default lot size :0.01 </a>";
			}
		}
		$message.=",<a href='logout.php'><i class=\'fa fa-sign-out\'></i> logout</a>";
		$message.="</div>";
}
}
}

if ($message=="")
 {
 if (!(isset($_GET['include'])))
 {
 $message="<a href='login-demo-dashboard.php' class='large green button'><i class=\'fa fa-unlock\'></i> CONNECT TRADING ACCOUNT</a> <a href='portfolio-management.php' class='large green button'><i class=\'fa fa-bar-chart\'></i> PERFORMANCES</a> <a href='http://www.thirdbrainfx.com/go-beyond-financial-dashboard-go-live' class='large green button'><i class=\'fa fa-desktop\'></i> SIGN UP</a><a href='http://www.thirdbrainfx.com/products' class='large green button' target=_blank><i class=\'fa fa-share-square-o\'></i> HOW TO COPY THE TRADES ? </a>"; 
 }
 else
 {
 $message="<a href='login-demo-dashboard.php?include' class='large green button'><i class=\'fa fa-unlock\'></i> CONNECT TRADING ACCOUNT</a> <a href='performance-table.php?include' class='large green button'><i class=\'fa fa-bar-chart\'></i> PERFORMANCES</a> <a href='http://www.thirdbrainfx.com/open-demo-account-thirdbrainfx-1' class='large green button'><i class=\'fa fa-desktop\'></i> CREATE DEMO</a><a href='http://www.thirdbrainfx.com/products' class='large green button' target=_blank><i class=\'fa fa-share-square-o\'></i> HOW TO COPY THE TRADES ? </a>"; 
  
 }
 }
  
}


?>
<link rel="stylesheet" href="css/pure.css">
<link rel="stylesheet" href="css/signal.css">
<link type="text/css" rel="stylesheet" href="css/box.css">
 <link type="text/css" rel="stylesheet" href="css/table.css">
 <link rel="stylesheet" href="font/css/font-awesome.min.css">
 <script src="js/jquery.js"></script>
<script type="text/javascript" src="js/manage.js?time=<?php echo time() ?>"></script>

<script type="text/javascript">
    window.smartlook||(function(d) {
    var o=smartlook=function(){ o.api.push(arguments)},s=d.getElementsByTagName('script')[0];
    var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
    c.charset='utf-8';c.src='//rec.getsmartlook.com/bundle.js';s.parentNode.insertBefore(c,s);
    })(document);
    smartlook('init', '6cb4a233bd673059ac949115cc6127ffeaa6d730');
</script>
</head>
<body>

 <table width=960 border=0 cellpadding=0 cellspacing=0>
 <thead>
 <th>LAST 6 TRADES OPENED BY OURS ROBO-ADVISORS</th>
 <th>LAST 6 TRADES CLOSED BY OURS ROBO-ADVISORS</th>
 </thead>
 
 <?php
 if (!(isset($_SESSION['password'])))
{
?>
<tr>
<td colspan=2>
<?php 
/*
if (!(isset($_SESSION['firstime'])))
{
?>
<form class="pure-form" method="post" class="af-form-wrapper" accept-charset="UTF-8" action="https://www.aweber.com/scripts/addlead.pl" target="_new" >
    <fieldset>
        <legend>Discover how to connect your trading account, use it and make money with our forex and cfd signals</legend>
<input type="hidden" name="meta_web_form_id" value="2063142284" />
<input type="hidden" name="meta_split_id" value="" />
<input type="hidden" name="listname" value="mirrortrader" />
<input type="hidden" name="redirect" value="https://www.aweber.com/thankyou-coi.htm?m=video" id="redirect_48772dcafc584d3de9447cfe65ca1950" />
<input type="hidden" name="meta_adtracking" value="Simple-Form-Landing.php" />
<input type="hidden" name="meta_message" value="1" />
<input type="hidden" name="meta_required" value="email" />
<input type="hidden" name="meta_tooltip" value="email||Your email" />
        <input id="awf_field-80853112" type="email" name="email" placeholder="Give a valid email and follow instructions" size=50>
        <button type="submit" class="pure-button pure-button-primary"> YES ! Send me now informations about your offer </button>
	<legend>Since 2011, we built the best forex  strategies, up to 10'000 pips by year with minimal drawdown</legend>
    </fieldset>
</form>
<?php
}
$_SESSION['firstime']=1;
*/
?>
<div id='boxglobalinfo'>
</div>

</td>
</tr>

<?php
}
else
{
##< COMPUTE THE STATES OF TOP TRADING
include("connect_db.php");
$XX="select account,automated from nucleus where account='".$login."'";
//echo"<li>".$XX;
$RX=mysql_query($XX);
echo mysql_error();
list($accountXX,$lot_auto)=mysql_fetch_array($RX);
$PP="select count(id) from portofolio_dashboard where accountid='".$login."'";
$PPP=mysql_query($PP);
echo mysql_error();
list($IDT)=mysql_fetch_array($PPP);

if ($IDT==0)
	{
	$G="select account from nucleus where account='".$login."'";
	$GG=mysql_query($G);
	list($ar)=mysql_fetch_array($GG);
	if ($ar=="")
	{
	?>
	<h1> SELECT NOW A PORTFOLIO, WE CAN  SELECT FOR YOU BY GOING TO <a href='nucleus.php'> PORTOFOLIO </a></h1>
	<?php
	}
	}
include("end_db.php");
if ($accountXX=="")
	{
		$state="";
		$changebutton=0;
	}
	else
	{
		$changebutton=1;
		$state="checked";
		
	}

###
?>
<tr>

<td>
<?php
if (isset($_SESSION['login']))
{

?>
<table width=100% cellpadding=0 cellspacing=0>

<tr>
<td>
<table width=100%>
<tr>
<td>
<div class="onoffswitch">
    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" onClick="changeAutoNucleus('<?php echo $token ?>');" <?php echo $state ?>>
    <label class="onoffswitch-label" for="myonoffswitch" >
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>
</table></td>
<td>
<?php 
if ($changebutton!=1)
{
?>
<a href='nucleus.php' class='large green button'><i class="fa fa-university"></i> MANAGE PORTFOLIO </a>
<?php
}
else
{
?>
<a href='nucleus.php' class='large green button'><i class="fa fa-university"></i> SETUP GOALS </a>
<?php
}
?>
</td>


</tr>
</table>
</td>

<td valign=middle><a href='portfolio-management.php' class='large green button'><i class="fa fa-cogs"></i>  PERFORMANCES </a> <a href='TradeManagement.php' class='large green button'><i class='fa fa-angle-double-up'></i>  TRADES & HISTORY</a>

</td>
</tr>


<!--<a href='TradeManagement.php?token=<?php echo $token ?>' class="large green button"> <i class="fa fa-database"></i> Manage Trades </a>-->
<?php
}
?>
</td></tr>

<?php
}
?>
<tr>
<td colspan=2>
<div id='classinstrument'></div>
</td>


 <tr>
  <td valign=top witdh=480 halign=left>
<div id='activesignal'>
<?php if (!(isset($_GET['onlyClose']))) {
echo "<img src='img/ajax-loader.gif'>";
}?>
<?php if (!(isset($_GET['onlyClose']))) { ?>
<script>
setInterval(function(){ startRefresh('<?php echo $token;?>'); } , 1000);
</script>
<?php 

} ?>
</div>
</td>
<td valign=top witdh=480 halign=left>
<div id='historysignal'>
<?php if (!(isset($_GET['onlyActive']))) {
echo "<img src='img/ajax-loader.gif'>";
}?>
<script>
<?php if (!(isset($_GET['onlyActive']))) { ?>
setInterval(function(){ startRefreshHistory('<?php echo $token;?>'); } , 1000);
<?php
 } 
?>
</script>
</div>
</td></tr>
<tr>
<td colspan=2>

<?php 
if (isset($_SESSION['login']))
{
if ($changebutton==1)
{
?>
	<div id='meter'></div>
	<script>setInterval(function(){ loadMeter('<?php echo $login;?>'); } , 5000);</script>
<?php
}
}
?>
</td>
</tr>
<?php
if (isset($_SESSION['password']))
{
?>
<tr>
<td colspan=2>

<div id='boxglobalinfo'>
</div>
</td>
</tr>
<?php
}
?>

<tr>
<td> <a href='thirdbrainfx.php' class='large green button'>SWITCH TO 3D VIEW</a></td>
<td> <a href='thirdbrainfx-closed.php' class='large green button'>SWITCH TO 3D VIEW</a></td>
</tr>
<tr>
<td colspan=2><a href='http://www.thirdbrainfx.com/platform-tour-financial-dashboard-and-nucleus' class='large green button'>HELP - CLICK HERE TO DO A PLATFORM TOUR </a></td>
</tr>
<tr>
<td colspan=2>
<div id='balance'></div>
</td>
</tr>
  <tr>
<td colspan=2>
<div id='datainfo'>
</div>
</td>
</tr>

<tr>
<td colspan=2>
<table border=0 cellpadding=0 cellspacing=0>
<caption><h1><strong>Forex signals are available for automated trading with FXCM and FXDD</strong></h1></caption>
<tr>
<td>
<a href='http://www.thirdbrainfx.com/go-live-fxcm-fxdd-and-thirdbrainfx-inside-mirror-trader-premium-zone' target=_new><img src='img/fxcm.JPG' style="vertical-align:middle"></a>
</td>
<td valign=middle align=justify>
<a href='http://www.thirdbrainfx.com/go-live-fxcm-fxdd-and-thirdbrainfx-inside-mirror-trader-premium-zone' class='large green button'> USE MY FXCM or FXDD ACCOUNT TO GET THE SIGNALS - CHECK CONDITIONS</a><br><i><font size=-1>Be aware that with FXCM, FXDD, you get the Forex Signals and some CFD's one but not all the signals presents in the financial dashboard like the Equities CFD</i></td>
</tr>
</table>
</td>
</tr>

</tr>

<tr>
<td colspan=2 align=center>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Resizable ADS -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-5349092563133123"
     data-ad-slot="9075027299"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</td>
</tr>
<tr>
<td colspan=2>
<table broder=0 cellpadding=0 cellspacing=0>
<tr>
<td valign=middle align=justify>

<center><a href='http://www.thirdbrainfx.com/about-us'><img src='thirdbrainfx.gif' width=280></a></center><br>
<strong>Tel : +41 22 534 90 24 ,  skype : support.thirdbrainsa,  email us: <a href="mailto:support@thirdbrain.ch">support@thirdbrain.ch</a></strong>
<br><br>
ThirdBrainFx has been operating since 2010 and is a software application designed to buy and sell foreign currencies and financial instrument automatically . This software is made up of multiple programmes called <strong>robo-advisor</strong>, each of which is independent of the others, and which are essentially based on mathematical algorithms. Robo-advisors will in 2020 manage US $255bn of Assets worldwide.
Our <strong> Robo-Advisors </strong> are based on several years of development on man-machine interfaces designed to reproduce the behaviour of a human trader, our aim is to understand the motivations of leading traders to take advantage of the remarkable opportunities available in the foreign and stock exchange market. This is the biggest market in the world, with trillions of dollars traded every day. Our(s) software(s) are designed to give you a small place at that table and help your savings grow with rates of return that you will never get from your bank, even though it uses YOUR money to carry out the same foreign exchange transactions every day.
We are confident that one of our products will match your risk profile and financial requirements.
<div align=left>
<ul class="social-bookmarks">
<li class="youtube last">
<a href="https://www.youtube.com/user/thirdbrainfx">Youtube</a>
</li>
<li class="facebook first">
<a href="http://www.facebook.com/thirdbrainfx">Facebook</a>
</li>
<li class="twitter">
<a href="http://twitter.com/thirdbrainfx">Twitter</a>
</li>
<li class="linkedin">
<a href="http://www.linkedin.com/company/2807982">Linkedin</a>
</li>
</ul>
</td>
</tr>

</table>
</td>
</tr>
</table>
<?php
if (isset($_SESSION['password']))
{
?>
<script>
setInterval(function(){ balanceRefresh('<?php echo $token;?>'); } , 1000);
setInterval(function(){ infoTrade('<?php echo $login;?>'); }, 1000);

</script>

<?php
}
?>
<script>
setInterval(function(){ classInstrument(); }, 5000);
</script>
<script>
document.getElementById('boxglobalinfo').innerHTML="<?php echo $message ?>";
</script>
<?php
if (!(isset($_GET['include'])))
{
include("tracking.php");
}
if (isset($_SESSION['xapi']))
{

?>
<iframe src='fighterfx/proxyTrade.php' width=0 height=0></iframe>

<?php
}
?>
</body>
</html>