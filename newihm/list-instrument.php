<TITLE> LIST OF ALL INSTRUMENT USED BY THIRDBRAINFX</TITLE>
<link rel="stylesheet" href="css/table.css">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Resizable ADS -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-5349092563133123"
     data-ad-slot="9075027299"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>


<?php
session_start();
include("config.php");
include("connect_db.php");
if (isset($_GET['category']))
{
	$category=strip_tags(trim($_GET['category']));
	$category=str_replace(",","",$category);
	$category=str_replace("_"," ",$category);
	if (strlen($category)>20) {exit;}
	$_SESSION['category']=$category;
}
if (isset($_GET['subcategory']))
{
	$scategory=strip_tags(trim($_GET['subcategory']));
	$scategory=str_replace(",","",$scategory);
	$scategory=str_replace("_"," ",$scategory);
	if (strlen($scategory)>20) {exit;}
	$_SESSION['subcategory']=$scategory;
}
echo"<table width=900>";
echo"<tr>";
echo"<td valign=top>";
$S1="select DISTINCT(category) from instrumentdb order by category desc";
$SS1=mysql_query($S1);
echo mysql_error();
echo"<table>";
echo"<th>Categories</th><th>%</th>";
while (list($category)=mysql_fetch_array($SS1))
{
$X="select pourc from categorystats where category='".$category."' and subcategory=''";
$XX=mysql_query($X);
list($pourcC)=mysql_fetch_array($XX);
$categoryx=str_replace(" ","_",$category);
echo"<tr><td>";
echo"<a href=?category=".$categoryx.">".$category."</a><br>";
echo"</td><td>";
echo round($pourcC,2)." %";
echo"</td>";
echo"</tr>";

}
echo"</table>";
echo"</td>";
echo"<td valign=top>";
if (isset($_SESSION['category']))
	{
		$category=$_SESSION['category'];
	
		$S2="select DISTINCT(subcategory) from instrumentdb where category='".$category."' order by subcategory desc";
		$SS2=mysql_query($S2);
		echo mysql_error();
		echo "<table>";
		echo"<th>SubCategory</th><th> % </th>";
		
		$categoryx=str_replace(" ","_",$category);
		
			while (list($scategory)=mysql_fetch_array($SS2))
			{
					$scategoryx=str_replace(" ","_",$scategory);
				echo"<tr>";
				echo"<td><a href=?category=".$categoryx."&subcategory=".$scategoryx.">".$scategory."</a></td>";
				$T="select pourc from categorystats where category='".$category."' and subcategory='".$scategory."'";
				//echo"<li>".$T;
				$TT=mysql_query($T);
				list($pourc)=mysql_fetch_array($TT);
				echo"<td>".$pourc."</td>";
				echo"</tr>";
			}
		echo"</table>";
	
	}


echo"</td>";
echo"</tr>";
echo"<tr>";
echo"<td colspan=2>";
if ((isset($_SESSION['category'])) && (isset($_SESSION['subcategory'])))
{
	$S3="select id,symbol, description from instrumentdb where category='".$_SESSION['category']."' AND subcategory='".$_SESSION['subcategory']."'";
	$SS3=mysql_query($S3);
		echo "<table width=100%>";
	echo "<caption> List of Instrument available for Trading for ".$_SESSION['category']."/".$_SESSION['subcategory']."</caption>";
	echo "<th>Instrument</th><th>description</th><th>Trend now</th><th>%</th>";
	while (list($id,$symbol,$description)=mysql_fetch_array($SS3))
		{
			$D="select trend,pourc from instrumenttrend where id=".$id;
			$DD=mysql_query($D);
			list($trend,$pourc)=mysql_fetch_array($DD);
			
				echo "<tr>";
				$symbol=str_replace("_4","",$symbol);
				echo "<td align=center><a href='chartsequitiesprices.php?id=".$id."'>".$symbol."</td>";
				echo"<td align=center>".$description."</td>";
				echo "<td align=center>".$trend."</td>";
				echo "<td align=center>".$pourc."</td>";
				echo"</tr>";
		
		
		}
}

echo"</td>";
echo"</tr>";
echo"</table>";
include("end_db.php");
?>
<a href='index.php'><img src='thirdbrainfx.gif'></a></center>
<?
include("tracking.php");
?>