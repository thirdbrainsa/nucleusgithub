<?php
require("config.php");
require("connect_db.php");

$S1="select category,pourc from categorystats where subcategory=''";
$SS1=mysql_query($S1);
while (list($category,$pourc)=mysql_fetch_array($SS1))
{
$categoryA=explode(" ",$category);
$categoryX=$categoryA[0];
if ($pourc>0) {$pourc="<font color=green> +".$pourc." %</font>";} 
if ($pourc<0) {$pourc="<font color=red> ".$pourc." %</font>";} 
	echo "<div id='currencyihm'><a href='list-instrument.php?category=".str_replace(" ","_",$category)."'><img src='img/".strtolower($categoryX).".png' height=30  style='vertical-align:middle' alt='".$category."' title='".$category."'></a>".$pourc. "</div>";
}
//echo"<div align=left><font size=-2>Last 45 minutes trend for our 1'512 instruments</font></div>";
require("end_db.php");
?>