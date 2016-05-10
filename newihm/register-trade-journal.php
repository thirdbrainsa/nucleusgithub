<?php
set_time_limit(0);
// SOME SECURITES CHECK
if (isset($_GET['signature']))
{
$signature=strip_tags(trim($_GET['signature']));
if (isset($_GET['token']))
	{
		$token=strip_tags(trim($_GET['token']));
		if (strlen($token)!=32)
			{
			exit;
				
			}
	}
}
else
{
exit;
}

if (strlen($signature)!=32)
{
exit;
}

// END OF BASIC SECURITIES CHECK
// LOAD THE DATA

include ("config.php");
include ("connect_db.php");

// GET THE DATA OF THE SIGNAL TO BE USED
$S1="select id,instrument, command,price,digit, sl, tp,swap,profit,spread,strategy from tradedb where signature='".$signature."'";
$Q1=mysql_query($S1);
list ($id,$instrument,$command,$PRICE,$DIGIT,$niveau_sl,$niveau_tp,$swap_t,$profit_t,$spread,$strategy)=mysql_fetch_array($Q1);
if ($id=="")
{
$S1="select id,instrument,command,price,digit,profit,comment from trade_running where signature='".$signature."'";
$Q1=mysql_query($S1);
echo mysql_error();
list ($id,$instrument,$command,$PRICE,$DIGIT,$profit_t,$strategy)=mysql_fetch_array($Q1);
}
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
  
if ($niveau_tp==0) {$TP=280;}
if ($niveau_sl==0) {$SL=300;}
if ($niveau_sl==0.025) {$SL=300;}
if ($niveau_sl==0.026) {$SL=300;}

  //echo "<li>".$TP." ".$SL;
  //
  
  $SQL_D="delete from temp_login where whenregister < NOW() - INTERVAL 1 DAY";
  mysql_query($SQL_D);
  //
  $IP=$_SERVER['REMOTE_ADDR'];
  $SQLIP="select login,password,lotsize,whenregister from temp_login where ip='".$IP."' and token='".$token."'";
  //echo "<li>".$SLQIP;
  $TT=@mysql_query($SQLIP,$mysql);
  //echo mysql_error();
  list ($accountid,$accountpwd,$lot,$whenregister)=mysql_fetch_array($TT);
      
  if ($accountid=="") 
  {
       echo "BAD";exit;
  }
  else
  {
  $login_to_check=$accountid;
  $url=$_cron_path."rightsoftrade.php?login_to_check=".$login_to_check;
  $_check=file_get_contents($url);
  $margin_tobeused=round((($lot/0.01)*$_leverage_factor),2);
  if ($margin_tobeused>$_check)
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
  if (strlen($accountid)==7)
  {
  $live=1;
  }
  else
  {
  $live=0;
  }
  

  
  $SQL="insert into journal_php VALUES('','".$accountid."','".$accountpwd."','".strtoupper($instrument)."','".strtoupper($order)."','".$lot."','".$PRICE."','".$DIGIT."','".$SL."','".$TP."','0','55','".$strategy."','".$signature."','".$timeinsert."','".$live."')";
  mysql_query($SQL,$mysql);
  $ID_JOURNAL=mysql_insert_id();
  
  $SQL="insert into id_ticket VALUES('','".$ID_JOURNAL."','".$signature."')";
  mysql_query($SQL,$mysql);
  
  $SQL="insert into trade_taken VALUES('','".$accountid."','".$accountpwd."','".strtoupper($instrument)."','".strtoupper($order)."','".$lot."','".$PRICE."','".$DIGIT."','".$SL."','".$TP."','0','55','".$strategy."',NOW(),'".$signature."','".$token."','".$live."')";
  mysql_query($SQL,$mysql);
  
  if (($order=="BUY") || ($order=="SELL"))
  {
   
   $SQL="insert into trade_running VALUES('','".$accountid."','".$accountpwd."','".strtoupper($instrument)."','".strtoupper($order)."','".$lot."','".$PRICE."','".$profit_t."','".$swap_t."','".$DIGIT."','".$SL."','".$TP."','0','55','".$strategy."',NOW(),'".$signature."','".$token."','".$live."')";
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
  $total=$profit_t*$lot/0.10;
  $SQL="insert into history_client VALUES('','".$accountid."','".$accountpwd."','".strtoupper($instrument)."','".strtoupper($order)."','".$lot."','".$PRICE."','".$total."','".$swap_t."','".$DIGIT."','".$SL."','".$TP."','0','55','".$strategy."',NOW(),'".$signature."','".$token."','".$live."')";
//echo"<li>".$SQL;

 $querySQL=mysql_query($SQL,$mysql);
 $idhistory=mysql_insert_id();
 

   // echo mysql_error();
  $SQL="update balance set balance=balance+".$total." where account='".$accountid."'";
  mysql_query($SQL);
   //echo mysql_error();
  $SQL="delete from trade_running where signature='".$signature."'";
  mysql_query($SQL);
  //echo mysql_error();
  // BONUS MANAGEMENT

		$bonus=1*$lot;
		
		$RT="select account from bonus where account='".$accountid."'";
		$R1=mysql_query($RT);
		list ($account)=mysql_fetch_array($R1);
		if ($account=="")
		{
		//$SQL="insert into bonus values ('".$accountid."','".$bonus."',NOW())";
		//mysql_query($SQL);
	
		}
		else
		{
		
		//$SQL="update bonus set balance=balance+".$bonus." where account='".$accountid."'";
		//mysql_query($SQL);
		
		}
		
		if ($profit_t>0)
			{
				$commission=$_RATE_COMMISSION*$total;
				if ($commission<0.01) {$commission="0.01";}
				
				$SQL="insert into commission values ('".$idhistory."','".$commission."')";
				mysql_query($SQL);
	
			}
		
			
			
			
			
	
  }
  
  echo "GOOD";
}


//

include ("end_db.php");
?>