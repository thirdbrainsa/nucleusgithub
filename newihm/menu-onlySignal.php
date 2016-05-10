<tr>
<td colspan=2>
<a href='http://signal.thirdbrainfx.com/'  class='large red button' target=_blank>[MORE OPTIONS]</a> <a href='http://www.thirdbrainfx.com/tutorial-how-use-and-understand-thirdbrainfx-financial-dashboard/353410955' class='large red button' target=_blank> HELP</a> <a href='http://www.thirdbrainfx.com/deposit' target=_blank class='large red button'>GO LIVE</a> 
<a href='https://www.thirdbrainfx.com/registration/register.php' target=_blank class='large green button'> FREE DEMO </a>
<?php if (!(isset($_GET['onlyActive']))) { ?>
<a href='?onlyActive' class='large green button'>ACTIVE SIGNALS</a>
<?php } ?>
<?php if (!(isset($_GET['onlyClose']))) { ?>
<a href='?onlyClose' class='large green button'>CLOSED SIGNALS</a>
<?php } ?>
<?php if ((isset($_GET['onlyActive'])) || (isset($_GET['onlyClose']) ) ) { ?>
<a href='onlySignal.php' class='large green button'>ALL SIGNALS</a>

<?php } ?>

</td>
</tr>
