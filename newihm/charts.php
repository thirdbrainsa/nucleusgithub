<?php
session_start();
global $login,$token,$additionnal;
require("strategyinfo.php");
if (isset($_SESSION['login']))
	{
		$login=$_SESSION['login'];
		if (isset($_SESSION['token']))
			{
				$token=$_SESSION['token'];
			}
	
	}
include("config.php");
global $month;
$month=intval(date("m"));
$year=date("Y");
if (isset($_GET['instrument']))
	{
		$instrument=strip_tags(trim($_GET['instrument']));
		$instrument=substr($instrument,0,10);
	
	}
	else
	{
	exit;
	
	}
if (isset($_GET['strategy']))
	{
		$strategy=strip_tags(trim($_GET['strategy']));
		$strategy=substr($strategy,0,20);
	
	}
	else
	{
	exit;
	
	}	
	
include ("connect_db.php");
$SQL="select profit,count,drawdown,winningperc,awt,alt,tbx_score from ranking where instrument='".$instrument."' AND strategy='".$strategy."'";
$R=mysql_query($SQL);
list ($profit,$count,$drawdown,$winningperc,$awt,$alt,$tbx_score)=mysql_fetch_array($R);
if ($drawdown!=0)
{
$RaR=abs(round($profit/$drawdown,2));
}
else
{
$RaR="N/A";
}
if ($profit<0) {$RaR=-1*$RaR;}

if ($alt!=0)
{
$hopeofwin=abs(round($awt/$alt,2));
}
else
{
$hopeofwin="N/A";

}

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
	
$SQL="select pips,drawdown,trades_win,trades_loose from datastats where month='".$month."' AND year='".$year."' AND instrument='".$instrument."' AND strategy='".$strategy."'";
//echo "<li>".$SQL;
$R=mysql_query($SQL);
list ($profit_lm,$dd_lm,$trade_w,$trade_l)=mysql_fetch_array($R);
if ($profit_lm=="") {$profit_lm="N/A";}
if ($dd_lm=="") {$dd_lm="N/A";}
$total_trades=$trade_w+$trade_l;

if ($total_trades<10) {$frequency="Low";}
if (($total_trades>9) && ($total_trades<30)) {$frequency="medium";}
if (($total_trades>29) && ($total_trades<90)) {$frequency="high";}
if ($total_trades>89) {$frequency="very high";}
if ($total_trades=="") {$frequency="N/A";}


$NOT_AVAILABLE=1;
if (strlen($login)!=32)
		{
		if (in_array($instrument,$_FX))
		 {	
			$NOT_AVAILABLE=0;
			$SSS="select id,lot,accountpwd from portofolio_dashboard where accountid='".$login."' and instrument='".$instrument."' and strategy='".$strategy."'";
		//echo "<li>".$SSS;
		
		$rrr=mysql_query($SSS);

	list($id_portfolio,$lot_size,$_password_inside)=mysql_fetch_array($rrr);
	if ($id_portfolio=="")
			{
			$porthtml="<div id='por_".$strategy.$instrument."'><a href=\"javascript:registerPortfolio('".$login."','".$token."','".$strategy."','".$instrument."');\"'><i class=\"fa fa-square-o fa-2x\"></i></a></div>";
			$porthtml.="<div id='lot_".$strategy.$instrument."'></div>";
			
			}
		else
			{
			$porthtml="<div id='por_".$strategy.$instrument."'><a href=\"javascript:removePortfolio('".$login."','".$token."','".$strategy."','".$instrument."');\"><i class=\"fa fa-check-square fa-2x\"></i></a></div>";
			$porthtml.="<div id='lot_".$strategy.$instrument."'></div>";
			}
		

		}
		}
		else
		{
		
		$NOT_AVAILABLE=1;
		}


include("end_db.php");
$addedtoadvice="";
?>
<!DOCTYPE HTML>
<html>

<head>
<title>Statistics of <?php echo strtoupper($strategy).' with '.str_replace("_4","",$instrument); ?></title>
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
	var balance=<?php echo getbackdata($dburl,$dblogin,$dbpass,$dbbase,$instrument,$strategy); ?>;

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
			text: "<?php echo "EQUITY CURVE OF ".strtoupper($strategy).' with '.str_replace("_4","",$instrument); ?>"
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
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56538817-3', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>
 <a href='index.php' class='large green button' > <i class="fa fa-arrow-left"></i></a>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<div id='ouradvice'></div>
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
<table width=100% border=0 cellpadding=0 cellspacing=0>
<caption><h1> STATISTICS  OF <?php echo $strategy." ".str_replace("_4","",$instrument); ?></h1></caption>
<tr>
<td>
 <div style="left" align=justify>
