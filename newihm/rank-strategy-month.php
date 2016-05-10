<?php

function compute_tbx_score($avg_profit,$avg_loose,$win,$profit,$dd,$dayprofit,$nbtrade)
{
$compute_tbx_score=0;


/// COMPUTE The Risk and Return : Means the profit divided by the drawdown. What you are risking to get a sum. If rar=1 it means that you are risking 1 to gain 1. No so sexy then log(rar)=0 (null). If RaR>1 , it's good and <1, it's bad (negative). The Log is done to avoid big scale effect.
// Composition of C1 from -30 to 30 points.
if (ABS($dd)>0)
{
if ($profit>0)
{
$RaR=ABS($profit/$dd);
if ($RaR>50) {$RaR=60;}
}
else
{
$RaR=0.1;
}
}
else
{
$RaR=50;
}

if ($profit > 0 )
{
	if ($profit < 100 )
	{
		$C1=log($RaR)*7;
	}
		else
	{
	$C1=log($RaR)*16;

	}
}
else
{
$C1=log($RaR);

}

// COMPUTE C2
// The average gain divided by the average loose give an indice about the intraday possible drawdown and the risk. More average winning trade is superior to average loosing trade, more it's good....
if (ABS($avg_loose)!=0)

{
   $dividing=ABS($avg_profit/$avg_loose);
   $log_dividing=log($dividing); // because a result=1 for dividing it's a null effect ...you are risking what you can loose...not sexy at all too !	
}
else
{
   $log_dividing=log(20);
}

$C2=$log_dividing*10;

// Compute C3 - About the winning rate // Only Bonus for DayProfit , no matter of the amount !

if ($dayprofit>0)
{
	$C3=10;

}
else
{

	$C3=0;
}

// Compute C4 : Bonus for winning percentage

$C4=0;

if ($win>50)
{

	$C4=5;
}
if ($win>70)
{

	$C4=10;
}
if ($win>90)
{

	$C4=18;
}

if ($win==100)
{

	$C4=25;
}

// BONUS PROFIT

$C5=($profit/10000);
//
$compute_tbx_score= (($C1+$C2+$C3+$C4+80)/250)*10+$C5;
if ($compute_tbx_score>10)
 {
	$compute_tbx_score=10;
 }
 if ($compute_tbx_score<0)
 {
	$compute_tbx_score=0;
 }
 
 $compute_tbx_score=round($compute_tbx_score, 2);  
//echo "<li><b>TBX:".$compute_tbx_score."</b> >COUNT :".$nbtrade." AVG PROFIT :".$avg_profit. " : AVG LOOSE >".$avg_loose."  WIN :" .$win." PROFIT : " .$profit. " DD :".$dd. " DAYPROFIT:".$dayprofit."|||||| RaR :".$RaR." C1>".$C1. " C2> ".$C2. " C3>".$C3. " C4> ".$C4;

//echo "<hr>";
return $compute_tbx_score;
}

include ("config.php");
include ("connect_db.php");

$SQL_D1="TRUNCATE ranking_month";
mysql_query($SQL_D1);

$SQL1="SELECT DISTINCT(strategy) from historydb where whenclose>NOW() - INTERVAL 7 DAY";
$SQL2="SELECT DISTINCT(instrument) from historydb where whenclose>NOW() - INTERVAL 7 DAY";

$S1=mysql_query($SQL1,$mysql);
while (list($strat)=mysql_fetch_array($S1))
{
$strategy[]=$strat;
}


$S2=mysql_query($SQL2,$mysql);


while (list($strat)=mysql_fetch_array($S2))
{
if ($strat!="")
{
$instrument[]=$strat;
}
}




//print_r($strategy);
//print_r($instrument);

