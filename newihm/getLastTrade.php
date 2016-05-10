<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include("librairies/manage.php");
include ("config.php");
include ("connect_db.php");
$deltaTime=time()-60*20;
global $login,$porthtml;
if (isset($_GET['token']))
	{
		$token=strip_tags(trim($_GET['token']));
		if (strlen($token)!=32) { $token=0;}
				//
	}
	else
	{
		$token=0;$login=0;
	}
$SQL22="SELECT id,command, instrument,price, sl, tp, profit,strategy,timeinsert,whenopen,signature from tradedb where command<2  and digit!=99 ORDER BY timeinsert desc limit 0,6";
 

$S22=mysql_query($SQL22);
$aa=0;
while (list($id,$command,$instrument,$price,$sl,$tp,$profitTRADE,$strategy,$timeinsert,$whenopen,$signature)=mysql_fetch_array($S22))
{

$SQL222="SELECT profit, count,dayprofit,drawdown,winningperc,awt,alt,tbx_score from ranking where instrument='".$instrument."' and strategy='".$strategy."'";
$S222=mysql_query($SQL222);
list($profit,$count,$dayprofit,$drawdown,$winningperc,$awt,$alt,$tbx_score)=mysql_fetch_array($S222);

$addhtml="";$addinfo="";
$IP=$_SERVER['REMOTE_ADDR'];
$SQLIP="select login from temp_login where ip='".$IP."' and token='".$token."'";
$QQ=@mysql_query($SQLIP);
list($login)=mysql_fetch_array($QQ);


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
		
		$addhtml.="<i class=\"fa fa-check-square-o\"></i>";
		}
	}	


$html="<table border=0><caption><h1>".ucfirst($strategy)." ".$instrument."</h1></caption><tr><td><b>Profit this month</b></td><td>".$profit." pips</td><td><b>Number of Trade</b></td><td>".$count."</td><td><b>24H profit</b></td><td>".$dayprofit." pips</td><td><b>Maximal DD</b></td><td>".$drawdown." pips</td></tr>";
$html.="<tr><td><b>Average winning trade</b></td><td>".$awt." pips</td><td><b>Average Loosing Trade</b></td><td>".$alt." pips</td><td><b>Winning %</b></td><td>".$winningperc." %</td><td><b>TBX SCORE</b></td><td>".$tbx_score."</td></tr></table>";
//.$winningperc." ".$awt." ".$alt." ".$tbx_score;
$html.="<div align=left> ".$addinfo."</div>";
//$file=@fopen("html/".$signature.".html","w");
//@fputs($file,$html);
//@fclose($file);

$aa++;
$except=0;
$delta=time()-$timeinsert-$_MODIFY_DELTA; 
if (($tbx_score>0) && ($tbx_score<3))
{

echo "<div id='eachcurrencybad' style='float: left;'>";
$except=1;
}

if ($tbx_score>7)
{
echo "<div id='eachcurrencygood' style='float: left;'>";
$except=1;
}