<?php 
if (isset($_S[$strategy]['kindstrategy']))
{
echo $_S[$strategy]['kindstrategy']; 
}
?>
</td>
<td valign=top align=justify>
<?php 
if (isset($_S[$strategy]['description']))
{
echo $_S[$strategy]['description']; 
}
?>
</td>
</tr>
<tr><td valign=top width=450>

<div id='gauge' style="float: left;">
<?php include ('gauge.php'); ?>
</div>
<div id="data">
 Winning Percentage : <?php echo $winningperc ?> % <br> 
 Average winning trade : <?php echo $awt ?> pips <br>
 Average loosing trade : <?php echo $alt ?> pips <br>
  Risk and Reward : <?php echo $RaR ?><br>
  Ratio AWT/ALT : <?php echo $hopeofwin ?>
</div>
<div id="data">
 
 Last month gain :<?php echo $profit_lm ?> pips <br>
 Last month drawdown :<?php echo $dd_lm ?> pips<br>
 Last month frequency of trades : <?php echo $frequency ?><br>  
 Add or Remove from portfolio :  
 <?php 
if (isset($_SESSION['login']))
{
 if ($NOT_AVAILABLE==0)
 {
 echo $porthtml;
 }
 else
 {
 echo "Not yet available with autotrading feature";
 }
 }
 else
 {
 echo "You are not logged";
 }
 // CORRELATION STUFF
 include("connect_db.php");
$S1="select id from advancedstats where instrument='".$instrument."' and strategy='".$strategy."'";
$S2="select id from advancedstats where instrument2='".$instrument."' and strategy2='".$strategy."'";
$R1=mysql_query($S1);
$R2=mysql_query($S2);
$html1="";$html2="";$total=0;
list ($id)=mysql_fetch_array($R1); 

if ($id!="") // instrument, strategy key//
{
$S3="select instrument2,strategy2,correlation from advancedstats where instrument='".$instrument."' and strategy='".$strategy."' and correlation>0 order by correlation desc limit 0,5"; // MORE CORRELATED ONES
$RR3=mysql_query($S3);
echo mysql_error();
while (list($instrument2,$strategy2,$correlation)=mysql_fetch_array($RR3))
	{
		$total++;
		$pc=round($correlation*100,2);
		$html1.="<tr><td><div id='por_".$strategy2.$instrument2."'><a href=\"javascript:registerPortfolio('".$login."','".$token."','".$strategy2."','".$instrument2."');\"'><i class=\"fa fa-square-o fa-1x\"></i></a></div>";
			$html1.="<div id='lot_".$strategy2.$instrument2."'></div></td>";
		$DD="select profit,drawdown from ranking where instrument='".$instrument2."' and strategy='".$strategy2."'";
		$K=mysql_query($DD);
		list($profitthis,$ddthis)=mysql_fetch_array($K);
	
		$html1.= "<td><a href='charts.php?instrument=".$instrument2."&strategy=".$strategy2."'>".$strategy2." ".$instrument2." ".$pc."</a> % <font size=-2>[".$profitthis.",".$ddthis." pips]</font> </td></tr>";
		
		
	}


$S3="select instrument2,strategy2,correlation from advancedstats where instrument='".$instrument."' and strategy='".$strategy."' and correlation<0 order by correlation asc limit 0,5"; // MORE CORRELATED ONES
$RR3=mysql_query($S3);

while (list($instrument2,$strategy2,$correlation)=mysql_fetch_array($RR3))
	{
		$total++;
		$pc=round($correlation*100,2);
		$html2.="<tr><td><div id='por_".$strategy2.$instrument2."'><a href=\"javascript:registerPortfolio('".$login."','".$token."','".$strategy2."','".$instrument2."');\"'><i class=\"fa fa-square-o fa-1x\"></i></a></div>";
		$html2.="<div id='lot_".$strategy2.$instrument2."'></div></td>";
		$DD="select profit,drawdown from ranking where instrument='".$instrument2."' and strategy='".$strategy2."'";
		$K=mysql_query($DD);
		list($profitthis,$ddthis)=mysql_fetch_array($K);
		$html2.="<td><a href='charts.php?instrument=".$instrument2."&strategy=".$strategy2."'>".$strategy2." ".$instrument2." ".$pc."</a> % <font size=-2>[".$profitthis.",".$ddthis." pips]</font> </td></tr>";
		if (abs($correlation)>70)
			{
			
			$addedtoadvice="Note this strategy ".$strategy2. "/".$instrument2. " can be associated to reduce risk of this strategy";
			}
			
	}

}


