<?php
session_start();
$balance=$_GET['balance'];
$balance=round($balance,2);
$login=$_SESSION['login'];
include("config.php");
include("connect_db.php");
$SQL="select account from balance where account='".$login."'";
$S1=mysql_query($SQL);
list($account)=mysql_fetch_array($S1);
if ($account=="")
	{
		$S2="insert into balance values ('".$login."','".$balance."',NOW())";
		mysql_query($S2);
	
	}
include("end_db.php");
?>