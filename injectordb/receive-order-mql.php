<?php
//print_r($_GET);

$time=time();
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
  
  $SQL_PURGE_2="DELETE from tradedb where whenopen < NOW() - INTERVAL 16 WEEK";
  @mysql_query($SQL_PURGE_2);
  //
 
  
  include("end_db.php");
  
  // CALL THE CRON.PHP
  $_CRON="ORDER";
  include("cron-populate-direct.php");
  
}

?>