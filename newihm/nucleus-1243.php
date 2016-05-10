<link rel="stylesheet" href="css/onoff.css">
<link type="text/css" rel="stylesheet" href="css/message.css">
<link rel="stylesheet" href="css/signal.css">
    <link type="text/css" rel="stylesheet" href="css/box2.css">
 <link type="text/css" rel="stylesheet" href="css/table.css">
 <link rel="stylesheet" href="font/css/font-awesome.min.css">
 <script src="js/sortable.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
 <script type="text/javascript" src="js/manage.js?time=<?php echo time() ?>"></script>
<?php
session_start();include("librairies/manage.php");
include("config.php");


if (isset($_SESSION['login']))
{
 $_ACCOUNT=$_SESSION['login'];
 $login=$_ACCOUNT;
 $token=$_SESSION['token'];
 $password=$_SESSION['password'];
 $balance=$_SESSION['balance'];
$ok=1;$guest=0;
 }
 else
 {
		if (isset($_GET['login']))
		{
			$login=strip_tags(trim($_GET['login']));
			$_ACCOUNT=$login;
			if ((strlen($login)<>6) && (strlen($login)<>7)) { exit;}
			include("connect_db.php");
			$T="select password from nucleus where account='".$login."'";
			$TT=mysql_query($T);
			list($password)=mysql_fetch_array($TT);
			include("end_db.php");
			$password_save=$password;
		
		}
		else
		{
		
		exit;
		
		}
 }

include("connect_db.php");

if  (!(isset($_GET['apply'])))
{
$G="delete from portofolio_nucleus where accountid='".$login."'";
mysql_query($G);
}
else
{
	$G="delete from portofolio_dashboard where accountid='".$login."'";
	mysql_query($G);
	
	$T="select instrument,strategy,lot from portofolio_nucleus where accountid='".$login."'";
	$TT=mysql_query($T);
	
	while (list($instrument,$strategy,$lot)=mysql_fetch_array($TT))
	{
						$time=time();
						$live=0;
						if (strlen($login)==7) {$live=1;}
						$SQL2="insert into portofolio_dashboard values ('','".$login."','".$password."','".$instrument."','".$strategy."','".$lot."','NUCLEUS','".$time."','".$live."')";
						mysql_query($SQL2);
	}
	$G="delete from portofolio_nucleus where accountid='".$login."'";
	
	mysql_query($G);
	
}
global $instrument,$token,$html2,$lastStrategy,$lastInstrument;

// THE INITIAL BALANCE AND EQUITY ///
//$MASTER="select account from nucleus";
//$QMASTER=mysql_query($MASTER);

//while (list($_ACCOUNT)=mysql_fetch_array($QMASTER))
//{
addMessage($_ACCOUNT," Nucleus init ");
$url_to_check=$_cron_path."getMarginBalanceEquity.php?login=".$_ACCOUNT;
$content_balance=file_get_contents($url_to_check);
$bem=explode("|",$content_balance);
$balance_togo=$bem[0];
$equity_togo=$bem[1];
$margin_togo=$bem[2];

if ($equity_togo<1000) {$nb_strat=1;}
if ($equity_togo>999) {$nb_strat=2;}
if ($equity_togo>10000) {$nb_strat=3;}
if ($equity_togo>20000) {$nb_strat=4;}
addMessage($_ACCOUNT," choose ".$nb_strat." master strategies - due to equity level");

