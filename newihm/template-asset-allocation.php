<?php
$T="select category from categorystats where subcategory=''";
$TT=mysql_query($T);
while (list($asset)=mysql_fetch_array($TT))
{
echo"<div id='currencyihm'><div id='asset_".$asset."'><a href=\"javascript:addAsset('".$asset."','".$login."','".$token."');\"><i class=\"fa fa-square-o fa-2x\"></i></a> ".$asset."</div></div>";
}			
?>