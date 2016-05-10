<?php
include("config.php");
include("connect_db.php");
$F="select account,password from nucleus";
$FF=mysql_query($F);
while (list($_ACCOUNT,$password)=mysql_fetch_array($FF))
{
echo"<li>".$_ACCOUNT." ".$password."</li>";
$C="select forex from clientasset where iduser='".$_ACCOUNT."'";
$CC=mysql_query($C);
list($forex)=mysql_fetch_array($CC);
if ($forex!=0)
{
$K1=file_get_contents($_cron_path."/nucleus.php?login=".$_ACCOUNT);
echo $K1;
}
$K3=file_get_contents($_cron_path."/getAdviceCFD.php?login=".$_ACCOUNT);
echo $K3;
$K2=file_get_contents($_cron_path."/nucleus.php?apply&bypass=1&login=".$_ACCOUNT);
echo $K2;
echo "<hr>";
}

include("end_db.php");
?>