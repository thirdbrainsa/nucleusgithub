<link rel="stylesheet" href="css/onoff.css">
<link type="text/css" rel="stylesheet" href="css/message.css">
<link rel="stylesheet" href="css/signal.css">
    <link type="text/css" rel="stylesheet" href="css/box2.css">
 <link type="text/css" rel="stylesheet" href="css/table.css">
 <link rel="stylesheet" href="font/css/font-awesome.min.css">
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="guide/css/slider.css">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css">
 <script src="guide/js/slider.js"></script>
 <script src="js/sortable.js"></script>
 <script type="text/javascript" src="js/manage.js?time=<?php echo time() ?>"></script>
<?php
session_start();include("librairies/manage.php");
include("config.php");
include("connect_db.php");

if (isset($_SESSION['login']))
{
 $_ACCOUNT=$_SESSION['login'];
 $login=$_ACCOUNT;
 $token=$_SESSION['token'];
 $password=$_SESSION['password'];
 $balance=$_SESSION['balance'];
$ok=1;$guest=0;

if  (!(isset($_GET['bypass'])))
{
$O="select account from nucleus where account='".$login."'";
$OO=mysql_query($O);
list ($account)=mysql_fetch_array($OO);
if ($account!="") 
{
echo "<h4><a href='index.php'>Go back to dashboard</a></h4>";
// ONLY DISPLAY THE ASSET CLASS PORTFOLIO MANAGEMENT STUFF
echo "<div id='adviceoutsideforex' style='visibility:hidden'></div>";


?>
<script>
function onclickvalue()
{  
var value=$("input:text").val();
window.location.href='setup-goal.php?risk='+value;
//alert(value);
}

</script>
<section id="content">
<?php
$S="select account,goal,winsertdata,whenstop from nucleusrun where account='".$_SESSION['login']."'";
$SS=mysql_query($S);
list($account,$goal,$when,$until)=mysql_fetch_array($SS);
if ($account=="")
{
?>
<h1> STEP 1/2<br>Setup your goal with <b>NUCLEUS</b> - Build your 'Money Run' </h1>
<br>
<h2><a href='javascript:onclickvalue()' class='large green button'>Go to step 2 by choosing the timeframe to reach your goal of gain </a></h2>
<br><h1>How much you want to try to gain (*) ?<br> (1% to 100%)</h1>
    
  <div class="cube">
    <div class="a"></div>
    <div class="b"></div>
    <div class="c"></div>
    <div class="d"></div>
    <div id="slider-range-min"></div>
  </div>

  <input type="text" id="amount" />

</section>
  <br>
<?php
}
else
{
$distance=intval($goal-$balance);
$completion=$balance/$goal;$completion=round($completion,2)*100;

	?>
		<h2> <a href='changemygoal.php' class='large green button'>I want to change my goals (becarefull this goal will be deleted forever)</a></h2><br>
	<h1> YOUR GOAL IS ALREADY SETUPED </h1>
	<h2> You setuped your goal on <font color=red><?php echo $when ?></font></h2>
	<h2> Your balance now is <font color=red><?php echo $balance ?></font> USD</h2>
	<h2> You want to reach a balance of <font color=red><?php echo $goal ?></font> USD before <font color=red><?php echo $until ?></font></h2>
	<h2> You still need to gain <font color=red><?php echo $distance ?></font> USD</h2>
	<h2> Your goal is <font color=red><?php echo $completion ?> % </font>DONE </h2>
	<br>
	<?php
	$T="select forex,equities,etfs,indices,commodities from clientasset where iduser='".$_SESSION['login']."'";
	$TT=mysql_query($T);
	list ($forex,$equities,$etfs,$indices,$commodities)=mysql_fetch_array($TT);
	$displayimg="";
	if ($forex==1) {$displayimg.="<img src='img/forex.png' alt='Forex'> ";}
	if ($equities==1) {$displayimg.="<img src='img/equities.png' alt='Equities CFD'> ";}
	if ($etfs==1) {$displayimg.="<img src='img/etfs.png' alt='ETF'> ";}
	if ($indices==1) {$displayimg.="<img src='img/indices.png' alt='Indices'> ";}
	if ($commodities==1) {$displayimg.="<img src='img/commodities.png' alt='Indices'> ";}
	echo $displayimg;
	include("meter.php");
	?>
	<br>

	<?php
}


exit;

}
}
 }
 else
 {
		if (isset($_GET['login']))
		{
			$login=strip_tags(trim($_GET['login']));
			$_ACCOUNT=$login;
			if ((strlen($login)<>6) && (strlen($login)<>7)) { exit;}
			//include("connect_db.php");
			$T="select password from nucleus where account='".$login."'";
			$TT=mysql_query($T);
			list($password)=mysql_fetch_array($TT);
			//include("end_db.php");
			$password_save=$password;
			
		}
		else
		{
		header("location:index.php");
		exit;
		
		}
 }



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
		$L="select forex,equities,etfs,indices,commodities from clientasset where iduser='".$login."'";
		$LL=mysql_query($L);
		list ($forex,$equities,$etfs,$indices,$commodities)=mysql_fetch_array($LL);
		$insert=TRUE;
		
				$strategyA=explode(" ",$strategy);
				$strategyB=strtolower($strategyA[0]);
		if ($forex==0)
			{
			//echo "NO FOREX";
			//echo "<li>".$strategyB;
				if ( ($strategyB!="indices") &&  ($strategyB!="etfs") && ($strategyB!="commodities") && ($strategyB!="equities"))
				{
					$insert=FALSE;
				}
			}
		if ($etfs==0) {
		if ($strategyB=="etfs")
		 {
			$insert=FALSE;
		 }
		}
		if ($indices==0) {
		if ($strategyB=="indices")
		 {
			$insert=FALSE;
		 }
		}
		if ($commodities==0) {
		if ($strategyB=="commodities")
		 {
			$insert=FALSE;
		 }
		}
		if ($equities==0) {
		if ($strategyB=="equities")
		 {
			$insert=FALSE;
		 }
		}
		if ($insert)
		{
						$time=time();
						$live=0;
						if (strlen($login)==7) {$live=1;}
						// Size of the lot will vary considering the risk taken in the goals // If no goals = * 1
						$B="select moderisk from nucleusrun where account='".$login."'";
						$BB=mysql_query($B);
						list ($moderisk)=mysql_fetch_array($BB);
						if ($moderisk=="") {$moderisk=1;}
						$lot=$lot*$moderisk;
						//
						$SQL2="insert into portofolio_dashboard values ('','".$login."','".$password."','".$instrument."','".$strategyB."','".$lot."','NUCLEUS','".$time."','".$live."')";
						mysql_query($SQL2);
		}
	}
	$G="delete from portofolio_nucleus where accountid='".$login."'";
	
	mysql_query($G);
	
}
global $instrument,$token,$html2,$lastStrategy,$lastInstrument;
include("listClassInstrumentNucleusManagement.php");
// THE INITIAL BALANCE AND EQUITY ///
//$MASTER="select account from nucleus";
//$QMASTER=mysql_query($MASTER);

