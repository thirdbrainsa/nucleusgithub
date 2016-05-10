<?php
session_start();
if (isset($_SESSION['login']))
{
 $login=$_SESSION['login'];
 $token=$_SESSION['token'];
 $password=$_SESSION['password'];
$ok=1;
 }
 else
 {
 $ok=0;
 $login="";
 }
 //echo "<li>".$login;
?>
<link type="text/css" rel="stylesheet" href="css/message.css">
<link rel="stylesheet" href="css/signal.css">
<link type="text/css" rel="stylesheet" href="css/box.css">
 <link type="text/css" rel="stylesheet" href="css/table.css">
 <link rel="stylesheet" href="font/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
 <script type="text/javascript" src="js/manage.js?time=<?php echo time() ?>"></script>
<?php
include ("config.php");
include ("connect_db.php");
$SQL="select instrument,strategy,whenopen,profit,count,dayprofit,drawdown,winningperc,awt,alt,tbx_score from ranking order by tbx_score desc,profit desc";
$R=mysql_query($SQL);
echo mysql_error();
?>
<div id='message'></div>
<?php
$_ERROR=0;$message="";
include("menu.php");echo"<br>";
while (list($instrument,$strategy,$whenopen,$profit,$count,$dayprofit,$drawdown,$winninperc,$awt,$alt,$tbx_score)=mysql_fetch_array($R))
{
	$SS="select SUM(profit), COUNT(id) from tradedb where instrument='".$instrument."' AND strategy='".$strategy."' and digit!=99";
   	$Q=mysql_query($SS,$mysql);
	list ($sumprofit,$traderunning)=mysql_fetch_array($Q);
	if ($ok==1)
	{	
	        $id_portfolio="";$lot_size="";
		$SSS="select id,lot,accountpwd from portofolio_dashboard where accountid='".$login."' and instrument='".$instrument."' and strategy='".$strategy."'";
		$rrr=mysql_query($SSS);
		list($id_portfolio,$lot_size,$_password_inside)=mysql_fetch_array($rrr);
		if (($_password_inside!=$password) && ($_password_inside!=""))
		{
			$message=" Your portfolio was created with an another password for your account. We have detected 2 passwords differents, we need to state on what is the good ones for security reasons. You need to re-synchronize by login giving the right password, logout and login again <a href='logout.php'>Logout</a>. <br> If you made a change directly inside xStation, please contact support at support@thirdbrain.ch, we will check and change the password inside your portfolio. During this time the trade are blocked and won't be send (except close orders).";
			$_ERROR=1;$addhtml="AUTOTRADING DISABLED";
		}
		if ($_ERROR!=1)
		{
		
		if (in_array($instrument,$_FX))
		 {
		
		if ($id_portfolio=="")
			{
			$addhtml="<div id='por_".$strategy.$instrument."'><a href=\"javascript:registerPortfolio('".$login."','".$token."','".$strategy."','".$instrument."');\"'><i class=\"fa fa-square-o\"></i></a></div>";
			$addhtml.="<div id='lot_".$strategy.$instrument."'></div>";
			
			}
		else
			{
			$addhtml="<div id='por_".$strategy.$instrument."'><a href=\"javascript:removePortfolio('".$login."','".$token."','".$strategy."','".$instrument."');\"><i class=\"fa fa-check-square\"></i></a></div>";
			$addhtml.="<div id='lot_".$strategy.$instrument."'><a href=\"javascript:changelotsizedown('".$lot_size."','".$login."','".$token."','".$strategy."','".$instrument."');\"'><i class=\"fa fa-sort-desc\"></i></a> ".$lot_size."</a> <a href=\"javascript:changelotsizeup('".$lot_size."','".$login."','".$token."','".$strategy."','".$instrument."');\"'><i class=\"fa fa-sort-asc\"></i></a></div>";
		
			}
		 }
		 else
		 {

			$addhtml="<div id='por_".$strategy.$instrument."'>Not available for autotrading</div>";
			

		 }
	        }
		
	 }
	 else
	 {
	 $addhtml="";
	 }
	echo"<div id='eachcurrency' style='float: left;'><h2>".$instrument."</h2>".$addhtml."<h3><a href='http://www.thirdbrainfx.com/search/node/".$strategy."' target=_".$strategy."><font color=orange>".$strategy."</font></a></h3><br><b>Profit</b>: ".$profit." pips<br> <b>MaxDD</b> : ".$drawdown." pips <br><b>Trades</b>: ".$count." trades<br>".$winninperc." %<br><b>TBX Score</b>: ".$tbx_score."</div>";

}



if ($_ERROR==1)
{
 ### BLOCK PORTFOLIO

 $SQL="insert into blockportfolio values('".$login."','1')";
 mysql_query($SQL);
 echo mysql_error();

 ###

?>
<script>
document.getElementById("message").innerHTML="<div class='warning'><?php echo $message ?></div>";
</script>

<?php
}
include("end_db.php");
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56538817-1', 'auto');
  ga('send', 'pageview');

</script>