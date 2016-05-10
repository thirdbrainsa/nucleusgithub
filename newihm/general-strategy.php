<link rel="stylesheet" href="css/general.css">
<link rel="stylesheet" href="css/box.css">
 <link type="text/css" rel="stylesheet" href="css/message.css">
  <link type="text/css" rel="stylesheet" href="css/table.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
 <script type="text/javascript" src="js/manage.js"></script> 
<div id='right'> 
<?php
include("librairies/manage.php");
// DISPLAY ALL ORDERS BY INSTRUMENT
echo "Last refresh was at ".date("h:i:s A"). "<br>";
include ("config.php");
include ("connect_db.php");

$SQL1="SELECT DISTINCT(strategy) from tradedb";

$S1=mysql_query($SQL1,$mysql);
echo mysql_error();
while (list($instrument)=mysql_fetch_array($S1))
{
		// GET THE TRADE RUNNNING WITH THIS INSTRUMENT
		
		
		//

		include ("template-instrument-strategy.php");
}


include("end_db.php");
include("menu.php");
include("tracking.php");
?>

</div>