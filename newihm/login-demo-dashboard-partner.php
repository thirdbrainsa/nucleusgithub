<?php
include("config.php");
session_start();
session_destroy();
$_SESSION['logprocess']=0;
$_SESSION['partner']=$_GET['partner'];
//print_r($_SESSION);
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <title>DEMO :: ThirdBrainFx Login Page</title>
   <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]--> 
    <!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">-->
     <script type="text/javascript" src="js/aes_encrypt.js"></script>
    <script type="text/javascript" src="js/aes_encrypt_function.js"></script>
    <link type="text/css" rel="stylesheet" href="css/box2.css">
    <script src="js/jquery.js" type="text/javascript"></script>
     <script type="text/javascript" src="js/xAPI-login.js"></script> 

        <link rel="stylesheet" type="text/css" href="css/style-login.css" /> <link type="text/css" rel="stylesheet" href="box2.css">
<script type="text/javascript">
localStorage.clear();
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56538817-3', 'auto');
  ga('send', 'pageview');

</script>

  </head>

  <body><center>
  </center>
<?php  
if (isset($_GET['error']))
	{
	
	?>
	<div id='outer' style="width: 960px; height:270px; margin: 0px 0px; margin-top:0px; padding:10px">
<div id="dialog">
	<div id="dialog-bg">
       	<div id="dialog-title">Your can't access our platform now</div>
           <div id="dialog-description"> Perhaps your login is wrong, perhaps your password is wrong.<br> Please check your credential and try again <br>
	   Perhaps you don't have the good access to be able to see our member zone or you are not using the right access (live or demo ?). <br>If you are sure of all access, login and password, it could be temporary problem to log in. <br> We encourage you to test again in some minutes<br> For any question or trouble, just send an email to support@thirdbrain.ch</div>
	   
           <div id="dialog-buttons">
           <a href="login-demo-dashboard-partner.php?partner=<?php echo $_GET['partner']?>" class="large green button">Ok, i try again </a>
	   <a href="http://www.thirdbrainfx.com" class="large red button" target=_blank>Go to your website</a>
		</div>
	</div>	
</div>
	
	
	
	<?php
	
	}
include ('templateauto-login-dashboard_1st.html');
?>
</body>
</head>
</html>