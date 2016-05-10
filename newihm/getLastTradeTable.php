<?php
			include("config.php");
			include("connect_db.php");
$R="SELECT id,command, instrument,price, sl, tp, profit,strategy,timeinsert,whenopen,signature from tradedb where command<2  and digit!=99 ORDER BY timeinsert desc limit 0,48";
$RR=mysql_query($R);
			$pattern="";$i=0;$j=0;
			while (list($id,$command,$instrument,$price,$sl,$tp,$profit,$strategy,$timeinsert,$whenopen)=mysql_fetch_array($RR))
			{
			$delta=time()-$timeinsert-$_MODIFY_DELTA; 
			$min=intval($delta/60);
			$sec=$delta-$min*60;
			if ($min>60) 
			{
			$heure=intval($min/60);
			}
			else
			{
			$heure=0;
			$sec=$delta-$min*60;
			}
			if ($heure==0)
			{
			$timing=$min." min ".$sec." sec ago<br>";
			}
			else
			{
			$timing=$heure." hours ago";
			}


			$price=1;$i++;
			if ($i>10) {$j=$j+1;$i=1;}
			$instrumentX=str_replace("_4","",$instrument);
			$T="select category,description,ask from instrumentdb where symbol='".$instrument."'";
			$TT=mysql_query($T);
			list($category,$descriptionG,$price)=mysql_fetch_array($TT);
			if ($command==0) {$commandX="BUY";} else {$commandX="SELL";}
			$description=$commandX;
			if (strtolower($category)=="forex") {$description=$strategy;} else {$description=$descriptionG;}
			$pattern[]=$instrumentX;
			$pattern[]=$description;
			$pattern[]=$timing;
			$pattern[]=$j;
			$pattern[]=$i;
			}
		
			include("end_db.php");
			echo json_encode($pattern);
			
?>