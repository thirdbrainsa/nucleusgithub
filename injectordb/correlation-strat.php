<?php
include ("config.php");
include ("connect_db.php");
set_time_limit(0);
$T="TRUNCATE advancedstats";
mysql_query($T);

$SQL1="SELECT DISTINCT(strategy) from historydb";
$R1=mysql_query($SQL1);


while (list ($strategy)=mysql_fetch_array($R1))
	{

	$SQL2="SELECT DISTINCT(instrument) from historydb where strategy='".$strategy."' order by id asc";
	$R2=mysql_query($SQL2);

		while (list($instrument)=mysql_fetch_array($R2))
			
			{
			
				$SQL3="select profit from historydb where instrument='".$instrument."' AND strategy='".$strategy."' order by id asc";
				$R3=mysql_query($SQL3);
				$ID=0;
				while (list($profit)=mysql_fetch_array($R3))
				{
				$ID++;
				$_DATA[$strategy][$instrument][$ID]=$profit;
				
				}
			
			}
	
	
	}


//print_r($_DATA);
$R1=mysql_query($SQL1);
while (list ($strategyA)=mysql_fetch_array($R1))
	{

	$SQL2="SELECT DISTINCT(strategy) from historydb where strategy<>'".$strategyA."' order by id asc";
	$R2=mysql_query($SQL2);

		while (list($strategyB)=mysql_fetch_array($R2))
			
			{
			
			$SQL3="SELECT DISTINCT(instrument) from historydb where strategy='".$strategyB."' order by id asc";
			
			$R3=mysql_query($SQL3);

		while (list($instrument)=mysql_fetch_array($R3))
			
			{
			
			
				$testA=$_DATA[$strategyA][$instrument];
				
				$SQL4="SELECT DISTINCT(instrument) from historydb where strategy='".$strategyB."' and instrument<>'".$instrument."' order by id asc";
			
				$R4=mysql_query($SQL4);
				
				while (list($instrument2)=mysql_fetch_array($R4))
			
			{
				$testB=$_DATA[$strategyB][$instrument2];

//print_r($testB);
				
if (!(isset($DONE[$strategyA][$instrument][$strategyB][$instrument2])))

{

$SQLc="TRUNCATE t";
mysql_query($SQLc);
//echo mysql_error();
// FILL THE TABLE;
$i=0;$common=0;
foreach ($testA as $key=>$value)
{
	$i++;
	if (isset($testB[$i]))
	{
	$common++;
	$SQLi="insert into t values('".$i."','".$testA[$i]."','".$testB[$i]."')";
	//echo "<li>".$SQLi;
	mysql_query($SQLi);
	echo mysql_error();
	}
}
$total_comparaison=$common;


$SQL_CORRELATION="SELECT                                       -- Step 4
  N, Slope, avgY - slope*avgX AS Intercept,
  Correlation, CoeffOfReg
FROM (
  SELECT                                     -- Step 3
    N, avgX, avgY, slope, intercept, Correlation,
    FORMAT( 1 - SUM((y - intercept - slope*x)*(y - intercept - slope*x))/
            ((N-1)*varY), 5 ) AS CoeffOfReg
  FROM t AS t2
  JOIN (
    SELECT                                   -- Step 2
      N, avgX, avgY, varY, slope,
      Correlation, avgY - slope*avgX AS intercept
    FROM (
      SELECT
        N, avgX, avgY, varY,
        FORMAT(( N*sumXY - sumX*sumY ) /
               ( N*sumsqX - sumX*sumX ), 5 )           AS slope,
        FORMAT(( sumXY - n*avgX*avgY ) /
               ( (N-1) * SQRT(varX) * SQRT(varY)), 5 ) AS Correlation
      FROM (
        SELECT                               -- Step 1
          COUNT(x)    AS N,
          AVG(x)      AS avgX,
          SUM(x)      AS sumX,
          SUM(x*x)    AS sumsqX,
          VAR_SAMP(x) AS varX,
          AVG(y)      AS avgY,
          SUM(y)      AS sumY,
          SUM(y*y)    AS sumsqY,
          VAR_SAMP(y) AS varY,
          SUM(x*y)    AS sumXY
        FROM t
      ) AS sums
    ) AS calc
  ) stats
) combined;";

	$R3=mysql_query($SQL_CORRELATION);
	list($n,$slope,$intercept,$correlation,$coeffofreg)=mysql_fetch_array($R3);
	echo "<hr>";
	echo "<li>".$strategyA." ".$strategyB." ".$instrument." ".$instrument2."<li>";
	echo "<li>".$n." ".$slope." ".$intercept." ".$correlation." ".$coeffofreg."</li>";
	$SQL="delete from advancedstats where instrument='".$instrument."' and strategy='".$strategyA."' and strategy2='".$strategyB."' and instrument2.='".$instrument2."'";
	mysql_query($SQL);
	$SQL="delete from advancedstats where instrument='".$instrument2."' and strategy='".$strategyB."' and strategy2='".$strategyA."' and instrument2.='".$instrument."'";
	mysql_query($SQL);
	$DONE[$strategyA][$instrument][$strategyB][$instrument2]=1;
	$DONE[$strategyB][$instrument2][$strategyA][$instrument]=1;
	
	if ($common>10)
	{
	if (($total_comparaison!=0) && ($intercept!=0))
 	{
	$SQL="insert into advancedstats values('','".$instrument."','".$strategyA."','".$instrument2."','".$strategyB."','".$total_comparaison."','".$slope."','".$intercept."','".$correlation."','".$coeffofreg."')";
	echo "<li>".$SQL;
	mysql_query($SQL);
	echo mysql_error();
	}
	echo "<hr>";
	}
	}
	}
	}
}

}
include ("end_db.php");
?>