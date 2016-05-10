<?php
session_start();
include ('config.php');
$list_c=array();
$nb_c=0;
$risk_m=1;
if (isset($_GET['token']))
	{
		$token=strip_tags(trim($_GET['token']));
		if (strlen($token)!=32)
			{
			exit;
				
			}
	}
// GET USERID OF THE PORTFOLIO
include("connect_db.php");

$SQL="select login from temp_login where token='".$token."'";
$R=mysql_query($SQL);
list ($login)=mysql_fetch_array($R);

if ($login=="")
	{
	$login=$token;$table="portofolio_dashboard_guest";
	}
	else
	{
	
	$table="portofolio_dashboard";
	
	$SQL="select balance from balance where account='".$login."'";
	//echo "<li>".$SQL;
	$RR=mysql_query($SQL);
	list ($balance)=mysql_fetch_array($RR);
	}
	
if (!(isset($balance))) {$balance=50000;}   	

// GET THE DATA OF PORTFOLIO
$SQL="select instrument,strategy,lot from ".$table." where accountid='".$login."'";
$R=mysql_query($SQL);

$add_drawdown=0;$add_profit=0;

while (list ($instrument,$strategy,$lot)=mysql_fetch_array($R))
{
	//echo"<li>".$instrument." ".$strategy." ".$lot;
		// GET THE DATA OF EACH STRATEGY
		$SQL2="select profit,count,drawdown,winningperc,awt,alt,tbx_score from ranking where instrument='".$instrument."' AND strategy='".$strategy."'";
		$RR=mysql_query($SQL2);
		list ($profit,$count,$drawdown,$winningperc,$awt,$alt,$tbx_score)=mysql_fetch_array($RR);
		
		//Echo "<br>";
		//Echo $profit." ".$count." ".$drawdown." ".$winningperc." ".$awt." ".$alt;
		
		// COMPUTE FOR 10% RISK //
		$add_drawdown+=$drawdown*$lot;
		$add_profit+=$profit*$lot;
		
		
}

// COMPUTE THE RISK //
if ($balance!=0)
{
$RISK_TAKEN=abs(round(( 100*($add_drawdown/$balance)),1));
$LOWESTRISK=$RISK_TAKEN;

$GAIN=round((100*($add_profit/$balance)),1);
$LOWESTGAIN=$GAIN;
}
else
{
$LOWESTRISK="0 ";
$LOWESTGAIN="0 ";

}

if ($LOWESTRISK<$_RISKPROFILE[0])
{
$l[1]=$LOWESTRISK;$lote[1]=0.01;
$l[2]=$l[1]*($_RISKPROFILE[1]/$_RISKPROFILE[0]);$lote[2]=$lote[1]*round(($_RISKPROFILE[1]/$_RISKPROFILE[0]),2);
$l[3]=$l[1]*($_RISKPROFILE[2]/$_RISKPROFILE[0]);$lote[3]=$lote[1]*round(($_RISKPROFILE[2]/$_RISKPROFILE[0]),2);
$l[4]=$l[1]*($_RISKPROFILE[3]/$_RISKPROFILE[0]);$lote[4]=$lote[1]*round(($_RISKPROFILE[3]/$_RISKPROFILE[0]),2);
$l[5]=$l[1]*($_RISKPROFILE[4]/$_RISKPROFILE[0]);$lote[5]=$lote[1]*round(($_RISKPROFILE[4]/$_RISKPROFILE[0]),2);
}
if ($LOWESTRISK>$_RISKPROFILE[0])
{
$l[1]=0;$lote[1]=0;
$l[2]=$LOWESTRISK;$lote[2]=0.01;
$l[3]=$l[2]*($_RISKPROFILE[2]/$_RISKPROFILE[0]);$lote[3]=$lote[2]*round(($_RISKPROFILE[2]/$_RISKPROFILE[0]),2);
$l[4]=$l[2]*($_RISKPROFILE[3]/$_RISKPROFILE[0]);$lote[4]=$lote[2]*round(($_RISKPROFILE[3]/$_RISKPROFILE[0]),2);
$l[5]=$l[2]*($_RISKPROFILE[4]/$_RISKPROFILE[0]);$lote[5]=$lote[2]*round(($_RISKPROFILE[4]/$_RISKPROFILE[0]),2);

}
if ($LOWESTRISK>$_RISKPROFILE[1])
{
$l[1]=0;$l[2]=0;$lote[1]=0;$lote[2]=0;
$l[3]=$LOWESTRISK;$lote[3]=0.01;
$l[4]=$l[3]*($_RISKPROFILE[3]/$_RISKPROFILE[0]);$lote[4]=$lote[3]*round(($_RISKPROFILE[3]/$_RISKPROFILE[0]),2);
$l[5]=$l[3]*($_RISKPROFILE[4]/$_RISKPROFILE[0]);$lote[5]=$lote[3]*round(($_RISKPROFILE[4]/$_RISKPROFILE[0]),2);
}
if ($LOWESTRISK>$_RISKPROFILE[2])
{
$l[1]=0;$l[2]=0;$l[3]=0;$lote[1]=0;$lote[2]=0;$lote[3]=0;
$l[4]=$LOWESTRISK;$lote[4]="0.01";
$l[5]=$l[4]*($_RISKPROFILE[4]/$_RISKPROFILE[0]);$lote[5]=$lote[4]*round(($_RISKPROFILE[4]/$_RISKPROFILE[0]),2);
}
if ($LOWESTRISK>$_RISKPROFILE[3])
{
$l[1]=0;$l[2]=0;$l[3]=0;$l[4]=0;
$l[5]=$LOWESTRISK;
}
// CHECK THE MINIMAL LOT TO COMPUTE THE GAIN.
/*



echo "<li> DD:".$add_drawdown." ON ".$balance." :".$RISK_TAKEN." LOWEST :".$LOWESTRISK;

echo "<li>RISK SCALE :".$l[1]." ".$l[2]." ".$l[3]." ".$l[4]." ".$l[5];
echo "<li>ADVICED LOT :".$lote[1]." ".$lote[2]." ".$lote[3]." ".$lote[4]." ".$lote[5];

echo "<li>GAIN AT LOWER RISK :".$LOWESTGAIN;

echo "<li>RATIO GAIN/RISK ".$LOWESTGAIN/$LOWESTRISK;
//
// Balance Multiplicators;
*/
include("end_db.php");
//echo $LOWESTRISK."|".$LOWESTGAIN;



$compute_real_gain=intval(($LOWESTGAIN/100)*$balance);
$compute_real_risk=intval(($LOWESTRISK/100)*$balance);
echo "<h1><a href='index.php' class='large green button' ><i class='fa fa-arrow-left'></i></a>  GAIN : ".$compute_real_gain." USD/MONTH (".$LOWESTGAIN."%) RISK: ".-1*$compute_real_risk." USD/MONTH(".$LOWESTRISK."%)</h1>";
//header("location:result-compute.php?l1=".$l[1]."&w1=".$w[1]."&l2=".$l[2]."&w2=".$w[2]."&l3=".$l[3]."&w3=".$w[3]."&l4=".$l[4]."&w4=".$w[4]."&l5=".$l[5]."&w5=".$w[5]."&lo1=".$lote[1]."&lo2=".$lote[2]."&lo3=".$lote[3]."&lo4=".$lote[4]."&lo5=".$lote[5]."&video=".$videotour);
?>

