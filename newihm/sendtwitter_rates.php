<?php
set_time_limit(0);
include ("config.php");
include ("connect_db.php");
include("librairies/manage.php");
$max_diff=0;
$min_diff=0;

$SQL2="SELECT DISTINCT(instrument),digit from historydb order by RAND()";
$r=mysql_query($SQL2);
list($instrument,$digit)=mysql_fetch_array($r);

$_GET_INFO_ASK=$_dynamic_rates_url."/frontofficeweb/rates/".$instrument."/ASK/value.txt";
$_GET_INFO_BID=$_dynamic_rates_url."/frontofficeweb/rates/".$instrument."/BID/value.txt";
$_GET_INFO_ASK_1HOUR=$_dynamic_rates_url."/frontofficeweb/rates/".$instrument."/HISTORY/TICK59/ASK/value.txt";
//$html.= "<li>".$_GET_INFO_ASK_1HOUR;
//echo "<li>".$instrument;
$_ask_price_now="";
$_bid_price_now="";
$_ask_price_now=@file_get_contents($_GET_INFO_ASK);
$_bid_price_now=@file_get_contents($_GET_INFO_BID);
$_ask_price_60minutesago=@file_get_contents($_GET_INFO_ASK_1HOUR);
if ( ($_ask_price_now!="") && ($_bid_price_now!="") && ($_ask_price_60minutesago!=""))
{
printf($instrument."|".$_ask_price_now."|".$_bid_price_now);


$diff=(($_ask_price_now-$_ask_price_60minutesago)/$_ask_price_now)*100;
if ($digit==5) {$multi=10000;}
if ($digit==4) {$multi=10000;}
if ($digit==3) {$multi=100;}
if ($digit==2) {$multi=100;}
if ($digit==1) {$multi=10;}
if ($digit==0) {$multi=1;}
$spread=($_ask_price_now-$_bid_price_now)*$multi;
$diff=round($diff,2);
$spread=round($spread,3);
if ($diff<0) {$bgcolor="red";}
if ($diff>0) {$bgcolor="green";$diff="+".$diff;}
//echo $html;
if ($diff>$max_diff) {$max_diff=$diff; $instrument_max=$instrument;$spread_max=$spread;}
if ($diff<$min_diff) {$min_diff=$diff; $instrument_min=$instrument;$spread_min=$spread;}
print (" ".$diff." ".$max_diff." ".$min_diff. " ".$spread." \n");
}

//echo "<li> HTML >".$html;

require_once 'twitter-php-master/src/twitter.class.php';
	$message2="#".$instrument." ASK :".$_ask_price_now." , BID :".$_bid_price_now.", trade with us www.thirdbrainfx.com #forex #finance #market #money #thirdbrainfx";
	echo $message2;			
if (($_ask_price_now!="") && ($_bid_price_now!=""))
{
				if ($_MODE_TWITTER==1)
				{
					$twitter4 = new Twitter($consumerKey4, $consumerSecret4, $accessToken4, $accessTokenSecret4);

					try {
							
							$tweet = $twitter4->send($message2); // you can add $imagePath as second argument

						} catch (TwitterException $e) {
							echo 'Error: ' . $e->getMessage();
							
							// IF ERROR TRY WITH THIRDBRAINFX3
							
							$twitter3 = new Twitter($consumerKey3, $consumerSecret3, $accessToken3, $accessTokenSecret3);
							try {
							
									$tweet = $twitter3->send($message2); // you can add $imagePath as second argument

							     } catch (TwitterException $e) 
							     {
									echo 'Error: ' . $e->getMessage();
							
							   }
							//
						}
				
				}

}

include ("end_db.php");

//$file=fopen("forex/rates.html","w");
//fputs($file,$html);
//fclose($file);

?>