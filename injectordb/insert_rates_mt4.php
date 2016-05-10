<?php
include ("config.php");
$_total=count($_Currency);
$SQL="";
for ($i=0;$i<$_total;$i++)
{
	$keyAsk="Ask_".$_Currency[$i];
	$keyBid="Bid_".$_Currency[$i];
	$keyTm="tm_".$_Currency[$i];
	if (isset($_GET[$keyAsk]))
	{
	$value_ask=trim($_GET[$keyAsk]);
	$value_bid=trim($_GET[$keyBid]);
	$timestamp=time();
	if (($value_ask!=0) && ($value_bid!=0))
	{
	if ($i<$_total-1)
	{
	$SQL.="('".$timestamp."','".$_Currency[$i]."','".$value_ask."','".$value_bid."')";
	}
	else
	{
	$SQL.="('".$timestamp."','".$_Currency[$i]."','".$value_ask."','".$value_bid."');";
	}
	}
	}
}
$mysql=@mysql_connect($dburl_rates, $dblogin_rates,$dbpass_rates);
@mysql_select_db($dbbase_rates);
$SQLall="INSERT INTO rates VALUES ".$SQL;
echo "<li>".$SQLall;
@mysql_query($SQLall);
@mysql_close($mysql);
$timex=time()-5*60;
$mysql=@mysql_connect($dburl_rates, $dblogin_rates,$dbpass_rates);
@mysql_select_db($dbbase_rates);
$SQLall="DELETE FROM rates where timestamp<".$timex;
@mysql_query($SQLall);
@mysql_close($mysql);
?>