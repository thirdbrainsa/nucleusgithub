<?php
set_time_limit(0);
include ("config.php");
foreach ($_FX as $key=>$value)
{

$path_windows_ask=$_path_fopen."//".$value."//ASK//value.txt";
$path_windows_bid=$_path_fopen."//".$value."//BID//value.txt";
$path_last_ask=$_path_fopen."//".$value."//ASK/value_last.txt";

// HISTORY
$path_history_ask=$_path_fopen."//".$value."//HISTORY/ASK//value.txt";
$ask=file_get_contents($path_windows_ask);
$bid=file_get_contents($path_windows_bid);

$ask_last=file_get_contents($path_last_ask);
//echo " ".$ask_last;
$bgcolor="black";$change=0;
if ($ask>$ask_last) {$bgcolor="green";$change=1;} 
if ($ask<$ask_last) {$bgcolor="red";$change=2;}
//if ($ask==$ask_last) {$bgcolor="black";}

$file=fopen($path_last_ask,"w");
fputs($file,$ask);
fclose($file);

echo"<div id='currencyihm'>";
if ($change==0)
{
echo "<div id='".$value."'><b>".$value."</b><br><div id='price_".$value."'>".$ask."/".$bid."</div></div>";
}
if ($change==1)
{
echo "<div id='".$value."'><b>".$value."</b><br><div id='price_".$value."'><b>".$ask."</b>/".$bid."</div></div>";
}
if ($change==2)
{
echo "<div id='".$value."'><b>".$value."</b><br><div id='price_".$value."'>".$ask."/<b>".$bid."</b></div></div>";
}
echo"</div>";
?>
<script>
document.getElementById("price_<?php echo $value ?>").style.color='<?php echo $bgcolor ?>';
</script>
<?php
}
?>
