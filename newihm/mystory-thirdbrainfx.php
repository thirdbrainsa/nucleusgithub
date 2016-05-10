<?php
include ("config.php");
include ("connect_db.php");
include("librairies/manage.php");
$message=0;
### WHO IS DOING GREAT.
$SQL7="SELECT id,instrument, strategy,profit,count,winningperc,awt,alt,drawdown,tbx_score from ranking where profit > 0 and count > 3 order by RAND()";

$QQ=mysql_query($SQL7);echo mysql_error();
list ($ID2,$instrument2,$strategy2,$profit2,$count2,$win,$awt,$alt,$dd2,$tbx_score2)=mysql_fetch_array($QQ);

if ($dd2<$profit2)

{
$addou=",MAXDD :".$dd2.",";
}
else
{
$addou="";
}

if ($awt>$alt)
{

$addon=".Winning trade average is superior to loosing trade's one";
}
else
{
$addon="";
}

if ($win<70)
{
$message2="#".$strategy2." ".msg_random("is still doing great",$_MSG_MATRIX)." #".$instrument2." , profit : ".$profit2." pips, ".$count2." trades.".$addou." Visit www.thirdbrainfx.com";
}
else
{
$message2="#".$strategy2."  #".$instrument2." ".msg_random("win",$_MSG_MATRIX)." ".$win." % of ".$count2." trades."." ".$addon." go www.thirdbrainfx.com";

}

//echo $message2;

if ($_MODE_TWITTER==1)
				{
				require_once 'twitter-php-master/src/twitter.class.php';
				echo "SENT";
				// ENTER HERE YOUR CREDENTIALS (see readme.txt)
				$twitter2 = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

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


include("end_db.php");
?>