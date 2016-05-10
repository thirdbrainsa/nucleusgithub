     <script src="js/sortable.js"></script>
<?php
session_start();
include("config.php");
$tcom=0;
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
echo"<div id='balance'></div>";

echo "<table witdh=100% cellpadding=0 cellspacing=0 border=0 class='sortable'>";
echo "<CAPTION> HISTORY OF YOUR ACCOUNT ". $login."</CAPTION>";
echo "<thead><th>ID</th><th>Stats</th><th>Instrument</th><th>Command</th><th>Strategy</th><th>Lot size</th><th>Open Time</th><th>Close Time</th><th>Price open</th><th>Price close</th><th>Profit (USD)</th><th>Commissions (USD)</th></thead>";
$SQL333="SELECT id,instrument,command,price,swap,profit,sl,tp,digit,comment,lot,timeinsert,signature from history_client where accountid='".$login."' order by timeinsert desc limit 0,100";
	$QQQ=mysql_query($SQL333);

	echo mysql_error();
	//echo "<li>".$SQL333;
	$trade=0;$total=0;
	while (list ($ID_SENT,$ins,$com,$priceopen,$swap,$profit,$sl,$tp,$digit,$strat,$lotsizee,$timeinsertTAKEN,$signature)=mysql_fetch_array($QQQ))
	{
	$trade++;
	if ($ID_SENT!="")
		{
		$SQL444="select whenopen,whenclose from historydb where signature='".$signature."'";
		//echo"<li>".$SQL444;
		$R444=mysql_query($SQL444);
		
		list ($whenopen,$whenclose)=mysql_fetch_array($R444);
		//echo"<li>".$whenopen." ".$whenclose;
		if  ( ($whenopen=="") || ($whenclose==""))
			{
				$SQL555="select timeinsert from trade_taken where signature='".$signature."' and command!='CLOSE'";
				$R555=mysql_query($SQL555);
				list($whenopen)=mysql_fetch_array($R555);
				$SQL555="select timeinsert from trade_taken where signature='".$signature."' and command='CLOSE'";
				$R555=mysql_query($SQL555);
				list($whenclose)=mysql_fetch_array($R555);
			
			}
		
		$multi=multipips($ins,$digit);
		if ($whenclose=="")	
			{
				$PO="select timeinsert from history_client where signature='".$signature."' and accountid='".$login."'";
				$POO=mysql_query($PO);
				list($whenclose)=mysql_fetch_array($POO);
			
			}
		$profitD=$profit;
		$total+=$profitD;
		$swapD=$swap*($lotsizee/0.10);
		$total+=$swap*($lotsizee/0.10);
		$pricenow=$priceopen+$profit/($lotsizee/0.10)*$multi;
			//$addhtml="<i class=\'fa fa-check-square-o\'></i>";
		$XX="select commission from commission where idhistory=".$ID_SENT;
		$XXX=mysql_query($XX);
		list($commission)=mysql_fetch_array($XXX);
		if ($commission=="") {$commission=0;}
		$tcom+=$commission;
		echo "<tr><td>".$ID_SENT."</td><td><a href='charts.php?instrument=".$ins."&strategy=".$strat."'><i class='fa fa-bar-chart'></i></a></td><td>".$ins."</td><td>".$com."</td><td>".$strat."</td><td>".round($lotsizee,2)."</td><td>".$whenopen."</td><td>".$whenclose."</td><td>".round($priceopen,$digit)."</td><td>".round($pricenow,$digit)."</td><td>".round($profitD,2)."</td><td>".$commission."</td></tr>";
		}
	}

$total=round($total,2);
if ($trade==0)
{
echo "<tr><td colspan=11>NO TRADES...</td></tr>";
}
echo"</table>";

include("end_db.php");
?>