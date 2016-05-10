<?php
include("librairies/manage.php");
include ("config.php");
include ("connect_db.php");
### CHECK TOKEN
$table="portofolio_dashboard";

if (isset($_GET['token']))	
		{
			$token=strip_tags($_GET['token']);
			$token=str_replace(",","",$token);
			$token=str_replace("(","",$token);
			$token=str_replace(")","",$token);
			
			$IP=$_SERVER["REMOTE_ADDR"];
			$SQL1="select login,password from temp_login where token='".$token."' and ip='".$IP."'";
			//echo "<li>".$SQL1;
			$r=mysql_query($SQL1,$mysql);
			//echo mysql_error();
			list($login,$password)=mysql_fetch_array($r);
			if ($login=="") {$login=$token;$password=$token;$table="portofolio_dashboard_guest";}
			if ($login!="")
				{
				
				$_STRATEGY=strip_tags($_GET['strategy']);
				if (strlen($_STRATEGY)>20) {exit;}
				$_INSTRUMENT=strip_tags($_GET['instrument']);
				if (strlen($_INSTRUMENT)>10) {exit;}	
				
						if (isset($_GET['command']))
						{
						
							if ($_GET['command']=="DELETE")
								{
								
								$SQL2="DELETE from ".$table." where accountid='".$login."' and instrument='".$_INSTRUMENT."' and strategy='".$_STRATEGY."'";
								//echo "<li>".$SQL2;
								mysql_query($SQL2);
								//echo mysql_error();
								echo "GOOD";
								}
								
							if ($_GET['command']=="LOTSIZEUP")
								{
								$SQL2="UPDATE  ".$table." set lot=lot+0.01 where accountid='".$login."' and instrument='".$_INSTRUMENT."' and strategy='".$_STRATEGY."'";
								//echo "<li>".$SQL2;
								mysql_query($SQL2);
								//echo mysql_error();
								echo "GOOD";
								
								
								}
							if ($_GET['command']=="LOTSIZEDOWN")
								{
								$SQL3="select lot from ".$table." where accountid='".$login."' and instrument='".$_INSTRUMENT."' and strategy='".$_STRATEGY."'";
								
								$SQL2="UPDATE  ".$table." set lot=lot-0.01 where accountid='".$login."' and instrument='".$_INSTRUMENT."' and strategy='".$_STRATEGY."'";
								//echo "<li>".$SQL2;
								mysql_query($SQL2);
								//echo mysql_error();
								echo "GOOD";
								
								
								}
						
						}
						else
						{
						
						### COUNT NUMBER INSIDE DASHBOARD
						$R=mysql_query("select count(id) from ".$table." where accountid='".$login."'");
						list($countS)=mysql_fetch_array($R);
						echo mysql_error();
						if ($countS>=$_max_dashboard)
							{
								echo "MAXSTRAT";
							        exit;
							}
						###
						$time=time();
						
						if (strlen($login)>6) {$live=1;} else {$live=0;}
						
					        $SQL2="insert into ".$table." values ('','".$login."','".$password."','".$_INSTRUMENT."','".$_STRATEGY."','0.01','','".$time."','".$live."')";
						mysql_query($SQL2);
						
						echo "GOOD";
				
						}
				}
				else
				{
				
				echo "BAD";
				}
			
			
		
		
		
		
		
		}
		else
		{
		
		echo"BAD";
		
		}

include("end_db.php");
?>