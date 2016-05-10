<?php
//include("config.php");

/// check  basic login aspect
$_login=$_SESSION['login'];
$_login=strip_tags($_login);
$_login=intval($_login);

if ((strlen($_login)!=6) && (strlen($_login)!=7))
	{
		exit;
	}	

$_password=$_SESSION['password'];

$_password=strip_tags($_password);

if (strlen($_password)>10) 
{
	exit;
}
//
	$file=@fopen($_membership.$_login,"w");
	$string=$_password;
	fputs ($file,$string);
	fclose($file);
// ADD A SESSION (LOGGED)

$_SESSION['logged']=1;

// LOG.

 // Access Log
	$file=@fopen($_alllog."/access.log","a");
	$data=$_SERVER['REMOTE_ADDR'];
	$dataff=date("Y-m-d H:i:s"); 
	$datac=$dataff." - ".$data." : Login > ".$_login." \n";
	fputs($file,$datac);
	fclose($file);
	
?>