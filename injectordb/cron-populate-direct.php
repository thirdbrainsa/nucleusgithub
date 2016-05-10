<?php
### THIS CRON TAKE THE LATEST ORDER SENT , MIX WITH PORTFOLIO AND REGISTER TO JOURNAL_PHP THE GOOD TRADES.
include ("connect_db.php");


### OPEN ORDERs###
if ($_CRON=="ORDER")
{
$last5minutes=time()-5*60;$last5minutes=0;
$SQL22="SELECT id,command, instrument,price, sl, tp, profit,strategy,timeinsert,whenopen,signature from tradedb where id=".$ID;
//echo"<li>".$SQL22;
$S22=mysql_query($SQL22);
echo mysql_error();
$aa=0;
while (list($id,$command,$instrument,$price,$sl,$tp,$profitTRADE,$strategy,$timeinsert,$whenopen,$signature)=mysql_fetch_array($S22))
{
	
	
	### CHECK IF THE STRATEGY IS GOOD
	$SS3="select tbx_score from ranking where instrument='".$instrument."' and strategy='".$strategy."'";
	$R4=mysql_query($SS3);
	list($tbx_score)=mysql_fetch_array($R4);
	
	if ($tbx_score>5)

	{
	$S3="select account from nucleus";
	$R3=mysql_query($S3);
	while ( list ($accountid)=mysql_fetch_array($R3))
		{
					$A="select account from abook where account='".$accountid."'";
					$AA=mysql_query($A);
					list($account)=mysql_fetch_array($AA);
					if ($account!="")
					{
						$B="select account from account_running where runningposition=0 and account='".$accountid."'";
						$BB=mysql_query($B);
						list ($account)=mysql_fetch_array($BB);
						if ($account!="")
						{
								$lot=0.01;
								$X="select goal,winsertdata,whenstop,moderisk from nucleusrun where account='".$accountid."'";
								$XX=mysql_query($X);
								list ($goal,$winsertdata,$whenstop,$moderisk)=mysql_fetch_array($XX);
								$X="select balance from balance where account='".$accountid."'";
								$XX=mysql_query($X);
								list ($balance)=mysql_fetch_array($XX);
								if ($balance>1000) {$multi=5;}
								if ($balance>5000) {$multi=10;}
								if ($balance>10000) {$multi=20;}
								if ($balance>20000) {$multi=40;}
								
								
								// Time until end of the run
								$datetime1 = new DateTime($now);
								$datetime2 = new DateTime($whenstop);
								$interval = $datetime1->diff($datetime2);
								$days=intval($interval->format('%R%a'));
								echo "<li>".$accountid." Days until end of run :".$days."</li>";
								
								$togo=100*($balance/$goal);
								if ($togo<50) {$multi=$multi+5;}
								
								if ($days<5) { if ($togo<80) {$multi=$multi+10;}}
														
								
								$lot=$lot*$moderisk*$multi;
								if ($lot<0.01) {$lot=0.01;}
								// Echo"<li> FULL AUTO ".$accountid." ".$password." ".$lot." send ".$strategy."/".$instrument." ".$signature."</li>";
								$url_to_get=$_URL_FOPEN."basetrade/register-trade-via-cron.php?signature=".$signature."&accountid=".$accountid."&lot=".$lot."&fullauto=1";
								echo"<li>".$url_to_get;
								file_get_contents($url_to_get);		
						}
					}
		}		
	}
	########
	### CHECK IF THIS COUPLE STRATEGY / PAIR EXIST INSIDE PORTFOLIO ####
	
	$S222="select accountid,accountpwd,lot from portofolio_dashboard where instrument='".$instrument."' and strategy='".$strategy."'";
	$r222=mysql_query($S222);
	echo "<li>".$strategy."/".$instrument."</li>";
	while (list($accountid,$accountpwd,$lot)=mysql_fetch_array($r222))
		{
				### BROWSE ALL PORTFOLIO
				### TEST IF THE PORTFOLIO IS BLOCKED OR NOT
				
				$S2222="select block from blockportfolio where account='".$accountid."'"; 
				echo"<li>".$S2222;
				$r2222=mysql_query($S2222);
				list($block)=mysql_fetch_array($r2222);
				echo"<li>".$block;
				if ($block=="")
					{
					$TK="select id from trade_taken where signature='".$signature."' and accountid='".$accountid."'";
					echo"<li>".$TK;
					$TTK=mysql_query($TK);
					list($IDK)=mysql_fetch_array($TTK);
					if ($IDK=="")
					{
					Echo"<li>".$accountid." ".$accountpwd." ".$lot." send ".$strategy."/".$instrument." ".$signature."</li>";
					$url_to_get=$_URL_FOPEN."basetrade/register-trade-via-cron.php?signature=".$signature."&accountid=".$accountid."&lot=".$lot;
					echo"<li>".$url_to_get;
					file_get_contents($url_to_get);
					//
				
					// LAUNCH MAILING OF THIS ONE
					$ALERT="select account from alertemail where account='".$accountid."'";
					$AA=mysql_query($ALERT);
					list($account)=mysql_fetch_array($AA);
					if ($account!="")
							{
								$timedelay=time()-2*60;
								$K="select id,instrument,command,strategy,price,sl,tp from tradedb where signature='".$signature."' and timeinsert>".$timedelay;
								$KK=mysql_query($K);
								list($id,$instrument,$command,$strategy,$price,$sl,$tp)=mysql_fetch_array($KK);
								if ($id!="")
								{
								$K2="select email from clientdata where accountid='".$accountid."'";
								$KK2=mysql_query($K2);
								list($emailtosend)=mysql_fetch_array($KK2);
								if ($emailtosend!="")
								{
								$_url_mailer=$_url_for_mailer."?id=".$id."&signature=".$signature."&email=".$emailtosend."&instrument=".$instrument."&command=".$command."&strategy=".$strategy."&price=".$price."&sl=".$sl."&tp=".$tp."&lot=".$lot;
								echo"<li>".$_url_mailer;
								file_get_contents($_url_mailer);
								}
								}
							}
					//
					}
					}
					else
					{
					
					 // echo"<li> YES BUT ".$accountid." block</li>";
					
					
					}
		}

}
}

