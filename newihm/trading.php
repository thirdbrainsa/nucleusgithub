<link rel="stylesheet" href="css/signal.css?<?php echo time();?>">
<link type="text/css" rel="stylesheet" href="css/box.css">
 <link type="text/css" rel="stylesheet" href="css/table.css">
 <link rel="stylesheet" href="font/css/font-awesome.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="js/manage.js?time=<?php echo time() ?>"></script>
<?php
set_time_limit(0);
include ("config.php");
include ("connect_db.php");
//include("librairies/manage.php");
$token="878hiujhjhjh";
?>
<div id='currencyglobal'></div>
<div id='datainfo'></div>
<script>
setInterval(function(){ startRefreshRateForTrading('<?php echo $token;?>'); } , 1000);
</script>