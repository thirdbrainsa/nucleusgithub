 <?php
 session_start();
 include("config.php");
set_time_limit(0);
if (isset($_SESSION['login'])) {$login=$_SESSION['login'];}
 ?>
 <title> History of the account |  Forex professional signals with ThirdBrainFx since 2010</title>
<meta name="description" content="ThirdBrainFx has been operating since 2010 and is a software application designed to buy and sell foreign currencies automatically.This software is made up of multiple programmes called strategies, each of which is independent of the others, and which are essentially based on mathematical algorithms.">
<meta name="keywords" content="mirror trading, social trading, trading, forex, automated forex strategies, forex strategies, forex account, broker">
<meta name="author" content="ThirdBrain SA">
<link rel="stylesheet" href="css/signal.css?<?php echo time();?>">
<link type="text/css" rel="stylesheet" href="css/box.css">
 <link type="text/css" rel="stylesheet" href="css/table.css">
 <link rel="stylesheet" href="font/css/font-awesome.min.css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.canvasjs.min.js"></script>
<script type="text/javascript" src="js/manage.js?time=<?php echo time() ?>"></script>
<script type="text/javascript">
$(function () {
	
	var y = 0;
	var data = [];
	var dataSeries = { type: "line" };
	var dataPoints = [];
	var balance=<?php echo getbackTradeHistory($dburl,$dblogin,$dbpass,$dbbase,$login); ?>;

	var limit = balance.length;    //increase number of dataPoints by increasing the limit
	for (var i = 0; i < limit; i += 1) {
		y = parseInt(balance[i]);
	
		//alert(balance[i]);
		dataPoints.push({
			x: i,
			y: y
		});
	}
	dataSeries.dataPoints = dataPoints;
	data.push(dataSeries);

	//Better to construct options first and then pass it as a parameter
	var options = {
		zoomEnabled: true,
                animationEnabled: true,
		title: {
			text: "<?php echo "BALANCE HISTORY OF ACCOUNT ".strtoupper($login); ?>"
		},
		axisX: {
			labelAngle: 30
		},
		axisY: {
			includeZero: false
		},
		data: data  // random data
	};

	$("#chartContainer").CanvasJSChart(options);

});
</script>
<?php


if (isset($_SESSION['login']))
	{
	
		$login=$_SESSION['login'];
		$ip=$_SERVER['REMOTE_ADDR'];
		include("config.php");
		include("connect_db.php");
		$RT="select token from temp_login where login='".$login."' and ip='".$ip."'";
		$RTT=mysql_query($RT);
		echo mysql_error();
		list($token)=mysql_fetch_array($RTT);
		include("end_db.php");
		}

include('menulistTradeHistory.php');
?>
<div id='balance'></div>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<div id='tradeglobal'><img src='img/ajax-loader.gif'></div>

<script>
setInterval(function(){ listHysTrade('<?php echo $login;?>'); },1000);
</script>
<script>
setInterval(function(){ balanceRefresh('<?php echo $token;?>'); } , 1000);
</script>
<?php
if (isset($_SESSION['xapi']))
{
if (strlen($login)==6)
{
?>
<div> You can check the history of your trade directly on your trading account by going here : <a href='https://xs.xopenhub.pro/thirdbrainfx/demo/'>https://xs.xopenhub.pro/thirdbrainfx/demo/</a> and login with your credentials</div>
<?php
}
else
{
?>
<div> You can check the history of your trade directly on your trading account by going here : <a href='https://xs.xopenhub.pro/thirdbrainfx/real/'>https://xs.xopenhub.pro/thirdbrainfx/real/</a></div>
<?php
}
?>
<iframe src='fighterfx/proxyHistory.php' width=0 height=0></iframe> 

<?php
}
include("tracking.php");
?>