else
{ // instrument2, strategy2 key
$S3="select instrument,strategy,correlation from advancedstats where instrument2='".$instrument."' and strategy2='".$strategy."' and correlation>0 order by correlation desc limit 0,5"; // MORE CORRELATED ONES
$RR3=mysql_query($S3);

while (list($instrument2,$strategy2,$correlation)=mysql_fetch_array($RR3))
	{
		$total++;
		$pc=round($correlation*100,2);
			$DD="select profit,drawdown from ranking where instrument='".$instrument2."' and strategy='".$strategy2."'";
		$K=mysql_query($DD);
		list($profitthis,$ddthis)=mysql_fetch_array($K);
		$html1.="<tr><td><div id='por_".$strategy2.$instrument2."'><a href=\"javascript:registerPortfolio('".$login."','".$token."','".$strategy2."','".$instrument2."');\"'><i class=\"fa fa-square-o fa-1x\"></i></a></div>";
			$html1.="<div id='lot_".$strategy2.$instrument2."'></div></td>";
		$html1.="<td><a href='charts.php?instrument=".$instrument2."&strategy=".$strategy2."'>".$strategy2." ".$instrument2." ".$pc."</a> % <font size=-2>[".$profitthis.",".$ddthis." pips]</font> </td></tr>";
	}
$S3="select instrument,strategy,correlation from advancedstats where instrument2='".$instrument."' and strategy2='".$strategy."' and correlation<0 order by correlation asc limit 0,5"; // MORE CORRELATED ONES
$RR3=mysql_query($S3);

while (list($instrument2,$strategy2,$correlation)=mysql_fetch_array($RR3))
	{
		$total++;
		$pc=round($correlation*100,2);
			$DD="select profit,drawdown from ranking where instrument='".$instrument2."' and strategy='".$strategy2."'";
		$K=mysql_query($DD);
		list($profitthis,$ddthis)=mysql_fetch_array($K);
		$html2.="<tr><td><div id='por_".$strategy2.$instrument2."'><a href=\"javascript:registerPortfolio('".$login."','".$token."','".$strategy2."','".$instrument2."');\"'><i class=\"fa fa-square-o fa-1x\"></i></a></div>";
		$html2.="<div id='lot_".$strategy2.$instrument2."'></div></td>";
		$html2.="<td><a href='charts.php?instrument=".$instrument2."&strategy=".$strategy2."'>".$strategy2." ".$instrument2." ".$pc."</a> % <font size=-2>[".$profitthis.",".$ddthis." pips]</font> </td></tr>";
	}

}
if ($total<3) {$html2="<tr><td>NO ADVICES</td></tr>";$html1="<tr><td>NO ADVICES</td></tr>";}
echo"<table width=100% cellpadding=0 cellspacing=0 border=0>";
echo"<tr><td align=left><table><caption> NON CORRELATED WITH ".$strategy." ".str_replace("_4","",$instrument)." : </caption>".$html2."</table></td></tr><tr><td align=left><table><caption>CORRELATED WITH ".$strategy." ".str_replace("_4","",$instrument)." : </caption>".$html1."</table></td></tr>";
echo"</table>";
include("end_db.php");
?>
 
</div></td>
<td valign=top>
<?php
include("opinionaboutstrategy.php");
include("listeTradeStrategy.php");
?>
<script>
document.getElementById("ouradvice").innerHTML="<table><caption><h1>The ADVICE of our COO, Pierre Jean Duvivier</h2></caption><tr><td><img src='ouradvice.JPG'></td><td><h1><?php echo $advice ?></h1><a href='http://www.thirdbrainfx.com/go-beyond-financial-dashboard-go-live' class='large green button'>GO LIVE !</a></td></table>";
</script>
</td>
</tr>
</table>
<?php
include("tracking.php");
?>
</body>

</html>
