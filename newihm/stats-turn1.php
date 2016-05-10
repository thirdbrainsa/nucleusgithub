<?php
include ("config.php");
include ("connect_db.php");

$SQL1="SELECT DISTINCT(strategy) from historydb";
$SQL2="SELECT DISTINCT(instrument) from historydb";

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

foreach ($strategy as $v_strategy)
{
	foreach ($instrument as $v_instrument)
	{
			$SQL="select AVG(whenclose-whenopen) from historydb where instrument='".$v_instrument."' and strategy='".$v_strategy."' and (whenclose-whenopen)<2000000";
			//echo "<li>".$SQL;
			$Q=mysql_query($SQL,$mysql);
			list($difference)=mysql_fetch_array($Q);
			if ($difference!="")
			{
			if ($difference < 3600*24)
				{
				 echo "<li>".$v_strategy." ".$v_instrument." INTRADAY ".$difference;
				}
			}
		
	}
	
}

include("end_db.php");
?>