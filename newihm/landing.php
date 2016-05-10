<?php 
$token=0;
?>
<link rel="stylesheet" href="css/pure.css">
<link rel="stylesheet" href="css/signal.css">
<link type="text/css" rel="stylesheet" href="css/box.css">
 <link type="text/css" rel="stylesheet" href="css/table.css">
 <link rel="stylesheet" href="font/css/font-awesome.min.css">
 <script src="js/jquery.js"></script>
<script type="text/javascript" src="js/manage.js?time=<?php echo time() ?>"></script>
 <table width=960 border=0 cellpadding=0 cellspacing=0>
 <tr>
 <td colspan=2>
<form class="pure-form" method="post" class="af-form-wrapper" accept-charset="UTF-8" action="https://www.aweber.com/scripts/addlead.pl" target="_new" >
    <fieldset>
        <legend>Learn how to connect your trading account, use it and make money with our forex and cfd signals</legend>
<input type="hidden" name="meta_web_form_id" value="2063142284" />
<input type="hidden" name="meta_split_id" value="" />
<input type="hidden" name="listname" value="mirrortrader" />
<input type="hidden" name="redirect" value="https://www.aweber.com/thankyou-coi.htm?m=video" id="redirect_48772dcafc584d3de9447cfe65ca1950" />
<input type="hidden" name="meta_adtracking" value="Simple-Form-Landing.php" />
<input type="hidden" name="meta_message" value="1" />
<input type="hidden" name="meta_required" value="email" />
<input type="hidden" name="meta_tooltip" value="email||Your email" />
        <input id="awf_field-80853112" type="email" name="email" placeholder="Give a valid email and follow instructions" size=50>
        <button type="submit" class="pure-button pure-button-primary"> YES ! Give me more information</button>
	<legend>Since 2011, we built the best forex  strategies, up to 10'000 pips by year with minimal drawdown</legend>
    </fieldset>
</form>
 </td>
 <td>
 </td>
  </tr>
 <tr>
  <td valign=top witdh=480 halign=left>
<div id='activesignal'>
<?php if (!(isset($_GET['onlyClose']))) {
echo "<img src='img/ajax-loader.gif'>";
}?>
<?php if (!(isset($_GET['onlyClose']))) { ?>
<script>
setInterval(function(){ startRefresh('<?php echo $token;?>'); } , 1000);
</script>
<?php 

} ?>
</div>
</td>
<td valign=top witdh=480 halign=left>
<div id='historysignal'>
<?php if (!(isset($_GET['onlyActive']))) {
echo "<img src='img/ajax-loader.gif'>";
}?>
<script>
<?php if (!(isset($_GET['onlyActive']))) { ?>
setInterval(function(){ startRefreshHistory('<?php echo $token;?>'); } , 1000);
<?php
 } 
?>
</script>
</div>
</td></tr>
<?php
if (isset($_SESSION['password']))
{
?>
<tr>
<td colspan=2>

<div id='boxglobalinfo'>
</div>
</td>
</tr>
<?php
}
?>
<tr>
<td colspan=2>
<div id='datainfo'>
</div>
</td>
</tr>
<tr>
<td colspan=2>
<img src='thirdbrainfx.gif'><br>
Tel : +41 22 534 90 24<br>
Skype : support.thirdbrainsa<br>
Email us: <a href="mailto:info@socialstyle.com">support@thirdbrain.ch</a>
</center>
<br>
<div align=left>
<ul class="social-bookmarks">
<li class="youtube last">
<a href="https://www.youtube.com/user/thirdbrainfx">Youtube</a>
</li>
<li class="facebook first">
<a href="http://www.facebook.com/thirdbrainfx">Facebook</a>
</li>
<li class="twitter">
<a href="http://twitter.com/thirdbrainfx">Twitter</a>
</li>
<li class="linkedin">
<a href="http://www.linkedin.com/company/2807982">Linkedin</a>
</li>
</ul>
</td>
</tr>
</table>
<script>
document.getElementById('boxglobalinfo').innerHTML="<?php echo $message ?>";
</script>
<?
if (!(isset($_GET['include'])))
{
include("tracking.php");
}
?>