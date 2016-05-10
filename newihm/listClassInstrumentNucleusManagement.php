<table width=100% cellpadding=0 cellspacing=0>
<caption><a href='index.php'><i class='fa fa-arrow-left'></i></a> ASSET CLASS FOR YOUR PORTFOLIO</caption>
<tr>
<td>
<?php

$S1="select category,pourc from categorystats where subcategory=''";
$SS1=mysql_query($S1);
while (list($category,$pourc)=mysql_fetch_array($SS1))
{
if ($pourc>0) {$pourc="<font color=green>+".$pourc." %</font>";} 
if ($pourc<0) {$pourc="<font color=red>".$pourc." %</font>";} 
$X="select * from clientasset where iduser='".$login."'";
$XX=mysql_query($X);
$info=mysql_fetch_array($XX);
//print_r($info);
$categoryX=explode(" ",$category);
$categoryA=strtolower($categoryX[0]);
if ($info[$categoryA]==0)
	{
	$type="add";
	echo "<div id='currencyihm2'><div id='asset_".$category."'> <i class='fa fa-bell-slash-o'></i> <a href=\"javascript:addAsset('".$category."','".$login."','".$token."','".$type."');\">".$category." ".$pourc. "</a></div></div>";

	}
	else
	{
	$type="remove";
echo "<div id='currencyihm2'><div id='asset_".$category."'> <i class='fa fa-bell-o'></i> <a href=\"javascript:addAsset('".$category."','".$login."','".$token."','".$type."');\">".$category." ".$pourc. "</a></div></div>";

	}
		
}


?>
</td>
</tr>
</table>