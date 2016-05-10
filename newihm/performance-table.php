<?php
include ("config.php");

//
if (isset($_GET['month']))
{
	$month=intval($_GET['month']);
	$year=intval($_GET['year']);
}
else
{
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
}
$hours=date("h");
if (isset($_GET['switch']))
	{
		$modifyurl="switch";
	}
	else
	{
	
		$modifyurl="";
	}

?>
<script src="js/sortable.js"></script>
<link rel="stylesheet" href="css/signal.css">
 <link rel="stylesheet" href="font/css/font-awesome.min.css">
<table class="sortable">
<?php
if (isset($_GET['include']))
{
	$addurl="?include";$addurl2="&include";$modifyf="inc";
}
else
{

	$addurl="";$addurl2="";$modifyf="";
}

$url_file="html/".$hours."-".$month."-".$year.$modifyurl.$modifyf.".html";

if (!(isset($_GET['switch'])))
{
?><CAPTION> <a href='index.php<?php echo $addurl ?>' class='large green button' > <i class="fa fa-arrow-left"></i></a> PERFORMANCES OF <strong> <?php echo strtoupper($mons[$month])." ".$year;?></strong> <a href='?switch=now<?php echo $addurl2 ?>'><?php echo strtoupper($mons[$month_today])." ".$year_today;?></a></CAPTION>
<tr><th> Trend </th><th> Instrument </th><th> Strategy </th><th>Profit</th><th> Max DD</th><th> Avg G</th><th>RaR</th><th>Win %</th><th> Trades</th><th> Tbx Score </th></tr>

<?php
}
else
{
?><CAPTION> <a href='index.php<?php echo $addurl ?>' class='large green button' > <i class="fa fa-arrow-left"></i></a><a href='performance-table.php<?php echo $addurl ?>'><?php echo strtoupper($mons[$month])." ".$year;?></a> PERFORMANCES OF <strong><?php echo strtoupper($mons[$month_today])." ".$year_today;?></strong></CAPTION>
<tr><th> Trend </th><th> Graph </th><th> Instrument </th><th> Strategy </th><th>Profit</th><th> Max DD</th><th> Avg G</th><th>RaR</th><th>Win %</th><th> Trades</th><th> Tbx Score </th></tr>

<?php
}
?>
<?php
$html="";
if (!(file_exists($url_file)))
{
include ("connect_db.php");

$SQL="select instrument,strategy,pips,drawdown,trades_win,trades_loose from datastats where month=".$month." AND year=".$year." AND strategy!='NONAME' order by pips desc";
$r=mysql_query($SQL);
while (list($instrument,$strategy,$pips,$drawdown,$tradesw,$tradesl)=mysql_fetch_array($r))
{
$tradeT=$tradesw+$tradesl;
$winT=intval(($tradesw/$tradeT)*100);
$SQL2="select profit,count,drawdown,winningperc,tbx_score from ranking where instrument='".$instrument."' and strategy='".$strategy."'";


//echo "<li>".$SQL2;
$RR=mysql_query($SQL2);
//echo mysql_error();
$RaRnow="-";
list ($nowp,$nowtrades,$nowdd,$nowin,$tbxscore)=mysql_fetch_array($RR);
if ($nowtrades>5)
{
$avg_trade_now=intval($nowp/$nowtrades);
$Compare=intval(($nowp/$nowtrades)*$tradeT);
if (abs($nowdd)>0)
	{
	$RaRnow=abs(($nowp/$nowdd));$RaRnow=round($RaRnow,2);
	
	}
}
else
{
$Compare="N/A";
}
if ($Compare!="N/A")
	{
	
		if ($Compare>$pips)
			{
			$wealth="<i class=\"fa fa-thumbs-up\"></i>";
			}
			else
			{
			$wealth="<i class=\"fa fa-thumbs-down\"></i>";
			
			}
	}
	else
	{
		$wealth="-";
	}
if ($tbxscore=="") {$tbxscore="-";}
$avg_trade=intval($pips/$tradeT);
if ($drawdown>0)
{
$RaR=($pips/$drawdown);$RaR=round($RaR,2);
}
else
{
$RaR="-";
}
if (!(isset($_GET['switch'])))
{
$html.="<tr><td><a href='?switch=now".$addurl2."'>".$wealth."</a></td><td>".$instrument."</td><td>".$strategy."</td><td>".$pips."</td><td>-".$drawdown."</td><td>".$avg_trade."</td><td>".$RaR."</td><td>".$winT."</td><td>".$tradeT."</td><td>".$tbxscore."</td></tr>";
}
else
{
$html.="<tr><td><a href='performance-table.php".$addurl."'>".$wealth."</a></td><td><a href='charts.php?instrument=".$instrument."&strategy=".$strategy."' target=_".$strategy.$instrument."><i class='fa fa-bar-chart'></i></a></td><td>".$instrument."</td><td>".$strategy."</td><td>".$nowp."</td><td>".$nowdd."</td><td>".$avg_trade_now."</td><td>".$RaRnow."</td><td>".$nowin."</td><td>".$nowtrades."</td><td>".$tbxscore."</td>";
}
}


include("end_db.php");
}
else
{
$html=file_get_contents($url_file);
}


echo $html;
echo "</table>";
/*
$file=fopen($url_file,"w");
fputs($file,$html);
fclose($file);
*/
if (!(isset($_GET['include'])))
{
include ("tracking.php");
}
else
{
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56538817-3', 'auto');
  ga('send', 'pageview');

</script>
<?php } ?>


