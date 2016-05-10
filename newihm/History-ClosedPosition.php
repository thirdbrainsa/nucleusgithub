<link rel="stylesheet" href="css/signal.css">
<link type="text/css" rel="stylesheet" href="css/box.css">
 <link type="text/css" rel="stylesheet" href="css/table.css">
 <link rel="stylesheet" href="font/css/font-awesome.min.css">
<?php
include ("config.php");
include ("connect_db.php");
$SQL="select instrument,strategy,whenopen,profit,count,dayprofit,drawdown,winningperc,awt,alt,tbx_score from ranking order by tbx_score desc,profit desc";
$R=mysql_query($SQL);
echo mysql_error();

while (list($instrument,$strategy,$whenopen,$profit,$count,$dayprofit,$drawdown,$winninperc,$awt,$alt,$tbx_score)=mysql_fetch_array($R))
{
	$SS="select SUM(profit), COUNT(id) from tradedb where instrument='".$instrument."' AND strategy='".$strategy."' and digit!=99";
   	$Q=mysql_query($SS,$mysql);
	list ($sumprofit,$traderunning)=mysql_fetch_array($Q);
	
	echo"<div id='eachcurrency' style='float: left;'><h2>".$instrument."</h2><h3><a href='http://www.thirdbrainfx.com/search/node/".$strategy."' target=_".$strategy."><font color=orange>".$strategy."</font></a></h3><br><b>Profit</b>: ".$profit." pips<br> <b>MaxDD</b> : ".$drawdown." pips <br><b>Trades</b>: ".$count." trades<br>".$winninperc." %<br><b>Run. Pos :</b>".intval($sumprofit)." pips<br><b>TBX Score</b>: ".$tbx_score."</div>";

}

include("end_db.php");
include("menu.php");
include("tracking.php");
?>