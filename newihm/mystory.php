<?php
include ("config.php");
include ("connect_db.php");
include("librairies/manage.php");
$message=0;
### WHO IS DOING GREAT.
$SQL7="SELECT id,instrument, strategy,profit,count,drawdown,tbx_score from ranking where winningperc>60 and profit > 300 and count > 10 order by RAND()";
$QQ=mysql_query($SQL7);echo mysql_error();
list ($ID2,$instrument2,$strategy2,$profit2,$count2,$dd2,$tbx_score2)=mysql_fetch_array($QQ);

$message2="#".$strategy2." ".msg_random("is still doing great",$_MSG_MATRIX)." #".$instrument2." , profit : ".$profit2." pips, ".$count2." trades, maxDD ".$dd2. " pips. go www.thirdbrainfx.com";
//echo $message2;

if ($_MODE_TWITTER==1)
				{
				require_once 'twitter-php-master/src/twitter.class.php';
				echo "SENT";
				// ENTER HERE YOUR CREDENTIALS (see readme.txt)
				$twitter2 = new Twitter($consumerKey2, $consumerSecret2, $accessToken2, $accessTokenSecret2);

					try {
							
							$tweet = $twitter2->send($message2); // you can add $imagePath as second argument

						} catch (TwitterException $e) {
							echo 'Error: ' . $e->getMessage();
							$twitter3 = new Twitter($consumerKey3, $consumerSecret3, $accessToken3, $accessTokenSecret3);
							try {
							
									$tweet = $twitter3->send($message2); // you can add $imagePath as second argument

							     } catch (TwitterException $e) 
							     {
									echo 'Error: ' . $e->getMessage();
							
							   }
							
						}
				}



$SQL1="SELECT id,instrument, strategy,profit,count,drawdown,tbx_score from  www,fdranking_week where winningperc>75 and profit > 50 and count > 4 order by RAND()";
$R1=mysql_query($SQL1,$mysql);
list($ida,$instrument_1,$strategy_1,$profit_1,$count_1,$maxdd_1,$tbx_score_1)=mysql_fetch_array($R1);
if ($ida!="")
{
 //echo "<li>".$instrument_1." ".$strategy_1;

$SQL2="SELECT SUM(profit) from ranking_week where instrument='".$instrument_1."'";
$R2=mysql_query($SQL2,$mysql);
list($sum_instrument_1)=mysql_fetch_array($R2);
if  (($sum_instrument_1/$profit_1)>1.5)
{
 // Todo
}
echo "<li>".$sum_instrument_1;
// FIRST SENTENCE.henclose>NOW() - INTERVAL 1  DAY

$SQL_R1="select id,profit from message_log where instrument='".$instrument_1."' and strategy='".$strategy_1."' and whenopen>NOW()-INTERVAL 1 DAY";
//echo "<li>".$SQL_R1;
$RR1=mysql_query($SQL_R1);
echo mysql_error();
list($id,$profit_1_change)=mysql_fetch_array($RR1);

if ($profit_1_change==$profit_1)
 {
  $id="";
 }
if ($id=="")
{

$message="#".$strategy_1." ".msg_random("is doing great",$_MSG_MATRIX). " ".$profit_1." pips done ".msg_random("during the last 24 hours",$_MSG_MATRIX)." ".msg_random("playing with",$_MSG_MATRIX)." #".$instrument_1. " , ".$count_1." Trades, see www.thirdbrainfx.com";
$signatureMSG=md5($strategy_1.$instrument_1.$profit_1.$count_1);
}
else
{

$message="#".$strategy_1." ".msg_random("is still doing great",$_MSG_MATRIX). " ".$profit_1." pips done ".msg_random("during the last 24 hours",$_MSG_MATRIX)." ".msg_random("playing with",$_MSG_MATRIX)." #".$instrument_1. " , ".$count_1." Trades, see www.thirdbrainfx.com";

$signatureMSG=md5($strategy_1.$instrument_1.$profit_1.$count_1."SUIVI");

}


// CHOOSE A MESSAGE TO SEND TO THIRDBRAINFX2




$SQL6="insert into message_log values('','".$instrument_1."','".$strategy_1."',NOW(),'".$profit_1."','".$count_1."','".$day."','".$maxdd_1."','100','".$awt."','".$alt."','".$tbx_score_1."','".addslashes($message)."','".$signatureMSG."')";
mysql_query($SQL6,$mysql);
$id_insert=mysql_insert_id();
/*
GET THE INSTRUMENT DATA HISTORY //

$_GET_INFO_ASK="http://83.136.252.46/frontofficeweb/rates/".$instrument_1."/ASK/value.txt";
$_GET_INFO_ASK_1HOUR="http://83.136.252.46/frontofficeweb/rates/".$instrument_1."/HISTORY/TICK30/ASK/value.txt";
$_ask_price_now=file_get_contents($_GET_INFO_ASK);
$_ask_price_1hourago=file_get_contents($_GET_INFO_ASK_1HOUR);

echo"<li>".$_ask_price_now." ".$_ask_price_1hourago;
*/

echo $message;
echo strlen($message);
if ($id_insert!="")
	{
		$signature=$signatureMSG;
		
		if (!(file_exists("twitter-php-master/examples/signature/".$signature.".txt")))
			{
				
				$file=fopen("twitter-php-master/examples/signature/".$signature.".txt","w");
				fputs($file,"+");
				fclose($file);
				
				//$message="#".$instrument." strategy #".$strategy." ".sellbuy($command)." SL :".$sl." TP:".$tp. " . ".$profit. " pips since inception. See www.thirdbrainfx.com";
		
				$_SEND=$message;
				
				if ($profit_1 > 100 ) 
				{
				
				
				if ($_MODE_TWITTER==1)
				{
				require_once 'twitter-php-master/src/twitter.class.php';
				//echo "SENT";
				// ENTER HERE YOUR CREDENTIALS (see readme.txt)
				$twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

					try {
							
							$tweet = $twitter->send($_SEND); // you can add $imagePath as second argument

						} catch (TwitterException $e) {
							echo 'Error: ' . $e->getMessage();
						}
				}
				}
				
			}
	}

}
include("end_db.php");
?>