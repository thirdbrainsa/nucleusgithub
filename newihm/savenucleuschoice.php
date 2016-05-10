<?php
session_start();
if (isset($_GET['balance']))
	{
		$_SESSION['balance']=intval($_GET['balance']);
	}
if (isset($_GET['account']))
	{
	
		$_SESSION['login']=$_GET['account'];
		if  ( (strlen($_SESSION['login'])!=6) && (strlen($_SESSION['login'])!=7) ) {exit;}
	}


include("config.php");
include("connect_db.php");
$_datend=strip_tags(trim($_GET['dateend']));
$_balancereach=intval(trim($_GET['balancereach']));
$_risktotake=$_GET['risktotake'];$_risktotake=round($_risktotake,2);
$SQL="delete from nucleusrun where account='".$_SESSION['login']."'";
mysql_query($SQL);
$date=date("Y-m-d");
$SQL="insert into nucleusrun values('".$_SESSION['login']."','".$_balancereach."','".$date."','".$_datend."','".$_risktotake."')";
echo "<li>".$SQL;
mysql_query($SQL);
echo mysql_error();
echo "<li>".$_datend;

// PUT THE A-BOOK ON
$T1="select account from abook where account='".$_SESSION['login']."'";
$TT=mysql_query($T1);
list ($account)=mysql_fetch_array($TT);
if  ($account=="")
	{
	
		$SQL="insert into abook values ('".$_SESSION['login']."')";
		mysql_query($SQL);
	}

// SETUP THE CLIENT ASSET
$balance=$_SESSION['balance'];
echo "<li>".$balance;
$forex=1;$equities=0;$etfs=0;$indices=0;$commodities=0;
if ($balance>2000)
	{
		$commodities=1;
	
	}
if ($balance> 5000)
	{
		$indices=1;
	
	}
if ($balance>10000)
	{
	
		$equities=1;
		
	
	}
if ($balance>20000)
	{
	
		$etfs=1;
	}

$SQL="delete from clientasset where iduser='".$_SESSION['login']."'";
mysql_query($SQL);
$SQL="insert into clientasset values ('".$_SESSION['login']."','".$forex."','".$equities."','".$etfs."','".$indices."','".$commodities."')";
mysql_query($SQL);
include("end_db.php");
header("location:nucleus.php");
?>