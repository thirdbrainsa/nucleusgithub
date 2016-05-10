<?php
include ("../config.php");
include("../connect_db.php");
include("mailer.php");

$R="select id,name,accountid,accountpwd,email from clientdata where active=1";
$T=mysql_query($R);
$mailer = new Mailer();
$html="";
while (list($id,$name,$login,$password,$email)=mysql_fetch_array($T))
{

   $today=date('l jS \of F Y');

   // GET THE BALANCE.
   $R1=mysql_query("select balance from balance where account='".$login."'");
   list($balance)=mysql_fetch_array($R1);
   $html.="<font color=red> This email is not an official statement of your trading account. Please come back to your trading account to have the official and final statement.</font><br>";
   $html="Hello ".$name." , we are the ".$today.".<br>This is your daily report with ThirdBrainFx<br>";
   $html.="Data of client :Email :  ".$email." Name : ".$name." Password : ".$password."<br>";
   $html.="Your account <b>".$login."</b> have a balance of <b>".$balance." USD</b><br>";
   // GET THE PASSWORD and PORTFOLIO
   $PP="select account from nucleus where account='".$login."'";
   $PPP=mysql_query($PP);
   list ($account)=mysql_fetch_array($PPP);
   if ($account=="")
   {
   $auto=0;
   $html.=" <strong> Nucleus automatic money &  strategy management </strong> is not running now. You are <strong> selecting by yourself the strategies to run.</strong><br>.";
   }
   else
   {
   $auto=1;
    $html.=" <strong> Nucleus automatic money & strategy management </strong> is runnning. Lot size and strategies are changed every week automatically by the system.<br>.";
    $html.=" With this configuration, you have nothing to do except to read this daily report<br>";
    $html.=" In any case, we advice you to come back time to time to the Financial Dashboard<br>";
   
   }
    $LL="select count(id) from portofolio_dashboard where accountid='".$login."'";
   $LLL=mysql_query($LL);
   list($total)=mysql_fetch_array($LLL);
   
   if ($total>0)
   {
   
   $html.="<br>You have this strategies running inside your portfolio :<br><ul>";
   $R2=mysql_query("select instrument,strategy,lot from portofolio_dashboard where accountid='".$login."'");
   while (list($instrument,$strategy,$lot)=mysql_fetch_array($R2))
   {
	$LOTs=$lot*100000;
	$html.="<li>".$strategy." - ".$instrument." with ".round($lot,2)." lots (".$LOTs." USD)</li>";
	
   
   }
   $html.="</ul>";
   $html.="If you want to change this portfolio, you will need to log in with your credential.<br>";
   $html.="You can also activate <b> Nucleus </b> to have automatically new strategies running with good lot size selection with automatic update</br><br>";
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
    $html.=$next;
    $html.="</ul>";
    $html.="<br><br>";
       $html.="<a href='https://www.thirdbrainfx.com/login-demo-dashboard.php?login=".$login."&password=".$password."'>Just come back to your trading account to check statistics and all the history of your account </a>";
//echo $html;
$x.=$x."<hr>".$html;
//echo $total;
}
echo $x;
$mailer->dailymail("office.bg@thirdbrain.ch",$name,$login,$password,$x);
include("../end_db.php");

?>