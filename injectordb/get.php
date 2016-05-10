<?php
// CONTROL CHECK for LOGIN AND PRIVATEKEY
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
		
		if ( trim($keyprivate)!= trim($_keyprivatesent))
		{
				include("end_db.php");
				echo "VIDE";
				exit;
		}
		else
		{
				// SEND THE LAST ORDER FOR THE PORTFOLIO OF USER ACCOUNT
				$timeGet=time()-$mt4_deltatime;
				$R2="select id,instrument,command,lot,sl,tp,comment from journal_php where accountid='".$_account."' and timeinsert>".$timeGet." order by RAND()";
				//echo"<li>".$R2;
				$RR2=mysql_query($R2);
				$message="";$done=0;
				while (list($id,$instrument,$command,$lot,$sl,$tp,$strategy)=mysql_fetch_array($RR2))
				{
				if ($id!="")
					{
					
					$SS="select id from mt4_distribued where account='".$_account."' and idjournal='".$id."'";
					//echo $SS;
					$SSS=mysql_query($SS);
					list ($id_taken)=mysql_fetch_array($SSS);
					
					if ($id_taken=="")
					{
					
						if ($command=="CLOSE")
							{
								// NEED TO CHANGE THE ID TO CLOSE
								
								$T1="select mt4ticket from id_ticket where primaryid=".$id;
								$TT1=mysql_query($T1);
								list ($mt4ticket)=mysql_fetch_array($TT1);
								if ($mt4ticket!="")
								{
								//echo"<li>".$mt4ticket;
								$T2="select id from journal_php where signature='".$mt4ticket."' and command<>'CLOSE'";
								//echo "<li>".$T2;
								$TTCC2=mysql_query($T2);
								echo mysql_error();
								list ($idrx)=mysql_fetch_array($TTCC2);
								$idx=$idrx;
								}								
							
							}
							else
							{
														$idx=$id;
							}
					   if ($done==0)
					   {
						
						$message=$strategy."|".$instrument."|".$command."|".$tp."|".$sl."|".$lot."|".$idx;
						$R3="insert into mt4_distribued values ('','".$id."','".$_account."',NOW())";
						//echo "<li>".$R3;
						mysql_query($R3);
					   }
						$done++;
					}	
 
					
					//
					
					}
					else
					{
				
				
					}
				}
				if ($message!="")
				{
				 echo $message;
				}
				else
				{
				 echo "VIDE";
				}
				
				
				//
		}
			
		include("end_db.php");
		
	}
?>