// SEND TO TWITTER & RSS PRODUCTION //
$_rss="";
if ($aa==1)
	{
		if (!(file_exists("twitter-php-master/examples/signature/".$signature.".txt")))
			{
				
				$file=fopen("twitter-php-master/examples/signature/".$signature.".txt","w");
				fputs($file,"+");
				fclose($file);
				
				if ($sl<0.1) {$sl="(ea)";}
				
				if ($tp<0.1) {$tp="(ea)";}
				
				$instrumentX=str_replace(".","",$instrument);
				$message="#".str_replace("_4","",$instrumentX)." strategy #".$strategy." ".sellbuy($command)." SL :".$sl." TP:".$tp. " . ".$profit. " pips since inception. See www.thirdbrainfx.com #forex #finance";
				$message2="#".str_replace("_4","",$instrumentX)." strategy #".$strategy." ".sellbuy($command)." SL :".$sl." TP:".$tp. " . #ID".$id. " Check performance at www.thirdbrainfx.com #forex #finance";
				
				$title_rss=$instrument." strategy ".$strategy." ".sellbuy($command)." SL :".$sl." TP:".$tp. " Order :#".$id;
				$message_rss=strip_tags($whenopen."<br>".$title_rss."<br>".$html. " <br>Strategy :".$strategy. " with ".$instrument. "  Order number :".$id);
				$_SEND=$message;
				$_SEND2=$message2;
				require_once 'twitter-php-master/src/twitter.class.php';
				
				if ($_MODE_TWITTER==1)
				{
					$twitter2 = new Twitter($consumerKey2, $consumerSecret2, $accessToken2, $accessTokenSecret2);

					try {
							
							$tweet = $twitter2->send($_SEND2); // you can add $imagePath as second argument

						} catch (TwitterException $e) {
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
				
				
				
				if ($profit > -200 ) 
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
				// RSS PRODUCTION
				
				$_rss=str_replace("[DATE]",$whenopen,$_RSSFEED);
				$_rss=str_replace("[TITLE]",$title_rss,$_rss);
				$_rss=str_replace("[DESCRIPTION]",$message_rss,$_rss);
				$_rss=str_replace("[IFLINK]","",$_rss);
				
				//$file=fopen("rss/lastrade.xml","w");
				//fputs($file,$_rss);
				//fclose($file);
				
				//
			}
	}

if ( ($aa==1) && ($except!=1))
{
	if ($delta<3)
	{
	echo "<div id='eachcurrencyfirst' style='float: left;'>";
	}
	else
	{
	echo "<div id='eachcurrency' style='float: left;'>";
	}
}
else
{
if ($except!=1)
{
echo "<div id='eachcurrency' style='float: left;'>";
}
}

$min=intval($delta/60);
$sec=$delta-$min*60;
if ($min>60) 
{
$heure=intval($min/60);
}
else
{
$heure=0;
$sec=$delta-$min*60;
}
/*
if (intval($sl)==0)
	{
	$sl=".";
	}
if (intval($tp)==0)
	{
	$tp=".";
	}
*/
$instrumentx=str_replace("_4","",$instrument);
echo "<h1>".$instrumentx."</h1>";
$P="select description from tradecomment where idtrade=".$id;
$PP=mysql_query($P);
list($description)=mysql_fetch_array($PP);
if ($description!="")
{
echo "<font size=-2>".$description."</font>";
}
//

$day=date("N");
if ($day==6) {$_SENDCOMMAND=0;}
if ($day==7) {$_SENDCOMMAND=0;}
if ($heure>0) {$_SENDCOMMAND=0;}
if ($min>1) {$_SENDCOMMAND=0;}
//



// onClick=\"javascript:registerTrade('".$signature."','".$token."');\"
echo"<div id='clicksign_".$signature ."'>".$addhtml."</div>";



if ($command==0) {echo"<font color=green><b>";} else {echo"<font color=red><b>";}
echo "<h2>".sellbuy($command). " <a href='charts.php?instrument=".$instrument."&strategy=".$strategy."'><i class='fa fa-bar-chart'></i></a></h2></font>";

if (($sl=="0") || ($tp=="0"))
{
echo"<b>Secret SL/TP</b><br>";
}
else
{
echo"<b>SL ".$sl. " TP:".$tp. "</b><br>";
}
echo "<font color=orange><b>".strtoupper($strategy)."</b></font></br>";
//echo "<b> profit : ".$profitTRADE. " pips</b><br>";

if (strlen($login)!=32)
		{
		
		//if (in_array($instrument,$_FX))
		// {	
		$SSS="select id,lot,accountpwd from portofolio_dashboard where accountid='".$login."' and instrument='".$instrument."' and strategy='".$strategy."'";
		//echo "<li>".$SSS;
		
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
	//if ($porthtml=="") {$porthtml="<b>#".$id."<b>";}
echo $porthtml;

if ($heure==0)
{
echo"<br>".$min." min ".$sec." sec ago<br>";
}
else
{
echo"<br>".$heure." hours ago";
}



echo"</div>";

}


include("end_db.php");
?>