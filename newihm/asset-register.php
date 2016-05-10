<?php
include("librairies/manage.php");
include ("config.php");
include ("connect_db.php");
### CHECK TOKEN


if (isset($_GET['token']))	
		{
			if (isset($_GET['type']))
				{
					if ($_GET['type']=="add") {$data=1;} else {$data=0;}
				
				}
				else
				{
				
				exit;
				}
			if (strlen($_GET['token'])!=32) {exit;}
			
			$asset=strip_tags($_GET['asset']);
			$asset=str_replace(",","",$asset);
			$assetX=explode(" ",$asset);
			$asset_db=strtolower($assetX[0]);
			
			if (strlen($asset)>20) {exit;}
			
			$token=$_GET['token'];
						
			$IP=$_SERVER["REMOTE_ADDR"];
			$SQL1="select login,password from temp_login where token='".$token."' and ip='".$IP."'";
			$SQLL1=mysql_query($SQL1);
			list($login)=mysql_fetch_array($SQLL1);
			if ($login!="")
			{
			$L="select iduser from clientasset where iduser='".$login."'";
			$LL=mysql_query($L);
			list($confirm)=mysql_fetch_array($LL);
			echo mysql_error();  
			if ($confirm=="")
				{
					
					$S1="insert into clientasset values('".$login."','','','','','')";
					//echo "<li>".$S1;
					mysql_query($S1);
					echo mysql_error();
				}
			
			$S2="update clientasset set ".$asset_db."=".$data." where iduser='".$login."'";
			//echo "<li>".$S2;
			mysql_query($S2);
			echo mysql_error();
			echo "GOOD";
			}
			else
			{
			
			echo "BAD";
			}
		}
include("end_db.php");
?>