if ($_CRON=="HISTORY")
{
echo"<li>HISTORY";
if ($ID!="")
{
$SQL22="SELECT id,command, instrument,price, sl, tp, profit,strategy,timeinsert,whenopen,signature from historydb where id=".$ID;
echo"<li>".$SQL22;
$S22=mysql_query($SQL22);
echo mysql_error();
$aa=0;   
while (list($id,$command,$instrument,$price,$sl,$tp,$profitTRADE,$strategy,$timeinsert,$whenopen,$signature)=mysql_fetch_array($S22))
{
	### CHECK IF THIS COUPLE STRATEGY / PAIR EXIST INSIDE PORTFOLIO ####
	$S222="select accountid,accountpwd,lot from trade_taken where signature='".$signature."' and token='AUTOMATED'";
	$r222=mysql_query($S222);echo mysql_error();
	echo "<li>".$strategy."/".$instrument."/".$signature."</li>";
	while (list($accountid,$accountpwd,$lot)=mysql_fetch_array($r222))
		{
				### BROWSE ALL PORTFOLIO
				### TEST IF THE PORTFOLIO IS BLOCKED OR NOT
				
				//$S2222="select block from blockportfolio where account='".$accountid."'";
				//$r2222=mysql_query($S2222);
				//list($block)=mysql_fetch_array($r2222);
				$block="";
				if ($block=="")
					{
					$TK="select id from trade_taken where signature='".$signature."' and accountid='".$accountid."' and command='CLOSE'";
					echo"<li>".$TK;
					$TTK=mysql_query($TK);
					list($IDK)=mysql_fetch_array($TTK);
					if ($IDK=="")
					{
					
					   Echo"<li>".$accountid." ".$accountpwd." ".$lot." send close order ".$strategy."/".$instrument." ".$signature."</li>";
					   $url_to_get=$_URL_FOPEN."basetrade/register-trade-via-cron.php?signature=".$signature."&accountid=".$accountid."&lot=".$lot."&close=1";
					   echo"<li>".$url_to_get;
									   
					  file_get_contents($url_to_get);
					
					$ALERT="select account from alertemail where account='".$accountid."'";
					$AA=mysql_query($ALERT);
					list($account)=mysql_fetch_array($AA);
													
					if ($account!="")
							{
								//
								$timedelay=time()-15*60;
								$K="select id,instrument,command,strategy,price,sl,tp from tradedb where signature='".$signature."' and timeinsert>".$timedelay;
								$KK=mysql_query($K);
								list($id,$instrument,$command,$strategy,$price,$sl,$tp)=mysql_fetch_array($KK);
								if ($id!="")
								{
								$K="select profit from historydb where signature='".$signature."'";
								$KK=mysql_query($K);
								list ($profit)=mysql_fetch_array($KK);
								
								$K2="select email from clientdata where accountid='".$accountid."'";
								$KK2=mysql_query($K2);
								list($emailtosend)=mysql_fetch_array($KK2);
								
								if ($emailtosend!="")
								{
								$_url_mailer=$_url_for_mailer."?id=".$id."&signature=".$signature."&close=1&email=".$emailtosend."&instrument=".$instrument."&command=".$command."&strategy=".$strategy."&price=".$price."&sl=".$sl."&tp=".$tp."&profit=".$profit;
								echo"<li>".$_url_mailer;
								file_get_contents($_url_mailer);
								}
								}
							}
					}
					}
					else
					{
					
					  echo"<li> YES BUT ".$accountid." block</li>";
					
					
					}
		}

}
}
}

include("end_db.php");
?>