for ($i=0;$i<$nb_strat;$i++)
{

//echo"<li>".$i;
$tour=0;
// Choose 5 best strategy candidate with minimal drawdown - the MASTER STRATEGY

$R1="select instrument,strategy,profit,drawdown,awt,alt from ranking where profit>200 AND ABS(profit/drawdown)>1.9 and count>10 and winningperc>50 and ABS(awt/alt)>1 and strategy<>'".$lastStrategy."' and instrument<>'".$lastInstrument."' order by RAND() limit 0,1";
//echo"<li>".$R1;     
$RR1=mysql_query($R1);
list($instrument,$strategy,$profit,$drawdown,$awt,$alt)=mysql_fetch_array($RR1);
echo mysql_error();
//echo"<li>".$instrument." ".$strategy;
$lastStrategy=$strategy;
$lastInstrument=$instrument;
//Echo "<li> Master strategy of ".$_ACCOUNT." picked up > ".$strategy." ".$instrument."<li>";
addMessage($_ACCOUNT," Master strategy pickup :".$strategy." ".$instrument);
$_PORTFOLIO_STRATEGY[]=$strategy;
$_PORTFOLIO_INSTRUMENT[]=$instrument;
$_PORTFOLIO_PROFIT[]=$profit;
$_PORTFOLIO_DD[]=$drawdown;
$_PORTFOLIO_ALT[]=$alt;

$S3="select instrument2,strategy2,correlation from advancedstats where instrument='".$instrument."' and strategy='".$strategy."' and correlation<-0.25 order by RAND() limit 0,1"; // MORE CORRELATED ONES
$RR3=mysql_query($S3);
list($ins,$strat,$corr)=mysql_fetch_array($RR3);
if ($ins=="")
{
$S3="select instrument,strategy,correlation from advancedstats where instrument2='".$instrument."' and strategy2='".$strategy."' and correlation<-0.25 order by RAND() limit 0,1"; // MORE CORRELATED ONES

}
$RR3=mysql_query($S3);
while (list($instrument2,$strategy2,$correlation)=mysql_fetch_array($RR3))
	{
	if (in_array($instrument2,$_FX))
	{
		$pc=round($correlation*100,2);
		$DD="select profit,drawdown,awt,alt from ranking where instrument='".$instrument2."' and strategy='".$strategy2."'";
		$K=mysql_query($DD);
		list($profitthis,$ddthis,$awt,$alt)=mysql_fetch_array($K);
			if ($profitthis>0)
				{
				$_PORTFOLIO_STRATEGY[]=$strategy2;
$_PORTFOLIO_INSTRUMENT[]=$instrument2;
$_PORTFOLIO_PROFIT[]=$profitthis;
$_PORTFOLIO_DD[]=$ddthis;
$_PORTFOLIO_ALT[]=$alt;
					//echo"<li>Secondary Strategy :".$strategy2." ".$instrument2."</li>";
					addMessage($_ACCOUNT," Second Strategy choosen :".$strategy2." ".$instrument2);
				}
	}
			
	}
echo $html2;

}

//print_r ($_PORTFOLIO_STRATEGY);
//print_r($_PORTFOLIO_INSTRUMENT);
echo"<table width=100%cellpadding=0 cellspacing=0>";
echo"<caption><a href='index.php'><i class='fa fa-arrow-left'></i></a> YOUR PORTOFOLIO WHICH IS RUNNING NOW</caption>"; 
echo"<thead><th>Add/Remove</th><th>Performances</th><th>Strategy selected</th><th>Instrument selected</th><th>Lot size selected</th></thead>";

