<?php
### CHECK BALANCE ####
if (!(isset($login_to_check))) 
{
	if (isset($_GET['login_to_check']))
		{
			$login_to_check=$_GET['login_to_check'];
		require("config.php");
		include("connect_db.php");
		}

}
$SQL="select balance from balance where account='".$login_to_check."'";
$SS=mysql_query($SQL);

list($balance_check)=mysql_fetch_array($SS);
if ($balance_check<0) {exit;}

### CHECK EQUITY ###
$SQL="select lot,instrument,comment,signature from trade_running where accountid='".$login_to_check."'";
$SS=mysql_query($SQL);
$equitytt=0;$tlot=0;
while (list($lot,$instrument,$strategy,$signature)=mysql_fetch_array($SS))
{
$tlot+=$lot;
$SQL2="select swap,profit from tradedb where signature='".$signature."'";
$SSS=mysql_query($SQL2);
list($swap,$profit)=mysql_fetch_array($SSS);

//echo"<li>".$instrument." ".$strategy." ".$lot." ".$profit." ".$swap;
	$equitytt+=($lot/0.10)*$profit+($lot/0.10)*$swap;
}
$equity_result=$balance_check+$equitytt;
//echo "<li>Balance:".$balance_check." E:".$equity_result;

$margin_used=round((($tlot/0.01)*$_leverage_factor),2);
$free_margin=$equity_result-$margin_used;

Echo $free_margin;


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
	$SQL="insert into history_client VALUES('','".$accountid."','".$accountpwd."','".strtoupper($instrument)."','".strtoupper($order)."','".$lot."','".$PRICE."','".$profit_t."','".$swap_t."','".$DIGIT."','".$SL."','".$TP."','0','55','".$strategy."',NOW(),'".$signature."','".$token."','".$live."')";
echo"<li>".$SQL;
	mysql_query($SQL,$mysql);
	
   // echo mysql_error();
	$SQL="update balance set balance=balance+".$total." where account='".$accountid."'";
	mysql_query($SQL);
   //echo mysql_error();
	$SQL="delete from trade_running where signature='".$signature."' and accountid='".$accountid."'";
	mysql_query($SQL);
 }
 }
if (isset($_GET['login_to_check']))
		{
		
		include("end_db.php");
		}


?>