//while (list($_ACCOUNT)=mysql_fetch_array($QMASTER)) 
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
		
		//if (in_array($instrument,$_FX))
		 //{
						
						
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
		 //}
		//else
		 //{

		//	echo "<div id='por_".$strategy.$instrument."'>Not available for autotrading</div>";
			

		//}
	        }
	echo"</td>";
	echo "<td><a href='charts.php?strategy=".$strategy."&instrument=".$instrument."'><i class='fa fa-bar-chart fa-2x'></i></a></td><td>".$strategy."</td><td>".str_replace("_4","",$instrument)."</td><td>".$lot."</td></tr>";
}
echo"</table>";



echo"<table width=100%cellpadding=0 cellspacing=0>";
echo"<caption><a href='index.php'><i class='fa fa-arrow-left'></i></a> THE GOLDEN PORTFOLIO WE ADVICE YOU TO SELECT NOW AND FOR NEXT WEEK</caption>"; 
echo"<thead><th>Add/Remove</th><th>Performances</th><th>Strategy recommended</th><th>Instrument recommended</th><th>Lot size recommended</th></thead>";
foreach ($_PORTFOLIO_STRATEGY as $key=>$value)
{
	$strategy=$value;
	$instrument=$_PORTFOLIO_INSTRUMENT[$key];
	$instrument=str_replace("_4","",$instrument);
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
		
		//if (in_array($instrument,$_FX))
		// {
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
		// }
		//else
		// {

		//	echo "<div id='por_".$strategy.$instrument."'>Not available for autotrading</div>";
			

		//}
	        }
	echo"</td>";
	echo "<td><a href='charts.php?strategy=".$strategy."&instrument=".$instrument."'><i class='fa fa-bar-chart fa-2x'></i></a></td><td>".$value."</td><td>".str_replace("_4","",$_PORTFOLIO_INSTRUMENT[$key])."</td><td>".$_PORTFOLIO_LOTSIZE[$key]."</td></tr>";
}
echo"</table>";
echo "<center><a href='nucleus.php?apply' class='large green button'>REPLACE YOUR FOREX PORTFOLIO AND APPLY ALL THIS FOREX STRATEGIES TO YOUR PORTFOLIO</a></center>";
//print_r($_PORTFOLIO_STRATEGY);print_r($_PORTFOLIO_INSTRUMENT);print_r($_PORTFOLIO_LOTSIZE);
echo "<div id='adviceoutsideforex'><img src='img/ajax-loader.gif'></div>";
include("end_db.php");
?>
<script>
adviceCFD();
</script>