$LL="select accountpwd,instrument,strategy,lot,comment from portofolio_dashboard where accountid='".$login."'";
$LLL=mysql_query($LL);
echo mysql_error();
while (list($accountpwd,$instrument,$strategy,$lot,$comment)=mysql_fetch_array($LLL))
{

echo"<tr>";
	echo"<td>";
	if (strlen($login)!=32)
		{
		$SSS="select id,lot,accountpwd from portofolio_dashboard where accountid='".$login."' and instrument='".$instrument."' and strategy='".$strategy."'";
		}
		else
		{
		$SSS="select id,lot,accountpwd from portofolio_dashboard_guest where accountid='".$login."' and instrument='".$instrument."' and strategy='".$strategy."'";
		
		}
		//echo "<li>".$SSS;
		$rrr=mysql_query($SSS);
		list($id_portfolio,$lot_size,$_password_inside)=mysql_fetch_array($rrr);
		if (($_password_inside!=$password) && ($_password_inside!=""))
		{
			$message=" Your portfolio was created with an another password for your account. We have detected 2 passwords differents, we need to state on what is the good ones for security reasons. You need to re-synchronize by login giving the right password, logout and login again <a href='logout.php'>Logout</a>. <br> If you made a change directly inside xStation, please contact support at support@thirdbrain.ch, we will check and change the password inside your portfolio. During this time the trade are blocked and won't be send (except close orders).";
			$_ERROR=1;$addhtml="AUTOTRADING DISABLED";
			
		}
		else
		{
		$_ERROR=0;
		
		}
		//if (($password==$login) && ($login!="")) {$_ERROR=1;}
		if ($_ERROR!=1)
		{
		
		if (in_array($instrument,$_FX))
		 {
						
						
		if ($id_portfolio=="")
			{
			echo"<div id='por_".$strategy.$instrument."'><a href=\"javascript:registerPortfolio('".$login."','".$token."','".$strategy."','".$instrument."');\"'><i class=\"fa fa-square-o fa-2x\"></i></a></div>";
			echo"<div id='lot_".$strategy.$instrument."'></div>";
			
			}
		else
			{
			echo"<div id='por_".$strategy.$instrument."'><a href=\"javascript:removePortfolio('".$login."','".$token."','".$strategy."','".$instrument."');\"><i class=\"fa fa-check-square fa-2x\"></i></a></div>";
			echo"<div id='lot_".$strategy.$instrument."'><a href=\"javascript:changelotsizedown('".$lot_size."','".$login."','".$token."','".$strategy."','".$instrument."');\"'><i class=\"fa fa-sort-desc fa-2x\"></i></a> ".$lot_size."</a> <a href=\"javascript:changelotsizeup('".$lot_size."','".$login."','".$token."','".$strategy."','".$instrument."');\"'><i class=\"fa fa-sort-asc fa-2x\"></i></a></div>";
		
			}
		 }
		else
		 {

			echo "<div id='por_".$strategy.$instrument."'>Not available for autotrading</div>";
			

		}
	        }
	echo"</td>";
	echo "<td><a href='charts.php?strategy=".$strategy."&instrument=".$instrument."'><i class='fa fa-bar-chart fa-2x'></i></a></td><td>".$strategy."</td><td>".$instrument."</td><td>".$lot."</td></tr>";
}
echo"</table>";



