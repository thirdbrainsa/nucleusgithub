<?php
$page="result-compute.php";
//include("securityreferer.php");
include('lang/eng.php');
include("coding-check.php");
?>
<!DOCTYPE html>
<head>
    <meta HTTP-EQUIV="X-UA-COMPATIBLE" CONTENT="IE=EmulateIE9" >
    <script type="text/javascript" src="scripts/d3.min.js"></script>
    <script src="js/jquery-2.0.0.min.js" type="text/javascript"></script> 
    <script type="text/javascript" src="scripts/radialProgress.js"></script>
<script type="text/javascript" src="js/managePortofolio-2.js"></script> 
<script type="text/javascript" src="js/portofolio-add-auto-v2.js?time=<?php echo time(); ?>"></script> 
    <link type="text/css" rel="stylesheet" href="styles/style.css">
 <link type="text/css" rel="stylesheet" href="result-compute.css">
 <link type="text/css" rel="stylesheet" href="box2.css">
 <link rel="stylesheet" href="font/css/font-awesome.min.css">
 <link rel="stylesheet" href="css/message.css">
</head>

<body>
<div id='explain'>
<a href='display_variable_graph.php' class="large green button"><?php echo _choosemonthlygain ?><i class="fa fa-cog fa-1x"></i> <?php echo _AnalysistostarttheMonteCarlosimulation ?></a>
</div>
<div id='warning' class='warning'></div>
<div id='explain2'>
</div>
<div id='outer' style="width: 960px; height:270px; margin: 0px 0px; margin-top:0px; padding:10px">
<?php
echo _balancetoolow;
?>
<div id='titlerisk'><?php echo _MONTHLYGAIN ?></div><br>
    <div id="main" style="width:960px; height:150px; margin: 0px 0px; ">
        <div id="div1"></div>
        <div id="div2"></div>
        <div id="div3"></div>
        <div id="div4"></div>
        <div id="div5"></div>
	
    </div>
    <div id="explain">
    </div>
<div id='titlerisk'><?php echo _MONTHLYRISK ?></div><br>
     <div id="main2" style="width:960px; height:120px; margin: 0px 0px; ">
    <div id="div6" align=center></div>
        <div id="div7" align=center></div>
        <div id="div8" align=center></div>
        <div id="div9" align=center></div>
        <div id="div10" align=center></div>
	</div>
</div>

<div id="selectmain" style="width:1000px; height:0px; margin: 0px 0px; ">
     <div id='portfolio'></div>
     <div id='risk'></div>
     <div>
     
     <form name='lote' method="POST" action="register-portfolio.php" >
<input type='hidden' name="lot1" id='lot1' value=<?php echo floatval($_GET['lo1']); ?>>
<input type='hidden' name="lot2" id='lot2' value=<?php echo floatval($_GET['lo2']); ?>>
<input type='hidden' name="lot3" id='lot3' value=<?php echo floatval($_GET['lo3']);?>>
<input type='hidden' name="lot4" id='lot4' value=<?php echo floatval($_GET['lo4']); ?>>
<input type='hidden' name="lot5" id='lot5' value=<?php echo floatval($_GET['lo5']); ?>>
<input type='hidden' name="profile" id='profile' value="">
<input type="submit" value="Submit">
</form>
</div>
</div>





<script language="JavaScript">
//window.alert("compute");

if (localStorage.getItem("OnClickBubble")!=1)
{
////alert("no bubble");
document.getElementById('warning').innerHTML='<?php  echo _NOBUBBLESELECTED; ?>';
}
else
{

document.getElementById('warning').innerHTML='<?php  echo _NOWYOURPORTFOLIOISSELECTED; ?>';
}


var div = document.getElementById('selectmain');
div.style.visibility = 'hidden';
if  (localStorage.getItem("BalanceC")>50) 
{
var div = document.getElementById('dialog');
div.style.visibility = 'hidden';
}
if (localStorage.getItem("bypass")==1)
{
var div = document.getElementById('dialog');
div.style.visibility = 'hidden';

}

