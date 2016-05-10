<link rel="stylesheet" href="css/signal.css">
<link rel="stylesheet" href="css/general.css">
<link rel="stylesheet" href="css/box.css">
 <link type="text/css" rel="stylesheet" href="css/message.css">
  <link type="text/css" rel="stylesheet" href="css/table.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
 <script type="text/javascript" src="js/manage.js"></script>
<div id='right'> 
<div id='info_right'></div>
<?php
include("librairies/manage.php");
echo "Last refresh was at ".date("h:i:s A"). "<br>";

// DISPLAY ALL ORDERS BY INSTRUMENT

include ("config.php");
include ("connect_db.php");

$SQL1="SELECT DISTINCT(instrument) from tradedb where digit!=99";

$S1=mysql_query($SQL1,$mysql);

while (list($instrument)=mysql_fetch_array($S1))
{
			include ("template-instrument-general.php");
}


include("end_db.php");
include("menu.php");
include("tracking.php");
?>
</div>
