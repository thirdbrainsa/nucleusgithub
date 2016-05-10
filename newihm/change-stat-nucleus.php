<?php
include ("config.php");
include ("connect_db.php");
if (isset($_GET['token']))

{
	$token=strip_tags(trim($_GET['token']));
		$token=str_replace(",","",$token);
	$token=str_replace("(","",$token);
	$token=str_replace(")","",$token);
	if  (strlen($token)!=32) {exit;}
	$IP=$_SERVER["REMOTE_ADDR"];
	$SQL1="select login,password,lotsize  from temp_login where token='".$token."' and ip='".$IP."'";
	//echo "<li>".$SQL1;
	$r=mysql_query($SQL1,$mysql);
	echo mysql_error();
	list($login,$password,$lot)=mysql_fetch_array($r);
	echo mysql_error();
	if ($login!="")
			{
				$SQL2="select account from nucleus where account='".$login."'";
				$RR2=mysql_query($SQL2);
				list($account)=mysql_fetch_array($RR2);
				if ($account!="")
					{
					
						$SQL3="delete from nucleus where account='".$login."'";
					}
					else
					{
						
						$SQL3="insert into nucleus values ('".$login."','".$password."','".$lot."')";
					
					}
				mysql_query($SQL3);
			
			}
}
else
{

exit;

}



include ("end_db.php");
?>