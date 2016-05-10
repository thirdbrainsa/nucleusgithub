<?php
include("connect_db.php");

echo "<table witdh=100% cellpadding=0 cellspacing=0 border=0 class='sortable'>";
echo "<caption><h1>LATEST 30 POSITIONS CLOSED OF ".strtoupper($strategy)." ".str_replace("_4","",$instrument)."</h1></caption>";
echo "<thead><th>ID</th><th>Command</th><th>Open Time</th><th>Close Time</th><th>Price open</th><th>Price close</th><th>profit</th></thead>";
//echo"<tr><td colspan=11><h1> GET THIS STRATEGY AND ALL OTHERS WITH FXCM or FXDD RIGHT NOW !</h1><a href='http://www.thirdbrainfx.com/access-our-vip-unique-forex-strategies'><img src='https://www.thirdbrainfx.com/banner-fxdd-fxcm-thirdbrainfx.jpg'></a>";

$SQL333="SELECT id,command,price,sl,tp,whenopen,whenclose,swap,profit,digit,signature from historydb where strategy='".$strategy."' AND instrument='".$instrument."' order by timeinsert desc limit 0,30";
$QQQ=mysql_query($SQL333);
	echo mysql_error();
	$trade=0;
	while (list ($ID_SENT,$com,$priceopen,$sl,$tp,$whenopen,$whenclose,$swap,$profit,$digit,$signature)=mysql_fetch_array($QQQ))
	{
          $trade++;
		if ($digit==5) {$multi=0.00001;}
		if ($digit==4) {$multi=0.00001;}
		if ($digit==3) {$multi=0.001;}
		if ($digit==2) {$multi=0.01;}
		if ($digit==1) {$multi=0.1;}
		if ($digit==0) {$multi=1;}
		
		$pricenow=$priceopen+$profit*$multi*10;
		if ($com==1) {$DISPLAY="SELL";} else {$DISPLAY="BUY";}
		if ($strategy!="equities")
		{
		echo "<tr><td>".$ID_SENT."</td><td>".$DISPLAY."</td><td>".$whenopen."</td><td>".$whenclose."</td><td>".round($priceopen,$digit)."</td><td>".round($pricenow,$digit)."</td><td>".$profit."</td></tr>";
		}
		else
		{
		echo "<tr><td>".$ID_SENT."</td><td>".$DISPLAY."</td><td>".$whenopen."</td><td>".$whenclose."</td><td>".$priceopen."</td><td>".$tp."</td><td>".$profit."</td></tr>";
		
		
		}
	}
if ($trade==0)
{
echo "<tr><td colspan=11>NO TRADES...</td></tr>";

}


echo"</table>";

include("end_db.php");
?>