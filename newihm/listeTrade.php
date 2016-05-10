<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include("config.php");
global $clearedProfit,$rightPrice,$basepips;
set_time_limit(0);
if (isset($_SESSION['login']))
{
include("connect_db.php");
$ip=$_SERVER['REMOTE_ADDR'];
$login=$_SESSION['login'];
$RT="select token from temp_login where login='".$login."' and ip='".$ip."'";
$RTT=mysql_query($RT);
echo mysql_error();
list($token)=mysql_fetch_array($RTT);
}
else
{
echo"You are not logged, please log...";exit;
}
// COMPUTE RATES  LIVE 
$SQL="select distinct(instrument) from trade_running where accountid='".$login."'";
$FF=mysql_query($SQL);

while (list($instrument)=mysql_fetch_array($FF))
{
	$S1="select ask,bid,timestamp from rates where instrument='".$instrument."' order by timestamp desc limit 0,1";
	//echo "<li>".$S1;
	$FFF=mysql_query($S1);
	list($ask,$bid,$timestamp)=mysql_fetch_array($FFF);
	$time=time();
	$diff=$time-$timestamp; 
	if  (($time-$timestamp)<60+$_MODIFY_DELTA)
	{
	//echo "<li>".$instrument." DIRECT RATES";
	$_PRICE[$instrument]=($ask+$bid)/2;
	}
	else
	{
	//echo "<li>".$instrument." INDIRECT RATES";
	$S2="select command,price,digit,profit from tradedb where instrument='".$instrument."' order by timeinsert desc limit 0,1";
	$FFF=mysql_query($S2);
	list($command,$priceopen,$digit,$profit)=mysql_fetch_array($FFF);
	//echo "<li>".$priceopen." ".$instrument." ".$profit;
	$multi=multipips("",$digit);
		
	if ($command==0)
	{
	$_PRICE[$instrument]=$priceopen+$profit*$multi;
	}
	else
	{
	$_PRICE[$instrument]=$priceopen-$profit*$multi;
	
	}
	
	
	}
}	
//
//print_r($_PRICE);
echo "<table witdh=100% cellpadding=0 cellspacing=0 border=0>";
echo "<thead><th>ID</th><th>Instrument</th><th></th><th>Strategy</th><th>Lot size</th><th>Open Time</th><th>Price open</th><th>Price</th><th>SL</th><th>TP</th><th>Profit USD</th><th>Pips</th></thead>";
$SQL333="SELECT id,instrument,command,price,profit,sl,tp,digit,comment,lot,timeinsert,comment,signature from trade_running where accountid='".$login."' order by timeinsert desc";
	//echo"<li>".$SQL333;
	$QQQ=mysql_query($SQL333);

	echo mysql_error();
	//echo "<li>".$SQL333;
	$trade=0;$total=0;
	while (list ($ID_SENT,$ins,$com,$priceopen,$profitCFD,$sl,$tp,$digit,$strat,$lotsizee,$timeinsertTAKEN,$comment,$signature)=mysql_fetch_array($QQQ))
	{
	$trade++;
	
	if ($ID_SENT!="")
		{
		
		if ($comment!="manual")
		{
		$SQL444="select command,profit, swap from tradedb where signature='".$signature."'";
		//echo"<li>".$SQL444;
		$R444=mysql_query($SQL444);
		
		list ($command,$profit,$swap)=mysql_fetch_array($R444);
		
		$multi=multipips($ins,$digit);
		
		
		$rightPrice=round($_PRICE[$ins],5);
		if ($command==0)
		{
		//echo "<li>".$multi." ".$digit." ".$lotsizee;
		$compute=(($rightPrice-$priceopen)/$multi)*($lotsizee/0.10);
		}
		else
		{
				//echo "<li>".$multi." ".$digit." ".$lotsizee;

		$compute=-1*(($rightPrice-$priceopen)/$multi)*($lotsizee/0.10);
		}
		$clearedProfit=round($compute ,2);
		
		$basepips=abs(($rightPrice-$priceopen)/$multi);$basepips=round($basepips,2);
		
		//$swapD=$swap*($lotsizee/0.10);
		//$total+=$swap*($lotsizee/0.10);
		}
		if (isset($_SESSION['xapi']))
		{
		$LL="select id from trade_bridged where signature='".$signature."' and command='".$com."'";
		$L3=mysql_query($LL);
		list($IDB)=mysql_fetch_array($L3);
		}
		else
		{
		$IDB=1;
		
		}
		if ($comment=="manual") {$IDB=1;}
		if ($IDB!="")
		{
		$total+=$clearedProfit;
		//$addhtml="<i class=\'fa fa-check-square-o\'></i>";
		if ($strat!="manual") {
		if (($strat=="commodities") || ($strat=="equities") || ($strat=="etfs") || ($strat=="indices"))
		{
		$clearedProfit=$profitCFD;
		
		}
		
		echo "<tr><td>".$ID_SENT."</td><td>".$ins."</td><td>".$com."</td><td>".$strat."</td><td>".round($lotsizee,2)."</td><td>".$timeinsertTAKEN."</td><td>".round($priceopen,$digit)."</td><td>".round($rightPrice,$digit)."</td><td>".$sl."</td><td>".$tp."</td><td>".round($clearedProfit,2)."</td>";
		if ($clearedProfit==0)
		{
		echo "<td>Pending (*)</td>";
		}
		else
		{
		echo "<td>".$basepips."</td>";
		}
		echo"<td>";
		
		if ($basepips>$_MINTOCLOSE)
			{
			
			echo"<div id='clicksign_".$signature ."' onClick=\"javascript:closeTrade('".$signature."','".$token."');\"><i class='fa fa-times'></i></div>";
		
			
			}
		
		
		
		echo"</td></tr>";
		}
		else
		{
		$T="select profit from trade_running where id='".$ID_SENT."'";
		$TT=mysql_query($T);
		list ($profitrunning)=mysql_fetch_array($TT);
	
		echo "<tr><td>".$ID_SENT."</td><td>".$ins."</td><td>".$com."</td><td>".$strat."</td><td>".round($lotsizee,2)."</td><td>".$timeinsertTAKEN."</td><td>".round($priceopen,$digit)."</td><td colspan=3>Managed through xStation, not nucleus</td><td>".round($profitrunning,2)." USD</td><td></td>";
		
		}
		}
	
		
		}
	}
if ($trade==0)
{
echo "<tr><td colspan=11>NO TRADES...</td></tr>";
}
else
{
$total=round($total,2);
//echo"<tr><td colspan=10>TOTAL</td><td>".$total." USD</td></tr>";
}
echo"</table>";

include("end_db.php");
?>