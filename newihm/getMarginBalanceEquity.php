<?php
include ("librairies/manage.php");
if (isset($_GET['login']))
	{
	include("config.php");

	$login=$_GET['login'];
	$url=$_cron_path."rightsoftrade.php?login_to_check=".$login;
	$_check=file_get_contents($url);
	include("connect_db.php");
	
	// COMPUTE RATES  LIVE 
	$SQL="select distinct(instrument) from trade_running where accountid='".$login."'";
	$FF=mysql_query($SQL);
	while (list($instrument)=mysql_fetch_array($FF))
	{
	$S1="select ask,bid,timestamp from rates where instrument='".$instrument."' order by timestamp desc limit 0,1";
	$FFF=mysql_query($S1);
	list($ask,$bid,$timestamp)=mysql_fetch_array($FFF);
	
	

	$time=time();
	if  (($time-$timestamp)<60)
	{

	$_PRICE[$instrument]=($ask+$bid)/2;
	}
	else
	{

	$S2="select command,price,digit,profit from tradedb where instrument='".$instrument."' order by timeinsert desc limit 0,1";
	$FFF=mysql_query($S2);
	list($command,$priceopen,$digit,$profit)=mysql_fetch_array($FFF);
	
	$multi=multipips($instrument,$digit);
		/*
		if ($digit==5) {$multi=0.00001;}
		if ($digit==4) {$multi=0.00001;}
		if ($digit==3) {$multi=0.001;}
		if ($digit==2) {$multi=0.01;}
		if ($digit==1) {$multi=0.1;}
		if ($digit==0) {$multi=1;}
		*/
		
	if ($command==0)
	{
	$_PRICE[$instrument]=$priceopen+$profit*$multi;
	}
	else
	{
	$_PRICE[$instrument]=$priceopen-$profit*$multi;
	
	}
	}
	}	
	
	
	
	$SQL="select balance from balance where account='".$login."'";
	$R=mysql_query($SQL);
	list($balance)=mysql_fetch_array($R);
	
	$SQL="select price,digit,signature,lot from trade_running where accountid='".$login."'";
        $TT=mysql_query($SQL);
	echo mysql_error();
	$tswap=0;$tprofit=0;$tlot=0;$multi=1;
	while (list($priceopen,$digit,$signature,$lot)=mysql_fetch_array($TT))
	{
		$SQL2="select instrument,command from tradedb where signature='".$signature."'";
		$TTT=mysql_query($SQL2);
		list ($instrument,$command)=mysql_fetch_array($TTT);
		
		$multi=multipips($instrument,$digit);
		/*
		if ($digit==5) {$multi=0.00001;}
		if ($digit==4) {$multi=0.00001;}
		if ($digit==3) {$multi=0.001;}
		if ($digit==2) {$multi=0.01;}
		if ($digit==1) {$multi=0.1;}
		if ($digit==0) {$multi=1;}
		*/
		$price1=round($_PRICE[$instrument],5);
		if ($command==0)
		{
		$profitbase=(($price1-$priceopen)/$multi);
		$profit=(($price1-$priceopen)/$multi)*($lot/0.10);
		}
		else
		{
		$profitbase=-1*(($price1-$priceopen)/$multi);
		$profit=-1*(($price1-$priceopen)/$multi)*($lot/0.10);
		}
		
		$tprofit+=$profit;
		
		$SQLu="update trade_running set profit=".round($profitbase,2)." where signature='".$signature."'";
		mysql_query($SQLu);
		
		
		
		//echo "<li>".$diffofprofit;
	
		$tlot+=$lot;
	
	
	}
	$margin_used=round((($tlot/0.01)*$_leverage_factor),2);
	$equity=$balance+$tprofit;
	$free_margin=$equity-$margin_used;
	$SQL333="SELECT lot,profit,swap from history_client where accountid='".$login."' order by timeinsert desc";
	$T=mysql_query($SQL333);
	$sprofit=0;$sswap=0;
	while (list ($lot,$profit,$swap)=mysql_fetch_array($T))
	{
	$sprofit+=$profit;
	$sswap+=0;
	}
	$pandl=$sprofit;
	$SQL444="SELECT balance from bonus where account='".$login."'";
	$R444=mysql_query($SQL444);
	list($bonus)=mysql_fetch_array($R444);
	
	include("end_db.php");
	$equity=$equity+$bonus;
	#echo "<div class='large green button'>Balance : ".round($balance,2)." USD</div> <div class='large green button'><a href='TradeManagement.php'>Equity :".round($equity,2)." USD</a></div><div class='large green button'>BONUS :".round($bonus,2)." USD</a></div><div class='large green button'>FREE MARGIN :".round($free_margin,2)." USD</div> <div class='large green button'><a href='TradeHistory.php'>P & L :".round($pandl,2)." USD</a></div>";
	
	echo $balance."|".$equity."|".$free_margin;
	
	
	
	}
?>