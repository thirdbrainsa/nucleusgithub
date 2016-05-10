<?php
if (isset($_GET['login']))	
	{
		$_account=strip_tags(trim($_GET['login']));
		
		if (strlen($_account)!=6)
			{
			  echo "VIDE";
			  exit;
			}
		include("config.php");
		include("connect_db.php");
		
		$R1="select keyprivate from mt4bridge where active=1 and account='".$_account."'";
		//echo "<li>".$R1;
		$RR1=mysql_query($R1);
		list($keyprivate)=mysql_fetch_array($RR1);
		
		$_keyprivatesent=strip_tags(trim($_GET['key']));
		
		if ($keyprivate!=$_keyprivatesent)
		{
				include("end_db.php");
				echo "VIDE";
				exit;
		}
		else
		{
		
				
				// SEND THE LAST ORDER FOR THE PORTFOLIO OF USER ACCOUNT
				$ID=strip_tags(trim($_GET['id']));
				$ID=intval($ID);
				$SQL="delete from mt4_distribued where idjournal=".$ID;
				mysql_query($SQL);
				
				$SQL="insert into attempte_db values ('".$_account."','".$ID."',NOW())";
				mysql_query($SQL);	
				
				
				
				include("end_db.php");
				
		}
	}
?>