<?php
### THIS CRON TAKE THE LATEST ORDER SENT , MIX WITH PORTFOLIO AND REGISTER TO JOURNAL_PHP THE GOOD TRADES.
include ("config.php");
include ("connect_db.php");
$test=TRUE;

while ($test)
{
### OPEN ORDERs###
$last5minutes=time()-5*60;$last5minutes=0;
$SQL22="SELECT id,command, instrument,price, sl, tp, profit,strategy,timeinsert,whenopen,signature from tradedb where command<2  and digit!=99 and timeinsert>".$last5minutes." ORDER BY timeinsert desc limit 0,10";
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
	
	if ($tbx_score>7)

	{
	$S3="select account,password,automated from automated";
	$R3=mysql_query($S3);
	while ( list ($accountid,$password,$lot)=mysql_fetch_array($R3))
		{
					
					   //Echo"<li> FULL AUTO ".$accountid." ".$password." ".$lot." send ".$strategy."/".$instrument." ".$signature."</li>";
					   $url_to_get=$_cron_path."/register-trade-via-cron.php?signature=".$signature."&accountid=".$accountid."&lot=".$lot."&fullauto=1";
					   //echo"<li>".$url_to_get;
					   file_get_contents($url_to_get);		
				
		}		
	}
	########
	### CHECK IF THIS COUPLE STRATEGY / PAIR EXIST INSIDE PORTFOLIO ####
	
	$S222="select accountid,accountpwd,lot from portofolio_dashboard where instrument='".$instrument."' and strategy='".$strategy."'";
	$r222=mysql_query($S222);
	//echo "<li>".$strategy."/".$instrument."</li>";
	while (list($accountid,$accountpwd,$lot)=mysql_fetch_array($r222))
		{
				### BROWSE ALL PORTFOLIO
				### TEST IF THE PORTFOLIO IS BLOCKED OR NOT
				
				$S2222="select block from blockportfolio where account='".$accountid."'";
				$r2222=mysql_query($S2222);
				list($block)=mysql_fetch_array($r2222);
				if ($block=="")
					{
					
					  //Echo"<li>".$accountid." ".$accountpwd." ".$lot." send ".$strategy."/".$instrument." ".$signature."</li>";
					   $url_to_get=$_cron_path."/register-trade-via-cron.php?signature=".$signature."&accountid=".$accountid."&lot=".$lot;
					   //echo"<li>".$url_to_get;
					   file_get_contents($url_to_get);
					
					
					}
					else
					{
					
					  //echo"<li> YES BUT ".$accountid." block</li>";
					
					
					}
		}

}

$SQL22="SELECT id,command, instrument,price, sl, tp, profit,strategy,timeinsert,whenopen,signature from historydb where command<2  and digit!=99 ORDER BY timeinsert desc limit 0,10";
//echo"<li>".$SQL22;
$S22=mysql_query($SQL22);
echo mysql_error();
$aa=0;
while (list($id,$command,$instrument,$price,$sl,$tp,$profitTRADE,$strategy,$timeinsert,$whenopen,$signature)=mysql_fetch_array($S22))
{
	### CHECK IF THIS COUPLE STRATEGY / PAIR EXIST INSIDE PORTFOLIO ####
	$S222="select accountid,accountpwd,lot from trade_taken where signature='".$signature."' and token='AUTOMATED'";
	$r222=mysql_query($S222);echo mysql_error();
	//echo "<li>".$strategy."/".$instrument."</li>";
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
					
					
					   //Echo"<li>".$accountid." ".$accountpwd." ".$lot." send close order ".$strategy."/".$instrument." ".$signature."</li>";
					   $url_to_get=$_cron_path."/register-trade-via-cron.php?signature=".$signature."&accountid=".$accountid."&lot=".$lot."&close=1";
					   //secho"<li>".$url_to_get;
					   file_get_contents($url_to_get);
					
					
					}
					else
					{
					
					 // echo"<li> YES BUT ".$accountid." block</li>";
					
					
					}
		}

}

}

include("end_db.php");
?>
<!--<meta http-equiv="refresh" content="2">-->
