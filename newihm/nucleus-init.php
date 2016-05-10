<?php
set_time_limit(0);
include("config.php");
include("connect_db.php");
$F="select account,password from nucleus";

$FF=mysql_query($F);
while (list($_ACCOUNT,$password)=mysql_fetch_array($FF))
{
$KL="select count(id) from portofolio_dashboard where accountid='".$_ACCOUNT."'";
$KLL=mysql_query($KL);
list ($TOT)=mysql_fetch_array($KLL);
echo mysql_error();
if ($TOT==0)
{
echo"<li>".$_ACCOUNT." ".$password."</li>";
echo "<li> START NUCLEUS </li>";
echo "<li> INIT MARKET LINK + CLIENT ASSET TABLE</li>";
$P="select account from nucleusrun where account='".$_ACCOUNT."'";
$PP=mysql_query($P);
list ($account)=mysql_fetch_array($PP);
if ($account=="")
{
$L="select balance from balance where account='".$_ACCOUNT."'";
$LL=mysql_query($L);
list ($balance)=mysql_fetch_array($LL);
$balancereach=$balance+$balance*0.05;
$balancereach=intval($balancereach);
$date = date("Y-m-d");
//increment 2 days
$days=30;
$mod_date = strtotime($date."+ ".$days." days");
$Date2=date("Y-m-d",$mod_date) . "\n";

$K4=file_get_contents($_cron_path."/savenucleuschoice.php?dateend=".$Date2."&balancereach=".$balancereach."&risktotake=1&balance=".$balance."&account=".$_ACCOUNT);
}
$C="select forex from clientasset where iduser='".$_ACCOUNT."'";
$CC=mysql_query($C);
list($forex)=mysql_fetch_array($CC);
if ($forex!=0)
{
$K1=file_get_contents($_cron_path."/nucleus.php?login=".$_ACCOUNT);
//echo $K1;
}
$K3=file_get_contents($_cron_path."/getAdviceCFD.php?login=".$_ACCOUNT);
//echo $K3;
$K2=file_get_contents($_cron_path."/nucleus.php?apply&login=".$_ACCOUNT);
//echo $K2;
}
echo "<hr>";
}

include("end_db.php");
?>