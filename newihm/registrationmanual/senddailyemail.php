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
   $html="Hello ".$name." , we are the <b>".$today."</br>.<br><br>This is your daily report with <a href='https://www.thirdbrainfx.com'>ThirdBrainFx</a><br><br>";
   $html.="Your account <b>".$login."</b> have a balance of <b>".$balance." USD</b><br><br>";
   // GET THE PASSWORD and PORTFOLIO
   
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
   $html.="<br> If you want to change this portfolio, you will need to log in with your credential clicking here :<br>";
   $html.="<br> You can also activate <b> Nucleus </b> to have automatically new strategies running with good lot size selection with automatic update</br><br>";
    $html.="For all this operation, you need to log in back to our software and put <strong> Nucleus </strong> on ON if it's not yet done";
   }
     $html.="<a href='https://www.thirdbrainfx.com/login-demo-dashboard.php?login=".$login."&password=".$password."'> Log in Financial Dashboard </a>";
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
	$html.="<br> And then gaining around <b>".$totalP." USD</b>";
	}
	else
	{
	$html.="<br> And then loosing around <b>".$totalP." USD</b>";
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
       $html.="<a href='https://www.thirdbrainfx.com/login-demo-dashboard.php?login=".$login."&password=".$pass."'>Just come back to your trading account to check statistics and all the history of your account </a>";

   $mailer->dailymail($email,$name,$login,$pass,$html);
  
}
echo $html;
include("../end_db.php");

?>