echo"<table width=100%cellpadding=0 cellspacing=0>";
echo"<caption><a href='index.php'><i class='fa fa-arrow-left'></i></a> THE GOLDEN PORTFOLIO WE ADVICE YOU TO SELECT NOW AND FOR NEXT WEEK</caption>"; 
echo"<thead><th>Add/Remove</th><th>Performances</th><th>Strategy recommended</th><th>Instrument recommended</th><th>Lot size recommended</th></thead>";
foreach ($_PORTFOLIO_STRATEGY as $key=>$value)
{
	$strategy=$value;
	$instrument=$_PORTFOLIO_INSTRUMENT[$key];
	$DIVIDE=$_PORTFOLIO_DD[$key]/$equity_togo;
	//echo "<li>".$_PORTFOLIO_DD[$key]." ".$DIVIDE;
	$lot_size="0.01";
	if ($DIVIDE>0.05)
		{
			$lot_size="0.01";
		
		}
		else
		{
		   $MARCHE=0.05/$DIVIDE;
		   $lot_size=$MARCHE/100;
		   //echo "<li> M:".$MARCHE;
		   //echo"<li> LS :".$lot_size;
		}
	if (abs($lot_size)<0.01) {$lot_size="0.01";}
	if (abs($lot_size)>1.00) {$lot_size="1.00";}
	 
	$lot_size=round($lot_size,2);
//echo"<li>A:".$lot_size;
	$_PORTFOLIO_LOTSIZE[]=abs($lot_size);
	echo"<tr>";
	echo"<td>";
	if (strlen($login)!=32)
		{
		$SSS="select id,lot,accountpwd from portofolio_dashboard where accountid='".$login."' and instrument='".$instrument."' and strategy='".$strategy."'";
		}
		else
		{
		$SSS="select id,lot,accountpwd from portofolio_dashboard_guest where accountid='".$login."' and instrument='".$instrument."' and strategy='".$strategy."'";
		
		}
		//echo "<li>".$SSS;
		$rrr=mysql_query($SSS);
		list($id_portfolio,$lot_size,$_password_inside)=mysql_fetch_array($rrr);
		if (($_password_inside!=$password) && ($_password_inside!=""))
		{
			$message=" Your portfolio was created with an another password for your account. We have detected 2 passwords differents, we need to state on what is the good ones for security reasons. You need to re-synchronize by login giving the right password, logout and login again <a href='logout.php'>Logout</a>. <br> If you made a change directly inside xStation, please contact support at support@thirdbrain.ch, we will check and change the password inside your portfolio. During this time the trade are blocked and won't be send (except close orders).";
			$_ERROR=1;$addhtml="AUTOTRADING DISABLED";
			
		}
		else
		{
		$_ERROR=0;
		
		}
		//if (($password==$login) && ($login!="")) {$_ERROR=1;}
		if ($_ERROR!=1)
		{
		
		if (in_array($instrument,$_FX))
		 {
						$time=time();
						$live=0;
						if (strlen($login)==7) {$live=1;}
						$SQL2="insert into portofolio_nucleus values ('','".$login."','".$password."','".$instrument."','".$strategy."','".$_PORTFOLIO_LOTSIZE[$key]."','','".$time."','".$live."')";
						mysql_query($SQL2);
						
		if ($id_portfolio=="")
			{
			echo"<div id='por_".$strategy.$instrument."'><a href=\"javascript:registerPortfolio('".$login."','".$token."','".$strategy."','".$instrument."');\"'><i class=\"fa fa-square-o fa-2x\"></i></a></div>";
			echo"<div id='lot_".$strategy.$instrument."'></div>";
			
			}
		else
			{
			echo"<div id='por_".$strategy.$instrument."'><a href=\"javascript:removePortfolio('".$login."','".$token."','".$strategy."','".$instrument."');\"><i class=\"fa fa-check-square fa-2x\"></i></a></div>";
			echo"<div id='lot_".$strategy.$instrument."'><a href=\"javascript:changelotsizedown('".$lot_size."','".$login."','".$token."','".$strategy."','".$instrument."');\"'><i class=\"fa fa-sort-desc fa-2x\"></i></a> ".$lot_size."</a> <a href=\"javascript:changelotsizeup('".$lot_size."','".$login."','".$token."','".$strategy."','".$instrument."');\"'><i class=\"fa fa-sort-asc fa-2x\"></i></a></div>";
		
			}
		 }
		else
		 {

			echo "<div id='por_".$strategy.$instrument."'>Not available for autotrading</div>";
			

		}
	        }
	echo"</td>";
	echo "<td><a href='charts.php?strategy=".$strategy."&instrument=".$instrument."'><i class='fa fa-bar-chart fa-2x'></i></a></td><td>".$value."</td><td>".$_PORTFOLIO_INSTRUMENT[$key]."</td><td>".$_PORTFOLIO_LOTSIZE[$key]."</td></tr>";
}
echo"</table>";
echo "<center><a href='nucleus.php?apply' class='large green button'>REPLACE YOUR PORTFOLIO AND APPLY ALL THIS STRATEGY TO YOUR PORTFOLIO</a></center>";
//print_r($_PORTFOLIO_STRATEGY);print_r($_PORTFOLIO_INSTRUMENT);print_r($_PORTFOLIO_LOTSIZE);
include("end_db.php");
?>