foreach ($strategy as $v_strategy)
{
	foreach ($instrument as $v_instrument)
	{
		//echo "<li>".$v_strategy."-".$v_instrument;
		
		/// SOMME DES GAINS SUR LA SEMAINE
		$SQL_W="select AVG(profit) from historydb where  instrument='".$v_instrument."' and strategy='".$v_strategy."' and profit<0 and whenclose>NOW() - INTERVAL 7 DAY";
		//echo "<li>".$SQL_W;
		$S_W=mysql_query($SQL_W);
		list ($alt)=mysql_fetch_array($S_W);
		
		$SQL_W="select AVG(profit) from historydb where  instrument='".$v_instrument."' and strategy='".$v_strategy."' and profit>0 and whenclose>NOW() - INTERVAL 7 DAY";
		$S_W=mysql_query($SQL_W);
		list ($awt)=mysql_fetch_array($S_W);
		//echo "<li>".$alt." ".$awt;
		$SQL_W="select COUNT(id) from historydb where  instrument='".$v_instrument."' and strategy='".$v_strategy."' and profit>0 and whenclose>NOW() - INTERVAL 7 DAY";
		$S_W=mysql_query($SQL_W);
		//echo "<li>".$SQL_W;
		list ($winning)=mysql_fetch_array($S_W);
		//echo " - ".$winning;
		$SQL3="select SUM(profit) from historydb where instrument='".$v_instrument."' and strategy='".$v_strategy."' and whenclose>NOW() - INTERVAL 7 DAY";
		//echo "<li>".$SQL3;
		$S3=mysql_query($SQL3);
		list($profit)=mysql_fetch_array($S3);
		$SQL4="select COUNT(id) from historydb where instrument='".$v_instrument."' and strategy='".$v_strategy."' and whenclose>NOW() - INTERVAL 7 DAY";
		//echo "<li>".$SQL3;
		$S4=mysql_query($SQL4);
		list ($count)=mysql_fetch_array($S4);
		//echo " - ".$count;
		// Compute winning percentage
		if ($count>0)
		{
		$winning_perc=intval( ($winning/$count)*100);
		}
		//
		
		$SQL5="select SUM(profit) from historydb where instrument='".$v_instrument."' and strategy='".$v_strategy."' and whenclose > NOW() - INTERVAL 7 DAY";
		$S5=mysql_query($SQL5);
		list($day)=mysql_fetch_array($S5);
		#echo " > ".$profit. " | ".$count;
		
		////
		$a=0;$maxdd=0;$dd=0;
		$SQL33="select profit,whenclose from historydb where instrument='".$v_instrument."' and strategy='".$v_strategy."' and whenclose>NOW() - INTERVAL 7 DAY order by whenclose asc";
		$S33=mysql_query($SQL33);
		while (list($profitC,$when)=mysql_fetch_array($S33))
			 {
			 $a++;
			
			
			 if ($profitC<0)
				{
					$dd=$dd+$profitC;
				
				}
				
				if ($dd < $maxdd) {$maxdd=$dd; }
			
			if ($profitC>0)
				{
					
					
					$dd=0;
				}
				//echo "<li>".$v_instrument."-".$v_strategy." ".$when." > ".$profitC. " ".$dd. "  ".$maxdd;
			 }
			 if ($profit>0)
			 {
		//echo "<br>PROFIT ".$profit." MAXDD >".$maxdd;
		}
		//echo "<hr>";
		
		
		///
		if ($count>9)
		{
		$tbx_score=compute_tbx_score($awt,$alt,$winning_perc,$profit,$maxdd,$day,$count);
		}
		else
		{
		$tbx_score=0;
		}
		// ========================== SAVE OR UPDATE THE DATA ==============================================
		
		if ($count>1)
		{
		
		if ($alt=="") {$alt=0;}
		if ($awt=="") {$awt=0;}
		
				$SQL5="select id from ranking_month where instrument='".$v_instrument."' AND strategy='".$v_strategy."'";
				$S5=mysql_query($SQL5,$mysql);
				list($id)=mysql_fetch_array($S5);
				if ($id=="")
					{
						
						$SQL6="insert into ranking_month values('','".$v_instrument."','".$v_strategy."',NOW(),'".$profit."','".$count."','".$day."','".$maxdd."','".$winning_perc."','".$awt."','".$alt."','".$tbx_score."')";
						//echo "<li>".$SQL6;
						@mysql_query($SQL6,$mysql);
						//echo mysql_error();
					}
					else
					{
						$SQL7="update ranking set whenopen=NOW(), profit='".$profit."', count='".$count."', dayprofit='".$day."',drawdown='".$maxdd."', winningperc='".$winning_perc."', awt='".$awt."', alt='".$alt."', tbx_score='".$tbx_score."'  where id=".$id;
						//echo "<li>".$SQL7;
						@mysql_query($SQL7);
						//echo mysql_error();
						//echo mysql_error();
						
					}
			
			
		}	
	
	}
	
}

### MAINTENANCE OF DB ######
### SUPPRESS ALL DIGIT=99 (POSITION CLOSED)

#####
include("end_db.php");
?>