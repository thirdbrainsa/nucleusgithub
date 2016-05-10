<?php
include ("config.php");
include ("connect_db.php");
$month_today=date("n");
$year_today=date("Y");

// Month before for consolidation
$month=$month_today-1;
if ($month_today<1)
	{
		$month=12;
		$year=$year_today-1;
	}
	else
	{
	
	$year=$year_today;
	
	}

$SQL="SELECT id,instrument,swap,profit,strategy 
FROM historydb where whenclose BETWEEN '".$year."-".$month."-01' AND '".$year."-".$month."-31' order by whenclose asc";
//echo"<li>".$SQL;
$r=mysql_query($SQL);
while (list($iddb,$instrument,$swap,$profit,$strategy)=mysql_fetch_array($r))
	{
	   $SQL1="select id from datastats where instrument='".$instrument."' and strategy='".$strategy."' and month=".$month." and year=".$year;
	   $RR=mysql_query($SQL1);
	   list($id)=mysql_fetch_array($RR);
	   
	   if ($id=="")
		{
			if ($profit>0)
			{
			$SQL2="insert into datastats values ('','".$instrument."','".$strategy."','".$month."','".$year."','".$profit."','0','".$swap."','1','0')";
			}
			else
			{
			$_DD[$instrument][$strategy]=abs($profit);
			$_MAXDD[$instrument][$strategy]=0;
			$SQL2="insert into datastats values ('','".$instrument."','".$strategy."','".$month."','".$year."','".$profit."','0','".$swap."','0,'1')";
			}
		
		
		
		}
		else
		{
		      if ($profit>0)
			{
			$SQL2="update datastats set pips=pips+".$profit.",swap=swap+".$swap.",trades_win=trades_win+1 where id=".$id;
			$_DD[$instrument][$strategy]=0;
			}
			else
			{
			$_DD[$instrument][$strategy]=$_DD[$instrument][$strategy]+abs($profit);
			if ($_DD[$instrument][$strategy]>$_MAXDD[$instrument][$strategy])
				{
					$_MAXDD[$instrument][$strategy]=$_DD[$instrument][$strategy];
				
				}
			$SQL2="update datastats set pips=pips+".$profit.",swap=swap+".$swap.",drawdown=".$_MAXDD[$instrument][$strategy].",trades_loose=trades_loose+1 where id=".$id;
			}
		
		
		
		}
	
	mysql_query($SQL2);
	
	//$SQL3="DELETE FROM historydb where id=".$iddb;
	//mysql_query($SQL3);
	} 
	

include("end_db.php");
?>