<?php
### CHECK BALANCE ####
include("config.php");
include("connect_db.php");

$SQL="select distinct(accountid) from trade_running order by accountid desc"; 
$MMM=mysql_query($SQL);

while (list($login_to_check)=mysql_fetch_array($MMM))
{

$SQL="select balance from balance where account='".$login_to_check."'";
$SS=mysql_query($SQL);

list($balance_check)=mysql_fetch_array($SS);
echo"<hr>";
echo "<li>".$login_to_check." -".$balance_check;
### CHECK EQUITY ###
$SQL="select instrument,command,lot,price,digit,comment,signature from trade_running where accountid='".$login_to_check."'";
$SS=mysql_query($SQL);
$equitytt=0;$tlot=0;
while (list($instrument,$command,$lot,$priceopen,$digit,$strategy,$signature)=mysql_fetch_array($SS))
{
$tlot+=$lot;
$SH="select timestamp,ask,bid from rates where instrument='".$instrument."' order by timestamp desc";
$RRSH=mysql_query($SH);
list ($timestamp,$ask,$bid)=mysql_fetch_array($RRSH);
$time=time();
$diff=$time-$timestamp;
//echo "<li>".$diff;
if ($diff<60)
{
//Echo "<li>DIRECT RATES";
		$multi=multipips($instrument,$digit);
		
		$pricenow=($ask+$bid)/2;
		if ($command=="BUY")
		{
		$profit=(($pricenow-$priceopen)/$multi)*$lot/0.10;

		}
		else
		{
		$profit=-1*(($pricenow-$priceopen)/$multi)*$lot/0.10;
		
		}
		
		$SQLu="update trade_running set profit=".$profit." where signature='".$signature."'";
		mysql_query($SQLu);
}
else
{
//echo "<li>INDIRECT RATES";
$SQL2="select profit from tradedb where signature='".$signature."'";
$SSS=mysql_query($SQL2);
list($profit)=mysql_fetch_array($SSS);
$profitU=$profit*$lot/0.10;
$SQLu="update trade_running set profit=".$profitU." where signature='".$signature."'";
mysql_query($SQLu);
}
//echo"<li>".$instrument." ".$strategy." ".$lot." ".$profit." ".$swap;
	$equitytt+=($lot/0.10)*$profit;

}

// CHECK FOR BONUS
$B="select balance from bonus where account='".$login_to_check."'";
$BB=mysql_query($B);
list($bonus)=mysql_fetch_array($BB);

$equity_result=$balance_check+$equitytt+$bonus;


//echo "<li>Balance:".$balance_check." E:".$equity_result;
echo "<li>".$login_to_check." EQUITY : ".$equity_result;
$margin_used=round((($tlot/0.01)*$_leverage_factor),2);
$free_margin=$equity_result-$margin_used;

Echo "<li>FREE MARGIN:".$free_margin;


if ( ($equity_result<0) || ($free_margin<0))
 {
	$SQL="select lot,instrument,comment,signature from trade_running where accountid='".$login_to_check."'";
	$XS=mysql_query($SQL);
	$accountid=$login_to_check;
       //Echo"<li> EQUITY IS UNDER 0";
while (list($lot,$instrument,$strategy,$signature)=mysql_fetch_array($XS))
{
	

	$SQL="select id,accountid,accountpwd,instrument,command,lot,price,profit,swap,digit,sl,tp,open,taken,comment,timeinsert,signature,token,live from trade_running where signature='".$signature."'";
  //echo"<li>".$SQL;
	$R3=mysql_query($SQL,$mysql);
  //echo mysql_error();
	list ($id,$accountid,$accountpwd,$instrument,$order,$lot,$PRICE,$profit_t,$swap_t,$DIGIT,$SL,$TP,$open,$taken,$strategy,$timeinsert,$signature,$token,$live)=mysql_fetch_array($R3);
	$total=$profit_t*$lot/0.10;
	$SQL="insert into history_client VALUES('','".$accountid."','".$accountpwd."','".strtoupper($instrument)."','".strtoupper($order)."','".$lot."','".$PRICE."','".$total."','".$swap_t."','".$DIGIT."','".$SL."','".$TP."','0','55','".$strategy."',NOW(),'".$signature."','".$token."','".$live."')";
//echo"<li>".$SQL;
	mysql_query($SQL,$mysql);
	
   // echo mysql_error();
	$SQL="update balance set balance=balance+".$total." where account='".$accountid."'";
	mysql_query($SQL);
   //echo mysql_error();
	$SQL="delete from trade_running where signature='".$signature."' and account='".$accountid."'";
	mysql_query($SQL);
 }
 }
}
		
include("end_db.php");



?>