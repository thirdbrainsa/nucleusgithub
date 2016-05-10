<?php
include ("config.php");
// SOME SECURITES CHECK


if (isset($_GET['signature']))
{
$signature=strip_tags(trim($_GET['signature']));
$_ACCOUNT=strip_tags(trim($_GET['accountid']));
$_LOT=strip_tags(trim($_GET['lot']));

if  ( (!(file_exists($_lock.$signature.$_ACCOUNT))) || (isset($_GET['bypass']) ))
{
// LOCK THE DB INSERTION RIGHT NOW...
// THE LOCK IS ONLY FOR THE USER THEN I ADD .$_ACCOUNT to the signature of the trades

$file=fopen($_lock.$signature.$_ACCOUNT,"w");
fputs($file,"");
fclose($file);
$goOn=1;
}
else
{
$goOn=0;
}

if (isset($_GET['close']))
{
$goOn=1;

}
//
}
else
{

}

if (strlen($signature)!=32)
{
exit;
}
//$goOn=1;
// END OF BASIC SECURITIES CHECK
// LOAD THE DATA

if ($goOn==1)
{
include ("connect_db.php");
$limitoftime=time()-$_limitoftime;
// GET THE DATA OF THE SIGNAL TO BE USED
if (!(isset($_GET['close'])))
{
$S1="select id,instrument, command,price,digit, sl, tp,swap,profit,spread,strategy from tradedb where signature='".$signature."' and timeinsert>".$limitoftime;
}
else
{
$S1="select id,instrument, command,price,digit, sl, tp,swap,profit,spread,strategy from tradedb where signature='".$signature."'";

}
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
  
$multi=multipips($instrument,$digit);

if ($multi!=0)

{

 if ($command==0)
  {
	// takeprofit asked 
	if ($niveau_tp!=0) $TP=intval( ($niveau_tp-$PRICE)/$multi);
	// stoploss asked
        if ($niveau_sl!=0) $SL=intval(($niveau_sl-$PRICE)/$multi);
  }else
  {
  
  // takeprofit asked 
	if ($niveau_tp!=0) $TP=intval(($PRICE-$niveau_tp)/$multi);
	// stoploss asked
        if ($niveau_sl!=0) $SL=intval(($PRICE-$niveau_sl)/$multi);
  
  
  }
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
   $SQLIP="select password from nucleus where account='".$_ACCOUNT."'";
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
	
	$SQLIP2="select password from nucleus where account='".$_ACCOUNT."'";
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
  echo"<li>".$order;
  echo"<li>".$QQ;
  $RR=mysql_query($QQ);
  list($id)=mysql_fetch_array($RR);
 
  if ($id=="")
  {
  // SEND THE TRADE OR NOT
  echo "<li>GO";

  // We don't check equity and margin for an a-book stuff and let it in the LP Side //
  $T="select account from abook where account='".$_ACCOUNT."'";
  $TT=mysql_query($T);
  list($account)=mysql_fetch_array($TT);
  if ($account=="")
  {
  $url_to_check=$_cron_path."getMarginBalanceEquity.php?login=".$_ACCOUNT;

  $content_balance=file_get_contents($url_to_check);
 $bem=explode("|",$content_balance);
 
 $balance_togo=$bem[0];
 $equity_togo=$bem[1];
 $margin_togo=$bem[2];
 echo"<li>".$balance_togo." ".$equity_togo." ".$margin_togo;
 if ($order!="CLOSE")
 {
 if ($balance_togo<0) {exit;}
 if ($equity_togo<0) {exit;}
 if ($margin_togo<0) {exit;}
 }
 
  $_estimation=($_LOT/0.01)*$_leverage_factor;
  $margin_after=$margin_togo-$_estimation;
}

if ($order!="CLOSE")
  {
  if  ($margin_after<0 ) { exit;}
}

  // Test if the user is in A-BOOK or NOT (means sent to xAPI or not). If not we don't insert in journal_php which is the "log" taken by the cron pusher to sent to xAPI
  // IS IT in A-BOOK or NOT ? sent to xAPI or not ?
    $S12="select account from abook where account='".$_ACCOUNT."'";
  $SS12=mysql_query($S12);
  list($abook)=mysql_fetch_array($SS12);
  
  
 if ($abook!="")
 {
  $SQL="insert into journal_php VALUES('','".$_ACCOUNT."','".$accountpwd."','".strtoupper($instrument)."','".strtoupper($order)."','".$_LOT."','".$PRICE."','".$DIGIT."','".$SL."','".$TP."','0','55','".$strategy."','".$signature."','".$timeinsert."','".$live."')";
echo "<li>".$SQL;
  mysql_query($SQL,$mysql);
    $ID_JOURNAL=mysql_insert_id();
  $SQL="insert into id_ticket VALUES('','".$ID_JOURNAL."','".$signature."')";
  mysql_query($SQL,$mysql);
  }
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
  
  if ($id!="")
  {
  //$SQL="select profit,swap from historydb where signature='".$signature."'";
  //$XX=mysql_query($SQL);
  //list($profit_t,$swap_t)=mysql_fetch_array($XX);
   $swap_t=0; 
    $total=$profit_t*$_LOT/0.10;
    echo "<li>Total Profit >".$total;
  $SQL="insert into history_client VALUES('','".$_ACCOUNT."','".$accountpwd."','".strtoupper($instrument)."','".strtoupper($order)."','".$_LOT."','".$PRICE."','".$total."','".$swap_t."','".$DIGIT."','".$SL."','".$TP."','0','55','".$strategy."',NOW(),'".$signature."','".$token."','".$live."')";
echo"<li>".$SQL;
 $querySQL=mysql_query($SQL,$mysql);
 echo mysql_error();
 $idhistory=mysql_insert_id();
 /*$file=fopen("logb.txt","w");
 fputs($file,$SQL);
 fclose($file);
*/
   // echo mysql_error();
  $SQL="update balance set balance=balance+".$total." where account='".$_ACCOUNT."'";
  mysql_query($SQL);
   //echo mysql_error();
  $SQL="delete from trade_running where signature='".$signature."' and accountid='".$_ACCOUNT."'";
  echo "<li>".$SQL;
  mysql_query($SQL);
  //echo mysql_error();
    // BONUS MANAGEMENT

		$bonus=1*$_LOT;
		
		$RT="select account from bonus where account='".$_ACCOUNT."'";
		$R1=mysql_query($RT);
		list ($account)=mysql_fetch_array($R1);
		if ($account=="")
		{
		//$SQL="insert into bonus values ('".$_ACCOUNT."','".$bonus."',NOW())";
		//mysql_query($SQL);
	
		}
		else
		{
		
		/*$SQL="update bonus set balance=balance+".$bonus." where account='".$_ACCOUNT."'";
		mysql_query($SQL);
		*/
		}
	
				// Commission is computed in the initial currency of the transaction
				// Commision based in the original currency.
				
				// conversion of the commission in USD from the original currency
				
				// get the original currency
				$original=substr($instrument,0,3);
				$searchfor1=$original."USD";
				$searchfor2="USD".$original;
				$SQL="select ask,bid from rates where instrument='".$searchfor1."' order by timestamp desc limit 0,1";
				$S=mysql_query($SQL);
				list ($ask,$bid)=mysql_fetch_array($S);
				if ($ask!="")
				{
					$rates=($ask+$bid)/2;
	
	
				}	
				else
	
				{
					$SQL="select ask,bid from rates where instrument='".$searchfor2."' order by timestamp desc limit 0,1";
					$S=mysql_query($SQL);
					list ($ask,$bid)=mysql_fetch_array($S);
					$rates=($ask+$bid)/2;
	
				}
				$commission=-1*abs(($_RATE_COMMISSION/100)*$_LOT*100000*$rates);
				
				if (abs($commission)<0.01) {$commission=0.01;}
				
				$SQL="insert into commission values ('".$idhistory."','".$commission."')";
				mysql_query($SQL);
				
				$SQL="update balance set balance=balance-".abs($commission)." where account='".$_ACCOUNT."'";
				mysql_query($SQL);
	
			
  
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
}
else
{
echo"ALREADY SENT";

}
?>