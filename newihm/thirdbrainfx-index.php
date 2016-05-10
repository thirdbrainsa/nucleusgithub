 <?php
 session_start();
 ?>
 <link type="text/css" rel="stylesheet" href="css/box.css">
  <link type="text/css" rel="stylesheet" href="css/table.css">
<iframe src='onlySignal.php?fromsignal'  width="1020" height="700" frameborder=0 scrolling="no"></iframe><br>
<a href='http://www.thirdbrainfx.com/tutorial-how-use-and-understand-thirdbrainfx-financial-dashboard/353410955' class='large red button' target=_blank> HELP</a> <a href='http://www.thirdbrainfx.com/deposit' target=_blank class='large red button'>GO LIVE</a> <a href='https://www.thirdbrainfx.com/registration/register.php' target=_blank class='large green button'> FREE DEMO </a>
<?php if (!(isset($_GET['onlyActive']))) { ?>
<a href='?onlyActive' class='large green button'>ACTIVE SIGNALS</a>
<?php } ?>
<?php if (!(isset($_GET['onlyClose']))) { ?>
<a href='?onlyClose' class='large green button'>CLOSED SIGNALS</a>
<?php } ?>
<?php if ((isset($_GET['onlyActive'])) || (isset($_GET['onlyClose']) ) ) { ?>
<a href='onlySignal.php' class='large green button'>ALL SIGNALS</a>

<?php } ?>
<br><br>
<?php include ("menu.php"); ?>
<br>
<font size=-2><b>Financial Signal ThirdBrainFx DashBoard v1.0 made by <a href='http://www.thirdbrain-it.com' target=_blank> ThirdBrainFx IT Division</a>, ThirdBrain SA. @2016 </b></font>
</td>
</tr>
</table>
<script>
document.getElementById('boxglobalinfo').innerHTML="<?php echo $message ?>";
</script>
<?php
include("tracking.php");
?>