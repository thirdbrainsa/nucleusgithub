<?php
//print_r($_GET);
$time=time();
print_r($_GET);
if (!(isset($_GET['signaturebypass'])))
{
$signature=md5($_GET['strategy'].$_GET['timeopen'].$_GET['instrument'].$_GET['cmd']);
}
else
 {
	$signature=$_GET['signaturebypass'];
	if (isset($_GET['cfd']))
	{
	$keepProfit=$_GET['profit'];
	$keepDigit=$_GET['digit'];
	}
	if (strlen($signature)!=32) {exit;}
 
 }
include("config.php");
include("connect_db.php");
// GET THE RIGHT RATES / xSTATION RATES //
$SQLr="select timestamp, ask, bid from rates where instrument='".$_GET['instrument']."' order by timestamp desc limit 0,1";
$Rr=mysql_query($SQLr);
$time=time();
list ($timestamp,$ask,$bid)=mysql_fetch_array($Rr);
$diff=$time-$timestamp;
echo $timestamp." ".$time. " ".$diff;
if ($diff<60)
{

$closeprice=($ask+$bid)/2;
$closeprice=round($closeprice,5);

}
else
{

$closeprice=$_GET['takeprofit'];

}

$SQL_TEST="SELECT id from historydb where signature='".$signature."'";
$S=@mysql_query($SQL_TEST,$mysql);
list($id)=mysql_fetch_array($S);
$ID=$id;


if ($id=="")
{

if ($_GET['cmd']<2)
{

$SQL33="select price,whenopen from tradedb where signature='".$signature."'";
echo"<li>".$SQL33;
$S33=@mysql_query($SQL33);
list ($openprice,$_timeopen)=mysql_fetch_array($S33);
echo "<li> OPENPRICE : ".$openprice.", TIMEOPEN ".$_timeopen."</li>";
$timestamp=time();
$php_timestamp_date = date("Y-m-d H:i:s", $timestamp);
$_timeclose=$php_timestamp_date;
// GET THE OPEN PRICE OF THE TRADE
$commande=$_GET['cmd'];
$digit=$_GET['digit'];
$insT=$_GET['instrument'];


if (($openprice==0) || ($_timeopen==""))
	{
	//print_r($_GET);
	if (!(isset($_GET['cfd'])))
		{
			$priceopen=$_GET['openprice'];
			$openprice=$_GET['openprice'];
			$value_of_point=$_GET['vpoint'];
		
			$profit=$_GET['profit']/$value_of_point;
			$closeprice=$openprice+$_GET['profit'];
		}
		else
		{
			$openprice=$_GET['openprice'];
			$closeprice=$_GET['takeprofit'];
			$profit=$_GET['profit'];
		}
	}

else
{


$priceopen=$openprice;
$priceclose=$closeprice;
if (!(isset($_GET['cfd'])))
{
$multi=multipips($insT,$digit);
$profit=0;
if ($commande==0)

{

$profit=($priceclose-$priceopen)/$multi;

}

if ($commande==1)
{

$profit=($priceopen-$priceclose)/$multi;

}


}
if (!(isset($_GET['cfd'])))
{
$openprice=round($openprice,$digit);
$closeprice=round($closeprice,$digit);
$profit=round($profit,2);
}
else
{
$profit=$keepProfit/$keepDigit;
}
}
//
$SQL_main="INSERT INTO historydb VALUES('','".$_GET['instrument']."','".$_GET['cmd']."','".$openprice."','".$_GET['digit']."','".$_GET['stoploss']."','".$closeprice."','".$_GET['swap']."','".$profit."','".$_GET['spread']."','".$_GET['strategy']."','".$time."','".$_timeopen."','".$_timeclose."','".$signature."')";
mysql_query($SQL_main,$mysql);
echo mysql_error();
echo "<li>".$SQL_main;
$ID=mysql_insert_id();

}

}
include("end_db.php");
$_CRON="HISTORY";
if (isset($_GET['cfd']))
{
$CFD=$_GET['cfd'];
} else { $CFD="";}
include("cron-populate-direct.php");

?>