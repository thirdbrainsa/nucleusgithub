<?php
session_start();
include("config.php");
include("connect_db.php");
$login=$_GET['login'];
if ( (strlen($login)<>6) && (strlen($login)<>7)) { exit;}

$nbT=0;

if (isset($_SESSION['xapi']))
{
$RT="select signature from trade_running where accountid='".$login."'";
$RR=mysql_query($RT);
while (list($signature)=mysql_fetch_array($RR))
{
	$TT="select id from trade_bridged where signature='".$signature."'";
	$TTT=mysql_query($TT);
	list($IDR)=mysql_fetch_array($TTT);
	if ($IDR!="")
		{
			$nbT++;
		}
	
}
$RT="select count(id),sum(lot) from portofolio_dashboard where accountid='".$login."'";
$RR=mysql_query($RT);
list($nbP,$sLot)=mysql_fetch_array($RR);
}
else
{
$RT="select count(id) from trade_running where accountid='".$login."'";
$RR=mysql_query($RT);
list($nbT)=mysql_fetch_array($RR);
$RT="select count(id),sum(lot) from portofolio_dashboard where accountid='".$login."'";
$RR=mysql_query($RT);
list($nbP,$sLot)=mysql_fetch_array($RR);
}

echo"<h2><a href='TradeManagement.php' class='large green button'><font color=red>".$nbT."</font> trades running now, and <font color=red>".$nbP."</font> Strategies in portfolio </h2>";
include("end_db.php");
?>