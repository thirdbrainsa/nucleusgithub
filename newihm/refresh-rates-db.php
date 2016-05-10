<?php
set_time_limit(0);
include ("config.php");
$count=count($_FX);
$SQL="select distinct(instrument),ask,bid from rates order by timestamp desc limit 0,".$count;
include("connect_db_rates.php");
$S=mysql_query($SQL,$mysql);
$change=0;
while (list($value,$ask,$bid)=mysql_fetch_array($S))
 {

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
include("end_db.php");
?>
