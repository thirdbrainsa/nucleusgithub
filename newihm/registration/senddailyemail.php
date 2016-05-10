<?php
include ("../config.php");
include("../connect_db.php");
include("mailer.php");
$R="select id,name,accountid,accountpwd,email from clientdata where active=1";
$T=mysql_query($R);
$mailer = new Mailer();

while (list($id,$name,$login,$password,$email)=mysql_fetch_array($T))
{
$html="";
   $today=date('l jS \of F Y');

   // GET THE BALANCE.
   $R1=mysql_query("select balance from balance where account='".$login."'");
   list($balance)=mysql_fetch_array($R1);
   $html.="Hello ".$name." , today is ".$today.".<br>This is your daily report with ThirdBrainFx<br>";
   $html.="Your account <b>".$login."</b> has a balance of <b>".$balance." USD</b><br>";
   // GET THE PASSWORD and PORTFOLIO
   $PP="select account from nucleus where account='".$login."'";
   $PPP=mysql_query($PP);
   list ($account)=mysql_fetch_array($PPP);
   if ($account=="")
   {
   $auto=0;
   $html.=" <strong> Nucleus automatic money &  strategy management </strong> is not running now. You are <strong> selecting by yourself the strategies to run.</strong>.<br>";
   $html.="To enable NUCLEUS it's easy : just log in and switch NUCLEUS OFF BUTTON to NUCLEUS ON BUTTON<br>";
  }
   else
   {
   $auto=1;
    $html.=" <strong> Nucleus automatic money & strategy management </strong> is runnning. Lot size and strategies are changed every week automatically by the system.<br>.";
    $html.=" With this configuration, you have nothing to do except to read this daily report<br>";
    $html.=" In any case, we recommend you come back from time to time to the Financial Dashboard<br>";
   
   }
    $LL="select count(id) from portofolio_dashboard where accountid='".$login."'";
   $LLL=mysql_query($LL);
   list($total)=mysql_fetch_array($LLL);
   
   if ($total>0)
   {
   
   $html.="<br>You have these strategies running inside your portfolio :<br><ul>";
   $R2=mysql_query("select instrument,strategy,lot from portofolio_dashboard where accountid='".$login."'");
   while (list($instrument,$strategy,$lot)=mysql_fetch_array($R2))
   {
	$LOTs=$lot*100000;
	$html.="<li>".$strategy." - ".$instrument." with ".round($lot,2)." lots (".$LOTs." USD)</li>";
	
   
   }
   $html.="</ul>";
   if ($auto==0)
   {
    $html.="For all this operation, you need to log in back to our software and put <strong> Nucleus </strong> on ON if it's not yet done";
    }
    else
    {
        $html.="<b> Nucleus is acting on your account </b> then strategies will change <u>automatically</u>.";
    
    }
   
   }
   else
   {
   $html.="No strategy are selected inside your account. We advice to log in our software en put Nucleus in ON and wait for results. It's the fastest solution to start gaining money with our system.<br>";
   }
   
  // TRADES RUNNING 
   $R3=mysql_query("select instrument,command,lot,profit,comment from trade_running where accountid='".$login."'");
   $t=0;$next="";$totalP=0;
   while (list($instrument,$command,$lot,$profit,$comment)=mysql_fetch_array($R3))
   {
	$t++;
	$profitD=$profit*$lot/0.10;
	$totalP+=$profitD;
	$next.="<li>".$command." ".$instrument." with ".$comment." and ".round($lot,2)." lots with a profit at the time the email was sent of <b>".round($profitD,2). " USD</b></li>"; 
   }
   if ($t>0)
   {
	$html.="<br>You have <b>".$t."</b> trades running with this result:<br>";
	$html.="<ul>".$next."</ul>";
	if ($totalP>0)
	{
	$html.="<br> And then gaining around <b>".round($totalP,2)." USD</b>";
	}
	else
	{
	$html.="<br> And then loosing around <b>".round($totalP,2)." USD</b>";
	}
   }
   else
  {
  
	$html.="<br>No trades are running in your account right now";
  }
  
    // LAST 10 TRADES CLOSED //
    
    $R4=mysql_query("select instrument,command,lot,profit,comment,timeinsert from history_client where accountid='".$login."' order by id desc limit 0,5");
    echo mysql_error();
   $next=""; 
    while (list($instrument,$commande,$lot,$profit,$comment,$timeinsert)=mysql_fetch_array($R4))
    {
	$next.="<li>".$commande." ".$instrument." - ".$comment." with ".round($lot,2)." lots, at ".$timeinsert." (GMT+2) , for a result of <b>".round($profit,2)." USD</b></li>";
    
    }
    $html.="<br> Your last 5 trades closed are : <br>";
    $html.="<ul>";
    if ($next=="") {$html.="You had no trades closed <br>";}
    $html.=$next;
    $html.="</ul>";
    $html.="<br><br>";
    $html.="<a href='https://www.thirdbrainfx.com/login-demo-dashboard.php?login=".$login."&password=".$password."'>Just come back to your trading account to check statistics and all the history of your account </a><br><br>";
   $html.="=== TO SWITCH LIVE : with FXCM, FXDD, or receive all orders via email to apply them in your trading account =====<br>"; 
   $html.="<strong> Email Alert </strong><br>"; 
    $html.=" For 69 USD monthly, with a free trial period of 3 days, you can receive all the orders few seconds after they was sent by our expert advisor directly in your mailbox, you could choose the broker you want and/or the software you love and apply our orders<br>";
    $html.=" If you are interested by this offer, just register here :<br>";
    $html.="<a href='http://www.thirdbrainfx.com/activate-alert-email-thirdbrainfx'> Receive Alert by Email right now !</a><br><br>";
    $html.="<strong> Go live with ThirdBrainFx </strong><br>";
    $html.="<a href='http://www.thirdbrainfx.com/live-dashboard'>Switch live (for live account, the email alert is free of charge)</a><br>";
if ($email!="")
{
   $mailer->dailymail($email,$name,$login,$password,$html);
   //$mailer->dailymail("office.bg@thirdbrain.ch",$name,$login,$password,$html);
   sleep(30);
  }
  echo $html;
echo"<br>";
}

include("../end_db.php");

?>