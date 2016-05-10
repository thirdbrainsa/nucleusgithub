<?php
session_start();include("librairies/manage.php");
include("config.php");
include("connect_db.php");


if (isset($_GET['id']))
	{
		$id=intval($_GET['id']);
		$R="select symbol,description from instrumentdb where id=".$id;
		//echo"<li>".$R;
		$RR=mysql_query($R);
		list($symbol,$description)=mysql_fetch_array($RR);
		echo mysql_error();
		
	}else{
	
	include("end_db.php");
	exit;
	
	}
?>
<!DOCTYPE HTML>
<html>

<head>
<title>Statistics of <?php echo strtoupper($symbol).' | '.$description; ?></title>
<meta name="description" content="ThirdBrainFx has been operating since 2010 and is a software application designed to buy and sell foreign currencies automatically.This software is made up of multiple programmes called strategies, each of which is independent of the others, and which are essentially based on mathematical algorithms.">
<meta name="keywords" content="mirror trading, social trading, trading, forex, automated forex strategies, forex strategies, forex account, broker">
<meta name="author" content="ThirdBrain SA">
 <script type="text/javascript" src="js/manage.js?time=<?php echo time() ?>"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.canvasjs.min.js"></script>
<link type="text/css" rel="stylesheet" href="css/box.css">
 <link rel="stylesheet" href="font/css/font-awesome.min.css">
 <link type="text/css" rel="stylesheet" href="css/result-compute.css">
   <link type="text/css" rel="stylesheet" href="css/signal.css">
      <link type="text/css" rel="stylesheet" href="css/table.css">
      <script src="js/sortable.js"></script>

<script type="text/javascript">
$(function () {
	
	var y = 0;
	var data = [];
	var dataSeries = { type: "line" };
	var dataPoints = [];
	var balance=<?php echo getbackdataInstrument($id); ?>;

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
			text: "Charts <?php echo $symbol.'|'.$description ?>"
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
</head>
<body>
 <a href='nucleus.php' class='large green button' > <i class="fa fa-arrow-left"></i></a>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>

<?php
include("end_db.php");
include("tracking.php");
?>
</body>

</html>
