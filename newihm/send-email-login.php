<?php
session_start();
global $error,$live;

if (isset($_POST['partner'])) {$_SESSION['partner']=$_POST['partner'];}

if (isset($_GET['balance']))
{
$balance=intval($_GET['balance']);
}
else
{
$balance="50000";
}
if (isset($_POST['login']))
{

if (strlen($_POST['login'])>7) { exit;}
 
 $login=$_POST['login'];
 $login=strip_tags(trim($login));
 $login=str_replace(",","",$login);
 $login=str_replace("(","",$login);
 
$_SESSION['login']=$login;

$password=$_POST['password'];
 $password=strip_tags(trim($password));
 $password=str_replace(",","",$password);
 $password=str_replace("(","",$password);

$_SESSION['password']=$password;
$_guest=0;

}
else
{
$time=time()+mt_rand(0,9000000);
$hash_session=md5($time);

if (isset($_SESSION['login']))
	{
$_guest=1; 
if ( (strlen($_SESSION['login'])<=7) && ($_register==1))
	{
				include("register-login.php");
	}	
	}
	else
	{

$_SESSION['login']=$hash_session;
$_SESSION['password']=$hash_session;

$_guest=1;
        }
}
// DETECT IF SOMETHING IN THE DATACLIENT DB (NEW FROM MARCH 2016) AND MAKE THE CONNECTION IF THERE IS SOMETHING
// DEMO : WITHOUT SYNCHRO -/- LIVE : WITH SYNCHRO.


$_login_id=$_SESSION['login'];$_login_id=str_replace(",","",$_login_id);$_login_id=str_replace("(","",$_login_id);$_login_id=str_replace(")","",$_login_id);
$_password_id=$_SESSION['password'];

$_md5password=md5($_password_id);

include ("connect_db.php");
$SQL="select id from clientdata where accountid='".$_login_id."' and accountpwd='".$_password_id."'";
$R=mysql_query($SQL);

// REGISTER HISTORY LOGIN//

$SQL="insert into historylogin values('','','".$_login_id."','".$_password_id."','".$_SERVER['REMOTE_ADDR']."',NOW())";

mysql_query($SQL);

list ($id)=mysql_fetch_array($R);
echo mysql_error();
if ($id!="")
	{
		$SQL2="select balance from balance where account='".$_login_id."'";
		$RR=mysql_query($SQL2);
		list($balance)=mysql_fetch_array($RR);
		if (!(isset($_SESSION['partner'])))
		{
		header("location:index.php?balance=".$balance);
		}
		else
		{
			header("location:iframe.php?balance=".$balance."&partner=".$_SESSION['partner']);
		}
	}
include("end_db.php");





?>