var div = document.getElementById('explain');
div.style.visibility = 'hidden';

    var div1=d3.select(document.getElementById('div1'));
    var div2=d3.select(document.getElementById('div2'));
    var div3=d3.select(document.getElementById('div3'));
    var div4=d3.select(document.getElementById('div4'));
    var div5=d3.select(document.getElementById('div5'));
    var div6=d3.select(document.getElementById('div6'));
    var div7=d3.select(document.getElementById('div7'));
    var div8=d3.select(document.getElementById('div8'));
    var div9=d3.select(document.getElementById('div9'));
    var div10=d3.select(document.getElementById('div10'));
    
    if (localStorage.getItem("autoportfoliostep")==2)
    {
    //localStorage.setItem("history_profile","medium");
    localStorage.setItem("autoportfoliostep",3);
    
    }
    
   if (localStorage.getItem("history_profile")=="high")
	{
		 onClick4();
	}
    if (localStorage.getItem("history_profile")=="medium")
        {
		 onClick3();
		 if (localStorage.getItem("autoportfoliostep")==3)
		 {
		 localStorage.setItem("autoportfoliostep",6);
		 }
	}
    if (localStorage.getItem("history_profile")=="low")
	{
		 onClick2();
	}
     if (localStorage.getItem("history_profile")=="conservative")
	{
		 onClick1();
	}
      if (localStorage.getItem("history_profile")=="custom")
	{
		 onClick5();
	}
    start();
  
    //addPortfolio();
    //var toto=document.getElementById("portfolio").innerHTML;
