<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
include ("config.php");
include ("connect_db.php");
$deltaTime=time()-60*200;
if (isset($_GET['token']))
	{
		$token=strip_tags(trim($_GET['token']));
		if (strlen($token)!=32) { $token=0;}
	}
	else
	{
		$token=0;
	}
$SQL22="SELECT id,command, instrument,price, sl, tp, profit,strategy,timeinsert,whenopen,signature from historydb where command<2  ORDER BY timeinsert desc limit 0,6";
//echo "<li>".$SQL22;
$S22=mysql_query($SQL22);
$aa=0;
while (list($id,$command,$instrument,$price,$sl,$tp,$profitTRADE,$strategy,$timeinsert,$whenopen,$signature)=mysql_fetch_array($S22))
{

$SQL222="SELECT profit, count,dayprofit,drawdown,winningperc,awt,alt,tbx_score from ranking where instrument='".$instrument."' and strategy='".$strategy."'";
$S222=mysql_query($SQL222);
list($profit,$count,$dayprofit,$drawdown,$winningperc,$awt,$alt,$tbx_score)=mysql_fetch_array($S222);
$addinfo="";$addhtml="";
$IP=$_SERVER['REMOTE_ADDR'];
$SQLIP="select login from temp_login where ip='".$IP."'";
$QQ=@mysql_query($SQLIP);
while (list($login)=mysql_fetch_array($QQ))
{
	$SQL333="SELECT id,instrument,command,comment,lot,timeinsert from trade_taken where accountid='".$login."' and signature='".$signature."' order by timeinsert desc limit 0,4";
	$QQQ=mysql_query($SQL333);
	//echo mysql_error();
	//echo "<li>".$SQL333;
	while (list ($ID_SENT,$ins,$com,$strat,$lotsizee,$timeinsertTAKEN)=mysql_fetch_array($QQQ))
	{
	if ($ID_SENT!="")
		{
			//$addhtml="<i class=\'fa fa-check-square-o\'></i>";
		$addinfo.="<font color=white>_</font>".$timeinsertTAKEN." - ".$ins." ".$com." order of strategy ".$strat." was sent to ".$login." with lot ".round($lotsizee,2)."<br>";
		if ($com!="CLOSE")
		{
		$addhtml.="<font color=red><i class=\"fa fa-check-square-o\"></i></font>";
		}
		else
		{
		$addhtml.="<font color=black><i class=\"fa fa-check-square-o\"></i></font>";
		}
		}
	}	
}


$html="<table border=0><caption><h1>".ucfirst($strategy)." ".$instrument."</h1></caption><tr><td><b>Profit this month</b></td><td>".$profit." pips</td><td><b>Number of Trade</b></td><td>".$count."</td><td><b>24H profit</b></td><td>".$dayprofit." pips</td><td><b>Maximal DD</b></td><td>".$drawdown." pips</td></tr>";
$html.="<tr><td><b>Average winning trade</b></td><td>".$awt." pips</td><td><b>Average Loosing Trade</b></td><td>".$alt." pips</td><td><b>Winning %</b></td><td>".$winningperc." %</td><td><b>TBX SCORE</b></td><td>".$tbx_score."</td></tr></table>";
$html.="<div align=left> ".$addinfo."</div>";
//$file=@fopen("html/".$signature.".html","w");
//@fputs($file,$html);
//@fclose($file);


$SQL222="SELECT profit, count from ranking where instrument='".$instrument."' and strategy='".$strategy."'";
$S222=mysql_query($SQL222);
list($profitS,$count)=mysql_fetch_array($S222);


$SQL33="select id from tradedb where signature='".$signature."'";
//echo"<li>".$SQL33;
$S33=@mysql_query($SQL33);
list ($ID_T)=mysql_fetch_array($S33);
$aa++;
$delta=time()-$timeinsert-$_MODIFY_DELTA;

// SEND TO TWITTER //

if ($aa==1)
	{
		if (!(file_exists("twitter-php-master/examples/signatureH/".$signature.".txt")))
			{
				
				$file=fopen("twitter-php-master/examples/signatureH/".$signature.".txt","w");
				fputs($file,"+");
				fclose($file);
				$instrumentX=str_replace("_4","",$instrument);
				$instrumentX=str_replace(".","",$instrumentX);
				if  (($strategy=="equities") || ($strategy=="commodities") || ($strategy=="etfs") || ($strategy=="indices"))
				{
				$P="select description from instrumentdb where symbol='".$instrument."'";
				$PP=mysql_query($P);
				list ($descriptionX)=mysql_fetch_array($PP);
				
				$message="#".$instrumentX." ,".str_replace("CFD","",$descriptionX)." ".longshort($command)." position at ".$tp." with a profit of  ".$profitTRADE. " pips. See www.thirdbrainfx.com #ea #money";
				$message2="#".$instrumentX." ,".str_replace("CFD","",$descriptionX).",  closed ".longshort($command)." position at ".$tp." , profit:".$profitTRADE. " pips,#ID".$ID_T." check www.thirdbrainfx.com #ea #money";
				//echo "<li>".$message."<br>".$message2."</li>";
				}
				{
				$message="#".$instrumentX." closed by strategy #".$strategy." a ".longshort($command)." position at ".$tp." with a profit of  ".$profitTRADE. " pips. See www.thirdbrainfx.com #ea #money";
				$message2="#".$instrumentX." closed with robot #".$strategy." a ".longshort($command)." position at ".$tp." , profit:".$profitTRADE. " pips,#ID".$ID_T." check www.thirdbrainfx.com #ea #money";
				}
				$_SEND=$message;
				$_SEND2=$message2;
				require_once 'twitter-php-master/src/twitter.class.php';
				
				if ($_MODE_TWITTER==1)
				{
					$twitter2 = new Twitter($consumerKey2, $consumerSecret2, $accessToken2, $accessTokenSecret2);

					try {
							
							$tweet = $twitter2->send($_SEND2); // you can add $imagePath as second argument

						} catch (TwitterException $e) {
							//echo 'Error: ' . $e->getMessage();
							// IF ERROR TRY WITH THIRDBRAINFX3
							
							$twitter3 = new Twitter($consumerKey3, $consumerSecret3, $accessToken3, $accessTokenSecret3);
							try {
							
									$tweet = $twitter3->send($_SEND2); // you can add $imagePath as second argument

							     } catch (TwitterException $e) 
							     {
									//echo 'Error: ' . $e->getMessage();
							
							   }
							//
							
							
						}
				
				}
				
				if (($profitTRADE > 5 ) && ($ID_T!=""))
				{
			
				
				
				
				if ($_MODE_TWITTER==1)
				{
				
		
				// ENTER HERE YOUR CREDENTIALS (see readme.txt)
				$twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

					try {
							$tweet = $twitter->send($_SEND); // you can add $imagePath as second argument

						} catch (TwitterException $e) {
							//echo 'Error: ' . $e->getMessage();
						}
				}
				}
			}
	}



if ($aa==1)
{
	if ($delta<3)
	{
	echo "<div id='eachcurrencyclosefirst' style='float: left;'>";
	}
	else
	{
	echo "<div id='eachcurrencyclose' style='float: left;'>";
	}
}
else
{
echo "<div id='eachcurrencyclose' style='float: left;'>";
}

$min=intval($delta/60);
if ($min>60) 
{
$heure=intval($min/60);
}
else
{
$heure=0;
$sec=$delta-$min*60;
}

	echo "<h1>".str_replace("_4","",$instrument)."</h1>";

$day=date("N");
if ($day==6) {$_SENDCOMMAND=0;}
if ($day==7) {$_SENDCOMMAND=0;}
//

if ($_SENDCOMMAND==1)
{
if ($addhtml!="")
{
echo"<div id='clicksign_".$signature ."' onClick=\"javascript:closeTrade('".$signature."','".$token."');\"><i class=\"fa fa-plus\"></i>".$addhtml."</div>";
}
}
if (isset($_SESSION['password']))
		{
		$login=$_SESSION['login'];
		//if (in_array($instrument,$_FX))
		 //{	
		 
		$SSS="select id,lot,accountpwd from portofolio_dashboard where accountid='".$login."' and instrument='".$instrument."' and strategy='".$strategy."'";
	
		
		$rrr=mysql_query($SSS);

	list($id_portfolio,$lot_size,$_password_inside)=mysql_fetch_array($rrr);
	if ($login!="")
	{
	if ($id_portfolio=="")
			{
			$porthtml="<div id='por_".$strategy.$instrument."'><a href=\"javascript:registerPortfolio('".$login."','".$token."','".$strategy."','".$instrument."');\"'><i class=\"fa fa-square-o\"></i></a></div>";
			$porthtml.="<div id='lot_".$strategy.$instrument."'></div>";
			
			}
		else
			{
			$porthtml="<div id='por_".$strategy.$instrument."'><a href=\"javascript:removePortfolio('".$login."','".$token."','".$strategy."','".$instrument."');\"><i class=\"fa fa-check-square\"></i></a></div>";
			$porthtml.="<div id='lot_".$strategy.$instrument."'></div>";
			}
		//}
		//else
		//{
		//$porthtml="<b>#".$id."<b>";
		
		//}
		}
	}


if ($command==0) {echo"<font color=green><b>";} else {echo"<font color=red><b>";}
  echo "<h2> CLOSE <a href='charts.php?instrument=".$instrument."&strategy=".$strategy."'><i class='fa fa-bar-chart'></i></a></h2></font>";
 echo" ".round($profitTRADE,2)." pips<br>";echo "<font color=orange><b>".strtoupper($strategy)."</b></font></br>";
 if (isset($_SESSION['password'])) { echo $porthtml; } 

if ($heure==0)
{
echo"<br>".$min." min ".$sec." sec ago<br>";
}
else
{
echo"<br>".$heure." hours ago";
}
echo"</div>";

$SQL_PURGE_1="UPDATE tradedb set digit=99 where signature='".$signature."'";
@mysql_query($SQL_PURGE_1);
}


include("end_db.php");
?>