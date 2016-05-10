<?php
$sell=0;$buy=0;
$SQL2="SELECT command,instrument,price, sl, tp, profit,whenopen from tradedb where strategy='".$instrument."' and command<2 and digit!=99 order by whenopen desc";
$S2=mysql_query($SQL2,$mysql);
$SQL3= "SELECT SUM(profit) from tradedb where strategy='".$instrument."' and digit!=9";
echo "<table>";
echo "<thead>";
echo "<tr><th>Instrument</th><th>Order</th><th>When</th><th>Profit</th><th>Price</th><th>SL</th><th>TP</th></tr>";
echo"</thead>";
echo "<tbody>";
while (list ($command,$ins,$price,$sl,$tp,$profit,$whenopen)=mysql_fetch_array($S2))
{
	

	echo "<tr>";
	echo"<td><a href='general.php'>".$ins."</a></td>";
	if ($command==0) {
	
	$commandD="BUY";
	$buy++;
	} 
	if ($command == 1)
	{
	$commandD="SELL";
	$sell++;
	}
	
	echo"<td>".$commandD."</td>";
	echo"<td>".$whenopen."</td>";
	echo"<td>".$profit."</td>";
	echo"<td>".$price."</td>";
	echo"<td>".$sl."</td>";
	echo"<td>".$tp."</td>";
	echo"</tr>";
}
echo"</tbody>";
echo"<tfoot>";
echo"<tr>";
echo"</tr>";
echo"</tfoot>";
echo"</table>";
$S3=mysql_query($SQL3,$mysql);
echo mysql_error();
list ($SUM_DISPLAY)=mysql_fetch_array($S3);
$SUM_DISPLAY=intval($SUM_DISPLAY);
?>
<script>
document.getElementById('history_<?php echo $instrument ?>').innerHTML='<?php echo $SUM_DISPLAY ?> pips'+' Buy : <?php echo $buy ?>'+' Sell : <?php echo $sell ?>';
</script>
<?php
if ($SUM_DISPLAY<0)
{
?>
<script>
//document.getElementById('<?php echo $instrument ?>').style.backgroundColor = "red";
</script>
<?php
}

