<link rel="stylesheet" href="css/signal.css">
<link type="text/css" rel="stylesheet" href="css/box.css">
 <link type="text/css" rel="stylesheet" href="css/table.css">
 <link rel="stylesheet" href="font/css/font-awesome.min.css">
<?php
include ("config.php");
include ("connect_db.php");
$SQL="select instrument,strategy,whenopen,profit,count,dayprofit,drawdown,winningperc,awt,alt,tbx_score from ranking_month order by tbx_score desc,profit desc";
$R=mysql_query($SQL);
echo mysql_error();
$timing=time()-7*24*60*60;
while (list($instrument,$strategy,$whenopen,$profit,$count,$dayprofit,$drawdown,$winninperc,$awt,$alt,$tbx_score)=mysql_fetch_array($R))
{
	$instrument=strtolower($instrument);
	$SS="select COUNT(id),SUM(profit), COUNT(id) from tradedb where instrument='".$instrument."' AND strategy='".$strategy."' and digit!=99";
   	$Q=mysql_query($SS,$mysql);
	list ($nbclosed,$sumprofit,$traderunning)=mysql_fetch_array($Q);
		if ($nbclosed>0)
			{
				
				$_CHECKIN[$strategy][$instrument]["open"]=$nbclosed;
				
			}
			
	$SS="select COUNT(id),SUM(profit), COUNT(id) from historydb where instrument='".$instrument."' AND strategy='".$strategy."' and timeinsert>".$timing;
	$Q=mysql_query($SS,$mysql);
	list ($nbclosed,$sumprofit,$traderunning)=mysql_fetch_array($Q);
		if ($nbclosed>0)
			{
				
				$_CHECKIN[$strategy][$instrument]["closed"]=$nbclosed;
				
			}	
	$_WHENOPEN[$strategy][$instrument]=$whenopen;	
	#echo"<div id='eachcurrency' style='float: left;'><h2>".$instrument."</h2><h3><a href='http://www.thirdbrainfx.com/search/node/".$strategy."' target=_".$strategy."><font color=orange>".$strategy."</font></a></h3><br><b>Profit</b>: ".$profit." pips<br> <b>MaxDD</b> : ".$drawdown." pips <br><b>Trades</b>: ".$count." trades<br>".$winninperc." %<br><b>Run. Pos :</b>".intval($sumprofit)." pips<br><b>TBX Score</b>: ".$tbx_score."</div>";

}
//print_r($_CHECKIN);
//print_r($_TOCHECK_TRADENCY);
echo"<table border=1>";
echo"<caption> NUMBER OF TRADES CLOSED/OPENED + FREQUENCY OF TOP TRADENCY STRATEGIES FOR THE LAST 7 DAYS </caption>";
echo"<thead>";
echo"<th>Strategy</th><th> Instrument </th><th> Status </th><th>Activity (open/closed)</th><th> Last check </th>";
echo"</thead>";
foreach ($_TOCHECK_TRADENCY as $key => $data)
{
	foreach ($data as $strategy => $instrument)
	{
	echo "<tr><td>".$strategy."</td><td>".$instrument."</td>";
	
	if (isset($_CHECKIN[$strategy][$instrument]))
	{
	if (!(isset($_CHECKIN[$strategy][$instrument]["open"]))) { $_CHECKIN[$strategy][$instrument]["open"]=0;}
	if (!(isset($_CHECKIN[$strategy][$instrument]["closed"]))) { $_CHECKIN[$strategy][$instrument]["closed"]=0;}
		$nb=$_CHECKIN[$strategy][$instrument]["open"]+$_CHECKIN[$strategy][$instrument]["closed"];
		$frequency=$nb/7;
		
		if  ($frequency > 1)
		{
			if ($frequency <  12 )
				{
				echo " <td><font color=green><b> OK </font></td><td>".$nb."</td>";
				}
				else
				{
				
				echo " <td><font color=orange><b> HIGH FREQUENCY  </font></td><td>".$nb."</td>";
				
				}
		}
		else
		{
		echo " <td><font color=orange><b> LOW FREQUENCY </font></td><td>".$nb."</td>";
		
		}
	}
	else
	{	if (in_array($strategy,$_MONITORED))
	{
		echo "<td colspan=2><font color=red><b> ALERT . NO TRADES OPENED</font></td>";
		
	}
	else
	{
	echo "<td colspan=2><font color=red><b> NOT MONITORED YET </font></td>";
	}
	}
	if (isset($_WHENOPEN[$strategy][$instrument])) {echo "<td>".$_WHENOPEN[$strategy][$instrument]."</td>";}
	else
	{
	echo "<td>-</td>";
	}
	echo"</tr>";
	}
}
echo"</table>";
include("end_db.php");
#include("menu.php");
include("tracking.php");
?>
<meta http-equiv="refresh" content="3600">