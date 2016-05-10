 <title> Trade Management | Forex professional signals with ThirdBrainFx since 2010</title>
<meta name="description" content="ThirdBrainFx has been operating since 2010 and is a software application designed to buy and sell foreign currencies automatically.This software is made up of multiple programmes called strategies, each of which is independent of the others, and which are essentially based on mathematical algorithms.">
<meta name="keywords" content="mirror trading, social trading, trading, forex, automated forex strategies, forex strategies, forex account, broker">
<meta name="author" content="ThirdBrain SA">
<link rel="stylesheet" href="css/signal.css?<?php echo time();?>">
<link type="text/css" rel="stylesheet" href="css/box.css">
 <link type="text/css" rel="stylesheet" href="css/table.css">
 <link rel="stylesheet" href="font/css/font-awesome.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="js/manage.js?time=<?php echo time() ?>"></script>
    <script type="text/javascript" src="fighterfx/js/xAPI-live-2.js?time=<?php echo time() ?>"></script> 
<?php
session_start();
if (isset($_SESSION['login']))
	{
	
		$login=$_SESSION['login'];
		$token=$_SESSION['token'];
	}
set_time_limit(0);
include('menulistTradeHistory.php');
?>
<div id='balance'></div>
<div id='status'></div>
<div id='tradeglobal'><img src='img/ajax-loader.gif'></div>
<script>
setInterval(function(){ listDynTrade('<?php echo $token;?>'); },1000);
</script>
<script>
setInterval(function(){ balanceRefresh('<?php echo $token;?>'); } , 1000);
</script>
<?php
include("tracking.php");

?>
<iframe src='fighterfx/proxyTrade.php' width=0 height=0></iframe>