//window.alert(toto);

    function onClick1() {
        deselect();
	document.getElementById('warning').innerHTML='<?php  echo _HASBEENSELECTEDRISK; ?>';
        div1.attr("class","selectedRadial");
	var div = document.getElementById('explain');
	div.style.visibility = 'visible';
	//alert("SELECT CONSERVATIVE");
        document.getElementById("risk").innerHTML="CONSERVATIVE";
	localStorage.setItem("profile","conservative");
	if (localStorage.getItem("history_profile")!=localStorage.getItem("profile"))
	{
	localStorage.setItem("changeportofolio","0");
	}
	localStorage.setItem("history_profile","conservative");
	localStorage.setItem("lot_to_use","<?php echo floatval($_GET['lo1']); ?>");
	localStorage.setItem("OnClickBubble",1);
	document.forms["lote"].elements["profile"].value="conservative";
	//var div = document.getElementById('dialog');
        //div.style.visibility = 'visible';
        //document.lote.submit();	
	
	if (localStorage.getItem("changeportofolio")!=1)
	{
	var chain=get_active_currencies();
	chain = chain.substring(0, chain.length - 1);
	var UrlToSend="register-portfolio.php?user="+localStorage.getItem("userID")+"&lot="+localStorage.getItem("lot_to_use")+"&risk="+localStorage.getItem("r1")+"&gain="+localStorage.getItem("p1")+"&list_of_portfolio="+chain+"&profile=conservative";
	 //window.location.assign(UrlToSend);   
	 GetDivInnerHtml(UrlToSend);
	 localStorage.setItem("changeStatelock","1");
	}
    }

    function onClick2() {
        
	var div = document.getElementById('explain');
	document.getElementById('warning').innerHTML='<?php  echo _HASBEENSELECTEDRISK; ?>';
	div.style.visibility = 'visible';
	deselect();
	localStorage.setItem("OnClickBubble",1);
        div2.attr("class","selectedRadial");
	//alert("SELECT LOW");
	document.getElementById("risk").innerHTML="LOW";
	document.forms["lote"].elements["profile"].value="low"; 
	localStorage.setItem("profile","low");
	if (localStorage.getItem("history_profile")!=localStorage.getItem("profile"))
	{
	localStorage.setItem("changeportofolio","0");
	}
	localStorage.setItem("history_profile","low");
	localStorage.setItem("lot_to_use","<?php echo floatval($_GET['lo2']); ?>");
	//var div = document.getElementById('dialog');
        //div.style.visibility = 'visible';	
	
	if (localStorage.getItem("changeportofolio")!=1)
	{
	var chain=get_active_currencies();
	chain = chain.substring(0, chain.length - 1);
	var UrlToSend="register-portfolio.php?user="+localStorage.getItem("userID")+"&lot="+localStorage.getItem("lot_to_use")+"&risk="+localStorage.getItem("r2")+"&gain="+localStorage.getItem("p2")+"&list_of_portfolio="+chain+"&profile=low";
	 //window.location.assign(UrlToSend);
 GetDivInnerHtml(UrlToSend);	
 localStorage.setItem("changeStatelock","1"); 
	}
    }

    function onClick3() {
document.getElementById('warning').innerHTML='<?php  echo _HASBEENSELECTEDRISK; ?>';
    var div = document.getElementById('explain');
	div.style.visibility = 'visible';
        deselect();
	localStorage.setItem("OnClickBubble",1);
        div3.attr("class","selectedRadial");
	//alert("SELECT MEDIUM");
	document.getElementById("risk").innerHTML="MEDIUM";
	document.forms["lote"].elements["profile"].value="medium"; 
	localStorage.setItem("profile","medium");
	if (localStorage.getItem("history_profile")!=localStorage.getItem("profile"))
	{
	localStorage.setItem("changeportofolio","0");
	}
	localStorage.setItem("history_profile","medium");
	localStorage.setItem("lot_to_use","<?php echo floatval($_GET['lo3']); ?>");
	//var div = document.getElementById('dialog');
        //div.style.visibility = 'visible';
	if (localStorage.getItem("changeportofolio")!=1)
	{
	var chain=get_active_currencies();
	chain = chain.substring(0, chain.length - 1);
	var UrlToSend="register-portfolio.php?user="+localStorage.getItem("userID")+"&lot="+localStorage.getItem("lot_to_use")+"&risk="+localStorage.getItem("r3")+"&gain="+localStorage.getItem("p3")+"&list_of_portfolio="+chain+"&profile=medium";
	 //window.location.assign(UrlToSend);   
	  GetDivInnerHtml(UrlToSend);
	  localStorage.setItem("changeStatelock","1");
	}
   }
    
     function onClick4() {
 document.getElementById('warning').innerHTML='<?php  echo _HASBEENSELECTEDRISK; ?>';
     localStorage.setItem("OnClickBubble",1);
     var div = document.getElementById('explain');
	div.style.visibility = 'visible';
        deselect();
        div4.attr("class","selectedRadial");
	//alert("SELECT HIGH");
	document.getElementById("risk").innerHTML="HIGH";
	document.forms["lote"].elements["profile"].value="high"; 
	localStorage.setItem("profile","high");
	if (localStorage.getItem("history_profile")!=localStorage.getItem("profile"))
	{
	localStorage.setItem("changeportofolio","0");
	}
	localStorage.setItem("history_profile","high");
	localStorage.setItem("lot_to_use","<?php echo floatval($_GET['lo4']); ?>");
	//var div = document.getElementById('dialog');
        //div.style.visibility = 'visible';
	
	if (localStorage.getItem("changeportofolio")!=1)
	{
	var chain=get_active_currencies();
	chain = chain.substring(0, chain.length - 1);
	var UrlToSend="register-portfolio.php?user="+localStorage.getItem("userID")+"&lot="+localStorage.getItem("lot_to_use")+"&risk="+localStorage.getItem("r4")+"&gain="+localStorage.getItem("p4")+"&list_of_portfolio="+chain+"&profile=high";
	//window.location.assign(UrlToSend);   
	  GetDivInnerHtml(UrlToSend);
	      localStorage.setItem("changeStatelock","1");
	}
    }
    
    function onClick5() {
  document.getElementById('warning').innerHTML='<?php  echo _HASBEENSELECTEDRISK; ?>';
    localStorage.setItem("OnClickBubble",1);
    var div = document.getElementById('explain');
	div.style.visibility = 'visible';
        deselect();
        div5.attr("class","selectedRadial");
	//alert("SELECT GAMBLING");
	document.getElementById("risk").innerHTML="GAMBLING";
	document.forms["lote"].elements["profile"].value="custom"; 
	localStorage.setItem("profile","custom");
	if (localStorage.getItem("history_profile")!=localStorage.getItem("profile"))
	{
	localStorage.setItem("changeportofolio","0");
	}
	localStorage.setItem("history_profile","custom");
	localStorage.setItem("lot_to_use","<?php echo floatval($_GET['lo5']); ?>");
	//var div = document.getElementById('dialog');
        //div.style.visibility = 'visible';
	if (localStorage.getItem("changeportofolio")!=1)
	{
	var chain=get_active_currencies();
	chain = chain.substring(0, chain.length - 1);
	var UrlToSend="register-portfolio.php?user="+localStorage.getItem("userID")+"&lot="+localStorage.getItem("lot_to_use")+"&risk="+localStorage.getItem("r5")+"&gain="+localStorage.getItem("p5")+"&list_of_portfolio="+chain+"&profile=custom";
	 //window.location.assign(UrlToSend);   
	 GetDivInnerHtml(UrlToSend);
	   localStorage.setItem("changeStatelock","1");
	}
   }
    

 function onClick6() {
        deselect();
        div6.attr("class","selectedRadial");
    }

    function onClick7() {
        deselect();
        div7.attr("class","selectedRadial");
    }

    function onClick8() {
        deselect();
        div8.attr("class","selectedRadial");
    }
    
     function onClick9() {
        deselect();
        div9.attr("class","selectedRadial");
    }
    
    function onClick10() {
        deselect();
        div10.attr("class","selectedRadial");
    }



    function labelFunction(val,min,max) {

    }

    function deselect() {
        div1.attr("class","radial");
        div2.attr("class","radial");
        div3.attr("class","radial");
	div4.attr("class","radial");
	div5.attr("class","radial");
	 div6.attr("class","radial");
        div7.attr("class","radial");
        div8.attr("class","radial");
	div9.attr("class","radial");
	div10.attr("class","radial");
    }

    function start() {

	localStorage.setItem("p1","<?php print $_GET['w1'] ?>");
	localStorage.setItem("p2","<?php print $_GET['w2'] ?>");
	localStorage.setItem("p3","<?php print $_GET['w3'] ?>");
	localStorage.setItem("p4","<?php print $_GET['w4'] ?>");
	localStorage.setItem("p5","<?php print $_GET['w5'] ?>");
		localStorage.setItem("r1","<?php print $_GET['l1'] ?>");
	localStorage.setItem("r2","<?php print $_GET['l2'] ?>");
	localStorage.setItem("r3","<?php print $_GET['l3'] ?>");
	localStorage.setItem("r4","<?php print $_GET['l4'] ?>");
	localStorage.setItem("r5","<?php print $_GET['l5'] ?>");
        var rp1 = radialProgress(document.getElementById('div1'))
                .label("Conservative")
                .onClick(onClick1)
                .diameter(150)
                .value(<?php print $_GET['w1'] ?>)
                .render();

        var rp2 = radialProgress(document.getElementById('div2'))
                .label("Low")
                .onClick(onClick2)
                .diameter(150)
                .value(<?php print $_GET['w2'] ?>)
                .render();

        var rp3 = radialProgress(document.getElementById('div3'))
                .label("Medium")
                .onClick(onClick3)
                .diameter(150)
                .value(<?php print $_GET['w3'] ?>)
                .render();
		
	 var rp4 = radialProgress(document.getElementById('div4'))
                .label("High")
                .onClick(onClick4)
                .diameter(150)
                .value(<?php print $_GET['w4'] ?>)
                .render();
		
	 var rp5 = radialProgress(document.getElementById('div5'))
                .label("Custom")
                .onClick(onClick5)
                .diameter(150)
                .value(<?php print $_GET['w5'] ?>)
                .render();
		
	var rp6 = radialProgress(document.getElementById('div6'))
                .label("Conservative")
                .diameter(120)
                .value(<?php print $_GET['l1'] ?>)
                .render();

        var rp7 = radialProgress(document.getElementById('div7'))
                .label("Low")
                .diameter(120)
                .value(<?php print $_GET['l2'] ?>)
                .render();

        var rp8 = radialProgress(document.getElementById('div8'))
                .label("Medium")
                .diameter(120)
                .value(<?php print $_GET['l3'] ?>)
                .render();
		
	 var rp9 = radialProgress(document.getElementById('div9'))
                .label("High")
                .diameter(120)
                .value(<?php print $_GET['l4'] ?>)
                .render();
		
	 var rp10 = radialProgress(document.getElementById('div10'))
                .label("Custom")
                .diameter(120)
                .value(<?php print $_GET['l5'] ?>)
                .render();



    }

setInterval(function() {    

if (localStorage.getItem("inprocesscompute")!=1)
{
testNotSetup();
}
}

,500);



</script>
<?php
include("tracking.php");
?>
</body>
</html>

       <!--
/**
Copyright (c) 2014 BrightPoint Consulting, Inc.

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
*/

              ->