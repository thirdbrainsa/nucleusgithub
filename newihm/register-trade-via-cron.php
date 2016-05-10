<?php
// SOME SECURITES CHECK
if (isset($_GET['signature']))
{
$signature=strip_tags(trim($_GET['signature']));
$_ACCOUNT=strip_tags(trim($_GET['accountid']));
$_LOT=strip_tags(trim($_GET['lot']));
}
else
{

}

if (strlen($signature)!=32)
{
exit;
}

// END OF BASIC SECURITIES CHECK
// LOAD THE DATA

include ("config.php");
include ("connect_db.php");
$login_to_check=$_ACCOUNT;
  $url=$_cron_path."rightsoftrade.php?login_to_check=".$login_to_check;
$_check=file_get_contents($url);
//include("rightsoftrades.php");
// GET THE DATA OF THE SIGNAL TO BE USED
$S1="select id,instrument, command,price,digit, sl, tp,swap,profit,spread,strategy from tradedb where signature='".$signature."'";
$Q1=mysql_query($S1);
list ($id,$instrument,$command,$PRICE,$DIGIT,$niveau_sl,$niveau_tp,$swap_t,$profit_t,$spread,$strategy)=mysql_fetch_array($Q1);


if ($id=="")
{
 echo"BAD";exit;
 
}
else
{

  /// TEST USER/PASS 
  /// Niveau
  $digit=$DIGIT;
  $SL=0;$TP=0;
if ($digit==5) {$multi=10000;}
if ($digit==4) {$multi=10000;}
if ($digit==3) {$multi=100;}
if ($digit==2) {$multi=10;}
if ($digit==1) {$multi=10;}
if ($digit==0) {$multi=1;}



 if ($command==0)
  {
	// takeprofit asked 
	if ($niveau_tp!=0) $TP=intval( ($niveau_tp-$PRICE)*$multi);
	// stoploss asked
        if ($niveau_sl!=0) $SL=intval(($niveau_sl-$PRICE)*$multi);
  }else
  {
  
  // takeprofit asked 
	if ($niveau_tp!=0) $TP=intval(($PRICE-$niveau_tp)*$multi);
	// stoploss asked
        if ($niveau_sl!=0) $SL=intval(($PRICE-$niveau_sl)*$multi);
  
  
  }
  //
if ($niveau_tp==0) {$TP=280;}
if ($niveau_sl==0) {$SL=300;}
if ($niveau_sl==0.025) {$SL=300;}
if ($niveau_sl==0.026) {$SL=300;}
  //
  $IP=$_SERVER['REMOTE_ADDR'];
  if (isset($_GET['fullauto']))
  {
   $SQLIP="select password from automated where account='".$_ACCOUNT."'";
  }
  else
  {
  $SQLIP="select accountpwd from portofolio_dashboard where accountid='".$_ACCOUNT."'";
  }
    
  echo "<li>".$SQLIP;
  $TT=@mysql_query($SQLIP,$mysql);
  echo mysql_error(); 
  list ($accountpwd)=mysql_fetch_array($TT);
      
  if ($accountpwd=="") 
  {
	// Second Try with automated //
	
	$SQLIP2="select password from automated where account='".$_ACCOUNT."'";
	$TTT=mysql_query($SQLIP2);
	list($accountpwd)=mysql_fetch_array($TTT);
	if ($accountpwd=="")
	{
              echo "BAD";exit;
	}
  }

 
  if ($command==0) {$order="BUY";} else {$order="SELL";}
  if (isset($_GET['close']))
	{
		$order="CLOSE";
	}
  $timeinsert=time();
  if (strlen($_ACCOUNT)==7)
  {
  $live=1;
  }
  else
  {
  $live=0;
  }
  if ($order!=="CLOSE")
  {
  $QQ="select id from trade_taken where signature='".$signature."' and accountid='".$_ACCOUNT."'";
  }
  else
  {
  $QQ="select id from trade_taken where signature='".$signature."' AND command='CLOSE' and accountid='".$_ACCOUNT."'";
    
  }
  $RR=mysql_query($QQ);
  list($id)=mysql_fetch_array($RR);
 
  if ($id=="")
  {
   $margin_tobeused=round((($_LOT/0.01)*$_leverage_factor),2);
  if ($margin_tobeused>$_check)
	{
	echo "BAD";exit;
	}
  
  $SQL="insert into journal_php VALUES('','".$_ACCOUNT."','".$accountpwd."','".strtoupper($instrument)."','".strtoupper($order)."','".$_LOT."','".$PRICE."','".$DIGIT."','".$SL."','".$TP."','0','55','".$strategy."','".$signature."','".$timeinsert."','".$live."')";
  mysql_query($SQL,$mysql);
  $ID_JOURNAL=mysql_insert_id();
  $SQL="insert into id_ticket VALUES('','".$ID_JOURNAL."','".$signature."')";
  mysql_query($SQL,$mysql);
  $token="AUTOMATED";
  $SQL="insert into trade_taken VALUES('','".$_ACCOUNT."','".$accountpwd."','".strtoupper($instrument)."','".strtoupper($order)."','".$_LOT."','".$PRICE."','".$DIGIT."','".$SL."','".$TP."','0','55','".$strategy."',NOW(),'".$signature."','".$token."','".$live."')";
  mysql_query($SQL,$mysql);
  
   if (($order=="BUY") || ($order=="SELL"))
  {
   
   $SQL="insert into trade_running VALUES('','".$_ACCOUNT."','".$accountpwd."','".strtoupper($instrument)."','".strtoupper($order)."','".$_LOT."','".$PRICE."','".$profit_t."','".$swap_t."','".$DIGIT."','".$SL."','".$TP."','0','55','".$strategy."',NOW(),'".$signature."','".$token."','".$live."')";
   mysql_query($SQL,$mysql);
  }
  else
  {
  //echo "<li> CLOSING";
  $SQL="select id,accountid,accountpwd,instrument,command,lot,price,profit,swap,digit,sl,tp,open,taken,comment,timeinsert,signature,token,live from trade_running where signature='".$signature."'";
  //echo"<li>".$SQL;
  $R3=mysql_query($SQL,$mysql);
  //echo mysql_error();
  list ($id,$accountid,$accountpwd,$instrument,$order,$lot,$PRICE,$profit_t,$swap_t,$DIGIT,$SL,$TP,$open,$taken,$strategy,$timeinsert,$signature,$token,$live)=mysql_fetch_array($R3);
  $SQL="insert into history_client VALUES('','".$_ACCOUNT."','".$accountpwd."','".strtoupper($instrument)."','".strtoupper($order)."','".$_LOT."','".$PRICE."','".$profit_t."','".$swap_t."','".$DIGIT."','".$SL."','".$TP."','0','55','".$strategy."',NOW(),'".$signature."','".$token."','".$live."')";
//echo"<li>".$SQL;
 mysql_query($SQL,$mysql);
  $total=$profit_t;
   // echo mysql_error();
  $SQL="update balance set balance=balance+".$total." where account='".$_ACCOUNT."'";
  mysql_query($SQL);
   //echo mysql_error();
  $SQL="delete from trade_running where signature='".$signature."'";
  mysql_query($SQL);
  //echo mysql_error();
  
  // BONUS MANAGEMENT
  if ($profit_t<0)
	{
		$bonus=$spread*$_LOT;
		
		$RT="select account from bonus where account='".$_ACCOUNT."'";
		$R1=mysql_query($RT);
		list ($account)=mysql_fetch_array($R1);
		if ($account=="")
		{
		$SQL="insert into bonus values ('".$_ACCOUNT."','".$bonus."',NOW())";
		mysql_query($SQL);
	
		}
		else
		{
		
		$SQL="update bonus set balance=balance+".$bonus." where account='".$_ACCOUNT."'";
		mysql_query($SQL);
		
		}
	}
  
  
  
  }
  
  
  echo "INSERT";
  }
  else
  {
  echo "NO INSERT";
  
  }
}


//

include ("end_db.php");
?>