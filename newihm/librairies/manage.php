<?php
function getbackTradeHistory($dbhost,$dblogin,$dbpass,$db,$login)
{
	$mysql=mysql_connect($dbhost,$dblogin,$dbpass);
	mysql_select_db($db);

	$SQL="select balance from historicbalance where account='".$login."' order by timeinsert asc";
	$R=mysql_query($SQL);
	$capital=0;$display="";
	while (list($balance)=mysql_fetch_array($R))
	{
				$display.=",'".$balance."'";
	}
	$display=ltrim($display,",");
	$display="[".$display."]";
	mysql_close($mysql);
	return $display;
}
function getbackdataInstrument($id)
{


	$SQL="select ask,bid from instrumentdbhistory where id=".$id." order by timeinsert asc";
	$R=mysql_query($SQL);
	$capital=0;$display="";
	while (list($ask,$bid)=mysql_fetch_array($R))
	{
		$capital=($ask+$bid)/2;
		$display.=",'".$capital."'";
	}
	$display=ltrim($display,",");
	$display="[".$display."]";

	return $display;
}
function multipips($instrument,$digit)

{
$multi="0.0001";
		if ($digit==5) {$multi=0.0001;}
		if ($digit==4) {$multi=0.0001;}
		if ($digit==3) {$multi=0.01;}
		if ($digit==2) {$multi=0.01;}
		if ($digit==1) {$multi=0.1;}
		if ($digit==0) {$multi=1;}

		return $multi;
}


function addMessage($account,$message)
{
				//echo "<li>".$account."-".$message."</li>";
				$SQL="insert into log values('','".$account."','".addslashes($message)."',NOW())";
				//mysql_query($SQL);
	
	
	
}
function getbackdata($dbhost,$dblogin,$dbpass,$db,$instrument, $strategy)
{
	$mysql=mysql_connect($dbhost,$dblogin,$dbpass);
	mysql_select_db($db);
	$SQL="select profit,swap from historydb where instrument='".$instrument."' and strategy='".$strategy."' order by id asc";
	$R=mysql_query($SQL);
	$capital=0;$display="";
	while (list($profit,$swap)=mysql_fetch_array($R))
	{
		$capital=$capital+$profit;
		$display.=",'".$capital."'";
	}
	$display=ltrim($display,",");
	$display="[".$display."]";
	mysql_close($mysql);
	return $display;
}
function getbackdataX($dbhost,$dblogin,$dbpass,$db,$instrument, $strategy)
{
	$mysql=mysql_connect($dbhost,$dblogin,$dbpass);
	mysql_select_db($db);
	$SQL="select whenclose from historydb where instrument='".$instrument."' and strategy='".$strategy."' order by id asc";
	$R=mysql_query($SQL);
	$capital=0;$display="";
	while (list($when)=mysql_fetch_array($R))
	{
		
		$display.=",'".$when."'";
	}
	$display=ltrim($display,",");
	$display="[".$display."]";
	mysql_close($mysql);
	return $display;
}
function sellbuy($command)
{
if ($command==0) {
	
	$commandD="BUY";
	
	} else 
	
	{
	$commandD="SELL";
	
	}
return $commandD;
}


function longshort($command)
{
if ($command==0) {
	
	$commandD="LONG";
	
	} else 
	
	{
	$commandD="SHORT";
	
	}
return $commandD;
}

function msg_random($what,$_MSG_MATRIX)
{
	//print_r($_MSG_MATRIX);
	
	$_SUB_MATRIX=$_MSG_MATRIX[$what];
	
	$_nwords=array_rand($_SUB_MATRIX,1);
	$_words=$_SUB_MATRIX[$_nwords];
return $_words;

}

?>