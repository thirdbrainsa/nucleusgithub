<?php
/**
  * @This script insert the orders in the DB in the table tradedb
  * Details of variable sent with GET method
  * cmd = 0 or 1 ( 0=BUY. 1=SELL)
  * Instrument = Instrument
  * takeprofit = take profit if the trade, it's the price level
  * stoploss = stop lose, it's the price - level
  * swap = amout of swap (in USD)
  * openprice = price level when trade was opened
  * timeopen = When the trade was opened in GMT+2
  * spread = what spread was used inside the MT4
  * strategy = what strategy was playing (the name of the strategy is setup inside the parameter of the OrderSender.Mq4 in the Metatrader 4).
  * @Becarefull security are not set for LIVE PRODUCTION then DON't USE in LIVE PRODUCTION MODE.

*/
// take the timestamp
$time=time();
// We build an unique signature for the trade received. 
// This unique signature is very important because this signature will be used in all scripts later and will be used to recognized the trade among others.
// you can have for the same couple strategy/instrument only 2 trades at the same second : one in BUY and one in SELL (Long/Short).
// MD5 is used as the method to transform a string to an unique string of 32 caracters. it's the best method to produce this kind of keys.

$signature=md5($_GET['strategy'].$_GET['timeopen'].$_GET['instrument'].$_GET['cmd']);
print_r($_GET);
if ($_GET['cmd']<2)
{

$profit=$_GET['profit'];

$timestamp=time();
$php_timestamp_date = date("Y-m-d H:i:s", $timestamp);
$_timeopen=$php_timestamp_date;

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

$openprice=($ask+$bid)/2;
$openprice=round($openprice,5);

}
else
{

$openprice=$_GET['openprice'];

}
if (isset($_GET['cfd']))
{
	$H1="select description from instrumentdb where symbol='".$_GET['instrument']."'";
	echo"<li>".$H1;
	$HH1=mysql_query($H1);
	list($description)=mysql_fetch_array($HH1);
	echo"<li>".$description;
	echo mysql_error();
	

}

$SQL_main="INSERT INTO tradedb VALUES('','".$_GET['instrument']."','".$_GET['cmd']."','".$openprice."','".$_GET['digit']."','".$_GET['stoploss']."','".$_GET['takeprofit']."','".$_GET['swap']."','".$profit."','".$_GET['spread']."','".$_GET['strategy']."','".$time."','".$_timeopen."','".$signature."')";


$SQL2="select id from tradedb where signature='".$signature."'";
$r=@mysql_query($SQL2,$mysql);
list($ID)=mysql_fetch_array($r);

if ($ID=="")
	{
		@mysql_query($SQL_main,$mysql);
		$ID=mysql_insert_id();
		if ($description!="")
			{
				$SQL="insert into tradecomment VALUES('".$ID."','".$description."')";
				mysql_query($SQL);
				echo mysql_error();
			}
	}
	else
	{
		$SQL_update="UPDATE tradedb set profit=".$profit.",sl=".$_GET['stoploss'].", tp=".$_GET['takeprofit']." where id=".$ID;
		echo "<li>".$SQL_update;
		mysql_query($SQL_update);
		if ($description!="")
			{
				$F1="select idtrade from tradecomment where idtrade=".$ID;
				$FF1=mysql_query($F1);
				list($ic)=mysql_fetch_array($FF1);
				if ($ic=="")
				{
				$SQL="insert into tradecomment VALUES('".$ID."','".$description."')";
				mysql_query($SQL);
				echo mysql_error();
				}
			}
	
	}
  /// PURGE DB //
  // The purge is fixed at 1 week ]
  
  //$SQL_PURGE_1="UPDATE tradedb set command=99 where whenopen < NOW() - INTERVAL 1 WEEK";
  //@mysql_query($SQL_PURGE_1);
  
  // Manage purge system automatically
  $SQL_PURGE_2="DELETE from tradedb where whenopen < NOW() - INTERVAL 16 WEEK";
  @mysql_query($SQL_PURGE_2);
  //
 
  
  include("end_db.php");
  
  // CALL THE CRON.PHP
  $_CRON="ORDER";
  // Send the data to the "populator" which will fill the journal of each trading account.
  include("cron-populate-direct.php");
  
}

?>