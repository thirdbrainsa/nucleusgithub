<link rel="stylesheet" href="css/onoff.css">
<link type="text/css" rel="stylesheet" href="css/message.css">
<link rel="stylesheet" href="css/signal.css">
    <link type="text/css" rel="stylesheet" href="css/box2.css">
 <link type="text/css" rel="stylesheet" href="css/table.css">
 <link rel="stylesheet" href="font/css/font-awesome.min.css">
 <script src="js/sortable.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script type="text/javascript" src="js/manage.js?time=<?php echo time() ?>"></script>

<?php
session_start();
require ("config.php");
require("connect_db.php");
echo"<table witdh=100% cellpadding=0 cellspacing=0>";
echo"<caption> OUTSIDE FOREX ADVICES : EQUITIES, ETFS, COMMODITIES</caption>";
echo"<thead><th>Charts</th><th>Category</th><th>Subcategory</th><th>Add/remove</th><th>Symbol</th><th>Description</th><th>H</th><th>H-1</th><th>Quotes(Bid/Ask)</th></thead>";
if (isset($_SESSION['login']))
{
$login=$_SESSION['login'];
$password=$_SESSION['password'];
}
else
{
$login=strip_tags(trim($_GET['login']));
			$_ACCOUNT=$login;
			if ((strlen($login)<>6) && (strlen($login)<>7)) { exit;}
			
			$T="select password from nucleus where account='".$login."'";
			$TT=mysql_query($T);
			list($password)=mysql_fetch_array($TT);
		
			$password_save=$password;
			
}

$K="select token from temp_login where login='".$login."'";
$KK=mysql_query($K);
list($token)=mysql_fetch_array($KK);


   $X="select idinstrument from instrumentcluster where idcluster=4";
   $XX=mysql_query($X);
   while (list($idinstrument)=mysql_fetch_array($XX))
   {
   //echo "<br>".$idinstrument."</br>";
	$S1="select idinstrument from instrumentcluster where idcluster=7 and idinstrument=".$idinstrument;
	//echo "<li>".$S1;
        $SS1=mysql_query($S1);	
	list ($idr)=mysql_fetch_array($SS1);
echo mysql_error();
	if ($idr!="")
		{
		$S2="select idinstrument from instrumentcluster where idcluster=5 and idinstrument=".$idinstrument;
		$SS2=mysql_query($S2);
		list ($idfinal)=mysql_fetch_array($SS2);
		if ($idfinal!="")
		{
		//echo "<li>".$idfinal."</li>";
			$F1="select category,subcategory,symbol,description,ask,bid,lotmin from instrumentdb where id=".$idfinal;
			$FF=mysql_query($F1);
			list ($category,$subcategory,$symbol,$description,$ask,$bid,$lotmin)=mysql_fetch_array($FF);
			$categoryX=explode(" ",$category);
			$F2="select iduser from clientasset where ".$categoryX[0]."=1 and iduser=".$login;
			//echo "<li>".$F2;
			$FF2=mysql_query($F2);
			list($asset)=mysql_fetch_array($FF2);
			if ($asset!="")
				{
					if (strlen($login)==7) {$live=1;} else {$live=0;}
					$time=time();
					$SQL2="insert into portofolio_nucleus values ('','".$login."','".$password."','".$symbol."','".$category."','".$lotmin."','','".$time."','".$live."')";
					mysql_query($SQL2);
						
				
				
					$F3="select pourc,lastpourc from instrumenttrend where id=".$idfinal;
					$FF3=mysql_query($F3);
					list($pourc,$lastpourc)=mysql_fetch_array($FF3);
					$strategy=$category;
					$symbolC=str_replace("_4","",$symbol);
					echo"<tr>";
					echo"<td>";
					echo"<a href='charts.php?strategy=".$strategy."&instrument=".$symbol."'><i class='fa fa-bar-chart fa-2x'></i></a>";
					echo"</td>";
					echo"<td>";
					echo $category;
					echo"</td>";
					echo"<td>";
					echo $subcategory;
					echo"</td>";
					echo"<td>";
					

		$SSS="select id,lot,accountpwd from portofolio_dashboard where accountid='".$login."' and instrument='".$symbol."'";
		//echo"<li>".$SSS;
	
		//echo "<li>".$SSS;
					$rrr=mysql_query($SSS);
					list($id_portfolio,$lot_size,$_password_inside)=mysql_fetch_array($rrr);
					if ($id_portfolio=="")
					{
					echo"<div id='por_".strtolower($categoryX[0]).$symbol."'><a href=\"javascript:registerPortfolio('".$login."','".$token."','".strtolower($categoryX[0])."','".$symbol."');\"'><i class=\"fa fa-square-o fa-2x\"></i></a></div>";
					echo"<div id='lot_".strtolower($categoryX[0]).$symbol."'></div>";
					}
					else
					{
					echo"<div id='por_".strtolower($categoryX[0]).$symbol."'><a href=\"javascript:removePortfolio('".$login."','".$token."','".strtolower($categoryX[0])."','".$symbol."');\"><i class=\"fa fa-check-square fa-2x\"></i></a></div>";
					echo"<div id='lot_".strtolower($categoryX[0]).$symbol."'><a href=\"javascript:changelotsizedown('".$lot_size."','".$login."','".$token."','".strtolower($categoryX[0])."','".$symbol."');\"'><i class=\"fa fa-sort-desc fa-2x\"></i></a> ".$lot_size."</a> <a href=\"javascript:changelotsizeup('".$lot_size."','".$login."','".$token."','".strtolower($categoryX[0])."','".$symbol."');\"'><i class=\"fa fa-sort-asc fa-2x\"></i></a></div>";
					}
					
					
					echo"</td>";
					echo"<td>";
					echo str_replace("_4","",$symbol);
					echo"</td>";
					echo"<td>";
					echo $description;
					echo"</td>";
					echo"<td>";
					echo $pourc." %";
					echo"</td>";
					echo"<td>";
					echo $lastpourc." %";
					echo"</td>";
					echo"<td>";
					echo "<a href='chartsequitiesprices.php?id=".$idfinal."'>".$bid."|".$ask."</a>";
					echo"</td>";
							echo"</tr>";
				}
		}
		}
   }

require ("end_db.php");
?>