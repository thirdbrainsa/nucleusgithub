function sendDatatoFilesJSON(url)

{
var xmlhttp;
var d = new Date().getTime();
url=url+'?time='+d;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.open("GET",url,false);
xmlhttp.send();
return (xmlhttp.responseText);
}
function startRobot()
{

	
}
function stopRobot()
{
	
	localStorage.setItem("symbolCurrent","STOPPED");
}
function bonus()
{
 var trade=parseInt(localStorage.getItem("totalTrade"));
 if (trade>1)
	{
		localStorage.setItem("BonusAvailable",5);
		document.getElementById("bonus").innerHTML="A new bonus is actived of 5 USD";
		document.getElementById("bonuscount").innerHTML=localStorage.getItem("totalbonuscount");
		if (parseFloat(localStorage.getItem("totalbonuscount")) > parseFloat(localStorage.getItem("BonusAvailable")) ) 
			{
				alert("YOU GET THE BONUS !!!!");
				localStorage.setItem("totalbonuscount",0);
				localStorage.setItem("totalTrade",0);
				localStorage.removeItem("BonusAvailable");
				document.getElementById("bonus").innerHTML="";
			}
	
	}
	
 
}

function logout()
{
				var msg = {};
				msg.command = "logout";
				send(msg);	

}
function connect()
{
var userId = parseInt($('#userId').val());
var password = $('#password').val();
var cle="La phrase qui est là";
var ciphertext = Aes.Ctr.encrypt(password, cle, 256);
localStorage.setItem("userID",userId);
localStorage.setItem("passwordID",ciphertext);
localStorage.setItem("lot",1);
localStorage.setItem("stopall",0);
localStorage.setItem("startAll",0);
localStorage.setItem("firstTestError",0);
document.getElementById("Balance").innerHTML="";
document.getElementById("Equity").innerHTML="";
localStorage.setItem("totalbonuscount",0);
localStorage.setItem("totalTrade",0);
localStorage.setItem("symbolCurrent","EURUSD");
localStorage.setItem("symbolCurrentId",1);
localStorage.setItem("sessionStart",1)
login();

}

function swapRisk(lot)
{
var balancetest=localStorage.getItem("Equity");
// 0.10 = LOW for 10'000 USD

var nb10000=balancetest/100000;
	
var lowrisk=nb10000;
	
lowrisk=lowrisk.toFixed(2);
var mediumrisk=lowrisk*3;
var highrisk=lowrisk*10;
	
	if (lowrisk<0.01) {lowrisk=0.01;}
	if (mediumrisk<0.03) {mediumrisk=0.02;}
	if (highrisk<0.10) {highrisk=0.03;}
var vlot=0.1;
	
if (lot==1) { vlot=lowrisk*10;}
if (lot==2) { vlot=mediumrisk*10;}
if (lot==3) { vlot=highrisk*10;}

vlot=vlot.toFixed(2);

window.alert(lowrisk+' '+mediumrisk+' '+highrisk+' '+vlot);
localStorage.setItem("mlot",lowrisk);
localStorage.setItem("lot",vlot);
 var x = document.getElementById("risk").getElementsByTagName("td");
  if (lot==1) {  x[1].style.backgroundColor = "#e5e5e4";x[2].style.backgroundColor = "white";x[3].style.backgroundColor = "white"; }
  if (lot==2) {  x[2].style.backgroundColor = "#e5e5e4";x[1].style.backgroundColor = "white";x[3].style.backgroundColor = "white"; }
  if (lot==3) {  x[3].style.backgroundColor = "#e5e5e4";x[2].style.backgroundColor = "white";x[1].style.backgroundColor = "white"; }
}
function swapSymbol()
{
	var x = document.getElementById("ctable").getElementsByTagName("td");
    x[7].style.backgroundColor = "#f0cccc";
	var order=localStorage.getItem("symbolCurrentId");
	order=parseInt(order);
	order=order+1;
	if (order>5) {order=1;}
	if (order==1)
		{
		 localStorage.setItem("symbolCurrent","EURUSD");
		}
	if (order==2)
		{
		 localStorage.setItem("symbolCurrent","GBPUSD");
		}
	if (order==3)
		{
		 localStorage.setItem("symbolCurrent","USDJPY");
		}
	if (order==4)
		{
		 localStorage.setItem("symbolCurrent","USDCHF");
		}
	if (order==5)
		{
		 localStorage.setItem("symbolCurrent","GOLD");
		}
		
	 localStorage.setItem("symbolCurrentId",order);
	 document.getElementById("advicesell").innerHTML="";
	 document.getElementById("advicebuy").innerHTML="";
	 document.getElementById("buy").style.border="0px dashed #000000";
	 document.getElementById("sell").style.border="0px dashed #000000";
	  localStorage.setItem("timer",1798);
}

function closePosition()
{
	localStorage.setItem("waitforanswer",1);
       var notrade=parseInt(localStorage.getItem("notrade"));
	if (notrade==0)
	{
	var lot=localStorage.getItem("lot");
    	var order=localStorage.getItem("order");
	var position=localStorage.getItem("position");
	var cmd=localStorage.getItem("type");
	var price=localStorage.getItem("close_price");
	var symbolOpenedPosition=localStorage.getItem("symbolOpenedPosition");
	   document.getElementById("status").innerHTML="Closing trade "+order+" ..";
	var profit=localStorage.getItem("profit");	
	var msg = {};
	 msg.command = "tradeTransaction";
	var arguments = {};
	     arguments.tradeTransInfo = {};
				  arguments.tradeTransInfo.cmd=parseInt(cmd);
				  arguments.tradeTransInfo.customComment="";
				  arguments.tradeTransInfo.expiration=0;
				  arguments.tradeTransInfo.price= parseFloat(price);
				  arguments.tradeTransInfo.ie_deviation=0;
				  arguments.tradeTransInfo.sl=parseFloat(0);
				  arguments.tradeTransInfo.tp=parseFloat(0);
				  arguments.tradeTransInfo.symbol=symbolOpenedPosition;
				  arguments.tradeTransInfo.type=2;
				  arguments.tradeTransInfo.volume=parseFloat(lot);
				  arguments.tradeTransInfo.order=parseInt(order);
				   //arguments.tradeTransInfo.position=parseInt(position);
				  msg.arguments = arguments;
				 send(msg);
	// remove all local things
	
	
	//
    // Regle des bonus
	if (localStorage.getItem("BonusAvailable")!=undefined)
		{
					
					totalbonuscount=parseFloat(localStorage.getItem("totalbonuscount"))+parseFloat(profit);
					localStorage.setItem("totalbonuscount",totalbonuscount);
			
		
		}
       }
 }
 
 function closethis(order)
 {
	 //window.alert(order);
	 localStorage.setItem("tradeID",order);
 }
 function parseAllSymbol(returnData)
 {
	 var totalTrade=returnData.quotations.length;
	 //window.alert(totalTrade);
	 var stringPos="<table id='keywords' width=952 cellpadding=0 cellspacing=0 border=0>";
	 stringPos=stringPos+'<thead><tr><th>Symbol</th><th>Bid</th><th>Ask</th><th>High</th><th>Low</th><th>Vol.</th><th>Spread</th>';
	  stringPos=stringPos+'<th>Symbol</th><th>Bid</th><th>Ask</th><th>High</th><th>Low</th><th>Vol.</th><th>Spread</th></tr></thead><tbody>';
	 for (var i = returnData.quotations.length - 1; i >= 0; i=i-2) 
						{
							 //window.alert(i);
							var symbol = returnData.quotations[i].symbol;
							var ask=returnData.quotations[i].ask;
							var bid=returnData.quotations[i].bid;
							var high=returnData.quotations[i].high;
							var low=returnData.quotations[i].low;
							
							var diff=(high-low)/((ask+bid)/2);
							var volatility=diff.toFixed(3)*1000;
							volatility=volatility.toFixed(1);
							var spread=returnData.quotations[i].spreadTable;
							stringPos=stringPos+'<tr><td align=center><div id=\'eachcurrency\' onClick=\'changeCurrentandGo(\"'+symbol+'\")\'>'+symbol+'</div></td><td align=center>'+bid+'</td><td align=center>'+ask+'</td><td align=center>'+high+'</td><td align=center>'+low+'</td><td align=center>'+volatility+'</td><td align=center>'+spread+'</td>';
							if (i>0)
							{
							var symbol = returnData.quotations[i-1].symbol;
							var ask=returnData.quotations[i-1].ask;
							var bid=returnData.quotations[i-1].bid;
							var high=returnData.quotations[i-1].high;
							var low=returnData.quotations[i-1].low;
							var diff=(high-low)/((ask+bid)/2);
							var volatility=diff.toFixed(3)*1000;
							volatility=volatility.toFixed(1);
							var spread=returnData.quotations[i-1].spreadTable;
							stringPos=stringPos+'<td align=center><div id=\'eachcurrency\' onClick=\'changeCurrentandGo(\"'+symbol+'\")\'>'+symbol+'</div></td><td align=center>'+bid+'</td><td align=center>'+ask+'</td><td align=center>'+high+'</td><td align=center>'+low+'</td><td align=center>'+volatility+'</td><td align=center>'+spread+'</td></tr>';
							}
							
							
						}
	stringPos=stringPos+'</tbody></table>';
	document.getElementById("symbolist").innerHTML=stringPos;						
	
 }
  function parseAllSymbol3col(returnData)
 {
	 var totalTrade=returnData.quotations.length;
	 //window.alert(totalTrade);
	 var stringPos="<table id='keywords' width=1200 cellpadding=0 cellspacing=0 border=0>";
	 stringPos=stringPos+'<thead><tr><th>Symbol</th><th>Bid</th><th>Ask</th><th>High</th><th>Low</th><th>Vol.</th><th>Spread</th>';
	  stringPos=stringPos+'<th>Symbol</th><th>Bid</th><th>Ask</th><th>High</th><th>Low</th><th>Vol.</th><th>Spread</th>';
	 stringPos=stringPos+'<th>Symbol</th><th>Bid</th><th>Ask</th><th>High</th><th>Low</th><th>Vol.</th><th>Spread</th>';
	  stringPos=stringPos+'</tr></thead><tbody>';
	 for (var i = returnData.quotations.length - 1; i >= 0; i=i-3) 
						{
							 //window.alert(i);
							var symbol = returnData.quotations[i].symbol;
							var ask=returnData.quotations[i].ask;
							var bid=returnData.quotations[i].bid;
							var high=returnData.quotations[i].high;
							var low=returnData.quotations[i].low;
							
							var diff=(high-low)/((ask+bid)/2);
							var volatility=diff.toFixed(3)*1000;
							volatility=volatility.toFixed(1);
							var spread=returnData.quotations[i].spreadTable;
							stringPos=stringPos+'<tr><td align=center><div id=\'eachcurrency\' onClick=\'changeCurrentandGo(\"'+symbol+'\")\'>'+symbol+'</div></td><td align=center>'+bid+'</td><td align=center>'+ask+'</td><td align=center>'+high+'</td><td align=center>'+low+'</td><td align=center>'+volatility+'</td><td align=center>'+spread+'</td>';
							if (i>0)
							{
							var symbol = returnData.quotations[i-1].symbol;
							var ask=returnData.quotations[i-1].ask;
							var bid=returnData.quotations[i-1].bid;
							var high=returnData.quotations[i-1].high;
							var low=returnData.quotations[i-1].low;
							var diff=(high-low)/((ask+bid)/2);
							var volatility=diff.toFixed(3)*1000;
							volatility=volatility.toFixed(1);
							var spread=returnData.quotations[i-1].spreadTable;
							stringPos=stringPos+'<td align=center><div id=\'eachcurrency\' onClick=\'changeCurrentandGo(\"'+symbol+'\")\'>'+symbol+'</div></td><td align=center>'+bid+'</td><td align=center>'+ask+'</td><td align=center>'+high+'</td><td align=center>'+low+'</td><td align=center>'+volatility+'</td><td align=center>'+spread+'</td>';
							}
							
							if (i>1)
							{
							var symbol = returnData.quotations[i-2].symbol;
							var ask=returnData.quotations[i-2].ask;
							var bid=returnData.quotations[i-2].bid;
							var high=returnData.quotations[i-2].high;
							var low=returnData.quotations[i-2].low;
							var diff=(high-low)/((ask+bid)/2);
							var volatility=diff.toFixed(3)*1000;
							volatility=volatility.toFixed(1);
							var spread=returnData.quotations[i-2].spreadTable;
							stringPos=stringPos+'<td align=center><div id=\'eachcurrency\' onClick=\'changeCurrentandGo(\"'+symbol+'\")\'>'+symbol+'</div></td><td align=center>'+bid+'</td><td align=center>'+ask+'</td><td align=center>'+high+'</td><td align=center>'+low+'</td><td align=center>'+volatility+'</td><td align=center>'+spread+'</td></tr>';
							}
							
						}
	stringPos=stringPos+'</tbody></table>';
	document.getElementById("symbolist").innerHTML=stringPos;					
 }
  function parseAllSymbolSpread(returnData)
 {
	 var totalTrade=returnData.quotations.length;
	 //window.alert(totalTrade);
	 var symbolonGoing=localStorage.getItem("symbolCurrent");
	 var stringPos="<div id='thecurrency'>"+symbolonGoing+"</div><br>";
	 var stringPos=stringPos+"<table id='keywords' width=952 cellpadding=0 cellspacing=0 border=0>";
	 stringPos=stringPos+'<thead><tr><th>Symbol</th><th>Bid</th><th>Ask</th><th>High</th><th>Low</th><th>Vol.</th><th>Spread</th>';
	  stringPos=stringPos+'<th>Symbol</th><th>Bid</th><th>Ask</th><th>High</th><th>Low</th><th>Vol.</th><th>Spread</th></tr></thead><tbody>';
	 var isitsomethingtodo=0;
	 var bestofchoose="";
	 var minspread=10;
	 
	 for (var i = returnData.quotations.length - 1; i >= 0; i=i-2) 
						{
							 //window.alert(i);
							var symbol = returnData.quotations[i].symbol;
							
						
							
							
							var ask=returnData.quotations[i].ask;
							var bid=returnData.quotations[i].bid;
							var high=returnData.quotations[i].high;
							var low=returnData.quotations[i].low;
							
							var symbol1=symbol.substr(0,3);
							var symbol2=symbol.substr(3,3);
							
							var keyCurrency1=symbol1+'_color';
							var keyCurrency2=symbol2+'_color';
							
							//alert(keyCurrency1+'/'+keyCurrency2);
							
							var keyCurrency1V=localStorage.getItem(keyCurrency1);
							var keyCurrency2V=localStorage.getItem(keyCurrency2);
							var spread=returnData.quotations[i].spreadTable;
							spread=parseFloat(spread);
							var paircolor="white";
							if (spread<1.5)
							{
							if ((keyCurrency1V=="red") && (keyCurrency2V=="green"))
							  {
								  
								paircolor="red";
								if (symbolonGoing==symbol)
								  {
								  isitsomethingtodo=1;
								  }
								
								if (spread<minspread)
								        {	
								             minspread=spread;
									     bestofchoose=symbol;
									}
								  
									  //alert(keyCurrency1+'/'+keyCurrency2);
							  }
							  
							if ((keyCurrency1V=="green") && (keyCurrency2V=="red"))
							  {
								  
								paircolor="green";
								  if (symbolonGoing==symbol)
								  {
								   isitsomethingtodo=1;
								  }
								  
								  if (spread<minspread)
								        {	
								             minspread=spread;
									     bestofchoose=symbol;
									}
									  //alert(keyCurrency1+'/'+keyCurrency2);
							  }
						          }
							var diff=(high-low)/((ask+bid)/2);
							var volatility=diff.toFixed(3)*1000;
							volatility=volatility.toFixed(1);
							
							if (parseFloat(spread)<1.5)
						{
							stringPos=stringPos+'<tr><td align=center bgcolor='+paircolor+'><div id=\'eachcurrency2\' onClick=\'changeCurrentandGo(\"'+symbol+'\")\'>'+symbol+'</div></td><td align=center>'+bid+'</td><td align=center>'+ask+'</td><td align=center>'+high+'</td><td align=center>'+low+'</td><td align=center>'+volatility+'</td><td align=center>'+spread+'</td>';
							}	
							
							if (i>0)
							{
							var symbol = returnData.quotations[i-1].symbol;
							var symbol1=symbol.substr(0,3);
							var symbol2=symbol.substr(3,3);
							
							var keyCurrency1=symbol1+'_color';
							var keyCurrency2=symbol2+'_color';
							
							//alert(keyCurrency1+'/'+keyCurrency2);
							
							var keyCurrency1V=localStorage.getItem(keyCurrency1);
							var keyCurrency2V=localStorage.getItem(keyCurrency2);
							var spread=returnData.quotations[i-1].spreadTable;
							var paircolor="white";
							if (spread<1.5)
							{
							if ((keyCurrency1V=="red") && (keyCurrency2V=="green"))
							  {
								  
								paircolor="red";
								if (symbolonGoing==symbol)
								  {
								  isitsomethingtodo=1;
								  }
								  
								  if  ( (spread<minspread) && (spread<1.5))
								        {	
								             minspread=spread;
									     bestofchoose=symbol;
									}
									  //alert(keyCurrency1+'/'+keyCurrency2);
							  }
							  
							if ((keyCurrency1V=="green") && (keyCurrency2V=="red"))
							  {
								  
								paircolor="green";
								  if (symbolonGoing==symbol)
								  {
								   isitsomethingtodo=1;
								  }
								  
								    if ((spread<minspread) && ( spread <1.5))
								        {	
								             minspread=spread;
									     bestofchoose=symbol;
									}
									  //alert(keyCurrency1+'/'+keyCurrency2);
							  }
						       }
							var ask=returnData.quotations[i-1].ask;
							var bid=returnData.quotations[i-1].bid;
							var high=returnData.quotations[i-1].high;
							var low=returnData.quotations[i-1].low;
							var diff=(high-low)/((ask+bid)/2);
							var volatility=diff.toFixed(3)*1000;
							volatility=volatility.toFixed(1);
							
								if (parseFloat(spread)<1.5)
						{
							stringPos=stringPos+'<td align=center bgcolor='+paircolor+'><div id=\'eachcurrency2\' onClick=\'changeCurrentandGo(\"'+symbol+'\")\'>'+symbol+'</div></td><td align=center>'+bid+'</td><td align=center>'+ask+'</td><td align=center>'+high+'</td><td align=center>'+low+'</td><td align=center>'+volatility+'</td><td align=center>'+spread+'</td></tr>';
						}
							}
					
							
						}
	stringPos=stringPos+'</tbody></table>';
	document.getElementById("symbolist2").innerHTML=stringPos+"<br> > "+bestofchoose;	
						
	var megastop=localStorage.getItem("megastop");
						
						
        if ( isitsomethingtodo==0)
				{
					stopRobot();
				}
        if ((isitsomethingtodo==0) && (megastop!=1))
				{
					if (bestofchoose!="")
						{
							if ((localStorage.getItem("fixPair")!="") && (localStorage.getItem("fixPair")!=undefined))
							{
								var fixpair=localStorage.getItem("fixPair");
								localStorage.setItem("SymbolCurrent",fixpair);
							}
							else
							{
							localStorage.setItem("symbolCurrent",bestofchoose);
						        }
								}
				}
 }
 function parseAllSymbolSpreadPotentiel(returnData,stringPos)
 {
	var totalTrade=returnData.quotations.length;
	 //window.alert(totalTrade);
	 var isitsomethingtodo=0;
	 var bestofchoose="";
	 var minspread=10;
	 
	 for (var i = returnData.quotations.length - 1; i >= 0; i=i-2) 
						{
							 //window.alert(i);
							var symbol = returnData.quotations[i].symbol;
							
						
							
							
							var ask=returnData.quotations[i].ask;
							var bid=returnData.quotations[i].bid;
							var high=returnData.quotations[i].high;
							var low=returnData.quotations[i].low;
							
							var symbol1=symbol.substr(0,3);
							var symbol2=symbol.substr(3,3);
							
							var keyCurrency1=symbol1+'_color';
							var keyCurrency2=symbol2+'_color';
							
							//alert(keyCurrency1+'/'+keyCurrency2);
							var potentiel=localStorage.getItem("potentiel_"+symbol);
							if ((potentiel=="Infinity") || (potentiel=="-Infinity"))
							{
								potentiel=0;
							}
							potentiel=parseFloat(potentiel);
							
							if (potentiel<0)
							{
								var pattern="<i class=\"fa fa-star fa-1\"></i>";
							}	
								else
							{
								var pattern="<i class=\"fa fa-square fa-1\"></i>";
							}
							var vpotentiel=parseInt(Math.abs(potentiel));
							
							
							var stringp="";
							for (var jj=0;jj<vpotentiel;jj=jj+1)
							{
								stringp=stringp+pattern;
							}
							
							var keyCurrency1V=localStorage.getItem(keyCurrency1);
							var keyCurrency2V=localStorage.getItem(keyCurrency2);
							var spread=returnData.quotations[i].spreadTable;
							spread=parseFloat(spread);
							var paircolor="white";
							if (spread<999)
							{
							if ((keyCurrency1V=="red") && (keyCurrency2V=="green"))
							  {
								  
								paircolor="red";
								if (symbolonGoing==symbol)
								  {
								  isitsomethingtodo=1;
								  }
								
								if (spread<minspread)
								        {	
								             minspread=spread;
									     bestofchoose=symbol;
									}
								  
									  //alert(keyCurrency1+'/'+keyCurrency2);
							  }
							  
							if ((keyCurrency1V=="green") && (keyCurrency2V=="red"))
							  {
								  
								paircolor="green";
								  if (symbolonGoing==symbol)
								  {
								   isitsomethingtodo=1;
								  }
								  
								  if (spread<minspread)
								        {	
								             minspread=spread;
									     bestofchoose=symbol;
									}
									  //alert(keyCurrency1+'/'+keyCurrency2);
							  }
						          }
							var diff=(high-low)/((ask+bid)/2);
							var volatility=diff.toFixed(3)*1000;
							volatility=volatility.toFixed(1);
							
							if (parseFloat(spread)<999)
						{
							stringPos=stringPos+'<tr><td align=center bgcolor='+paircolor+'><div id=\'eachcurrency2\' onClick=\'changeCurrentandGo(\"'+symbol+'\")\'>'+symbol+'</div></td><td>'+stringp+'</td><td align=center>'+bid+'</td><td align=center>'+ask+'</td><td align=center>'+high+'</td><td align=center>'+low+'</td><td align=center>'+volatility+'</td><td align=center>'+spread+'</td>';
							}	
							
							if (i>0)
							{
							var symbol = returnData.quotations[i-1].symbol;
							var symbol1=symbol.substr(0,3);
							var symbol2=symbol.substr(3,3);
							
							var keyCurrency1=symbol1+'_color';
							var keyCurrency2=symbol2+'_color';
							
							//alert(keyCurrency1+'/'+keyCurrency2);
							var potentiel=localStorage.getItem("potentiel_"+symbol);
							if ((potentiel=="Infinity") || (potentiel=="-Infinity"))
							{
								potentiel=0;
							}	
							if (potentiel<0)
							{
								pattern="<i class=\"fa fa-star fa-1\"></i>";
							}	
								else
							{
								pattern="<i class=\"fa fa-square fa-1\"></i>";
							}
							var vpotentiel=parseInt(Math.abs(potentiel));
							
							 stringp="";
							for (var jj=0;jj<vpotentiel;jj=jj+1)
							{
								stringp=stringp+pattern;
							}
							var keyCurrency1V=localStorage.getItem(keyCurrency1);
							var keyCurrency2V=localStorage.getItem(keyCurrency2);
							var spread=returnData.quotations[i-1].spreadTable;
							var paircolor="white";
							if (spread<1.5)
							{
							if ((keyCurrency1V=="red") && (keyCurrency2V=="green"))
							  {
								  
								paircolor="red";
								if (symbolonGoing==symbol)
								  {
								  isitsomethingtodo=1;
								  }
								  
								  if  ( (spread<minspread) && (spread<1.5))
								        {	
								             minspread=spread;
									     bestofchoose=symbol;
									}
									  //alert(keyCurrency1+'/'+keyCurrency2);
							  }
							  
							if ((keyCurrency1V=="green") && (keyCurrency2V=="red"))
							  {
								  
								paircolor="green";
								  if (symbolonGoing==symbol)
								  {
								   isitsomethingtodo=1;
								  }
								  
								    if ((spread<minspread) && ( spread <1.5))
								        {	
								             minspread=spread;
									     bestofchoose=symbol;
									}
									  //alert(keyCurrency1+'/'+keyCurrency2);
							  }
						       }
							var ask=returnData.quotations[i-1].ask;
							var bid=returnData.quotations[i-1].bid;
							var high=returnData.quotations[i-1].high;
							var low=returnData.quotations[i-1].low;
							var diff=(high-low)/((ask+bid)/2);
							var volatility=diff.toFixed(3)*1000;
							volatility=volatility.toFixed(1);
							
								if (parseFloat(spread)<999)
						{
							stringPos=stringPos+'<td align=center bgcolor='+paircolor+'><div id=\'eachcurrency2\' onClick=\'changeCurrentandGo(\"'+symbol+'\")\'>'+symbol+'</div></td><td>'+stringp+'</td><td align=center>'+bid+'</td><td align=center>'+ask+'</td><td align=center>'+high+'</td><td align=center>'+low+'</td><td align=center>'+volatility+'</td><td align=center>'+spread+'</td></tr>';
						}
							}
					
							
						}
	stringPos=stringPos+'</tbody></table>';
						
	document.getElementById("symbolist2").innerHTML=stringPos;	
						
						
	var div55 = document.getElementById('disapear');
	div55.style.visibility = 'hidden';		
	/*					
	var megastop=localStorage.getItem("megastop");
						
						
        if ( isitsomethingtodo==0)
				{
					//stopRobot();
				}
        if ((isitsomethingtodo==0) && (megastop!=1))
				{
					if (bestofchoose!="")
						{
							if ((localStorage.getItem("fixPair")!="") && (localStorage.getItem("fixPair")!=undefined))
							{
								var fixpair=localStorage.getItem("fixPair");
							//localStorage.setItem("SymbolCurrent",fixpair);
							}
							else
							{
							//localStorage.setItem("symbolCurrent",bestofchoose);
						        }
								}
				}	
	*/
 }
 
   function storeTickVariable(returnData)
 {
	  var totalTrade=returnData.quotations.length;
	  for (var i = returnData.quotations.length - 1; i >= 0; i=i-1) 
						{
							 //window.alert(i);
							var symbol = returnData.quotations[i].symbol;
							
							var ask=returnData.quotations[i].ask;
							var bid=returnData.quotations[i].bid;
							var timestamp=returnData.quotations[i].timestamp;
							
							//window.alert(ask);
							
							localStorage.setItem("Ask_"+symbol,ask);
							localStorage.setItem("Bid_"+symbol,bid);
							localStorage.setItem("timestamp_"+symbol,timestamp);
							
						}
 }
   function parseAllSymbolPotentiel(returnData)
 {
	 var pastask=0;
	 var pastbid=0;
	 var pastmoy=0;
	 var advice="";
	 var totalTrade=returnData.quotations.length;
	 //window.alert(totalTrade);
	 var stringPos="<table id='keywords' width=500 cellpadding=0 cellspacing=0 border=0>";
	 stringPos=stringPos+'<thead><tr><th>Symbol</th><th>Strength</th><th>Global Volatility</th></tr></thead><tbody>';
        
	 for (var i = returnData.quotations.length - 1; i >= 0; i=i-1) 
						{
							 //window.alert(i);
							var symbol = returnData.quotations[i].symbol;
							
							var symbol1=symbol.substr(0,3);
							var symbol2=symbol.substr(3,3);
							
							var ask=returnData.quotations[i].ask;
							var bid=returnData.quotations[i].bid;
							var moy=(ask+bid)/2;
							
							pastmoy=localStorage.getItem("past_"+symbol);
							
							pastmoy=parseFloat(pastmoy);
							
							if (moy>pastmoy)
							{
								var score=localStorage.getItem(symbol1);
								
								if (score=="NaN") { score=0;}
								
								newscore=parseInt(score)+1;
								localStorage.setItem(symbol1,newscore);
								
								score=localStorage.getItem(symbol2);
								if (score=="NaN") { score=0;}
								newscore=parseInt(score)-1;
								localStorage.setItem(symbol2,newscore);
								
							}
							if (moy<pastmoy)
							{
								var score=localStorage.getItem(symbol1);
								
								if (score=="NaN") { score=0;}
								
								newscore=parseInt(score)-1;
								localStorage.setItem(symbol1,newscore);
								
								score=localStorage.getItem(symbol2);
								if (score=="NaN") { score=0;}
								newscore=parseInt(score)+1;
								localStorage.setItem(symbol2,newscore);
								
							}
							// Keep past data
						
							
							pastmoy=(ask+bid)/2;
							localStorage.setItem("past_"+symbol,pastmoy);
							
							
							//
							
							var high=returnData.quotations[i].high;
							var low=returnData.quotations[i].low;
							
							var diff=(high-low)/((ask+bid)/2);
							var volatility=diff.toFixed(3)*1000;
							volatility=volatility.toFixed(1);
							var spread=returnData.quotations[i].spreadTable;
							//stringPos=stringPos+'<tr><td align=center><div id=\'eachcurrency\' onClick=\'changeCurrentandGo(\"'+symbol+'\")\'>'+symbol1+'/'+symbol2+'</div></td></tr>';
							
							// Management of volatility
							var scorevol1=localStorage.getItem("vol_"+symbol1);
							var scorevol2=localStorage.getItem("vol_"+symbol2);
							
							var c=localStorage.getItem("countvol");
							var newc=parseInt(c)+1;
							
							localStorage.setItem("countvol",newc);
							
							
							scorevol1=parseFloat(scorevol1)+parseFloat(volatility);
							scorevol2=parseFloat(scorevol2)+parseFloat(volatility);
							
							
							localStorage.setItem("vol_"+symbol1,scorevol1);
							localStorage.setItem("vol_"+symbol2,scorevol2);
							var averagescore1=parseFloat(scorevol1/newc);
							var averagescore2=parseFloat(scorevol2/newc);
							localStorage.setItem("txvol_"+symbol1,averagescore1);
							localStorage.setItem("txvol_"+symbol2,averagescore2);
							
							//
							
							localStorage.setItem("pastvolatility"+symbol,volatility);
							
							if (newc>10000)
								{
									var keepweak=localStorage.getItem("keepweak");
									var keepstrong=localStorage.getItem("keepstrong");
									localStorage.setItem("historyweak",keepweak);
									localStorage.setItem("historystrong",keepstrong);
									resetScore();
								}
							
						}
						
	var currencies = ["EUR", "TRY", "USD","CLP","GBP","MXN","JPY","AUD","CHF","SEK","NZD","NOK","CAD","CZK","PLN","HUF"];
	var weak="";
	var strong="";
	for	(index = 0; index < currencies.length; index++) 
						{
		var whatcurrenc= currencies[index];
		var globalvol=localStorage.getItem("txvol_"+whatcurrenc);
		globalvol=globalvol*100;
		globalvol=parseInt(globalvol);					
		var scoreAff=localStorage.getItem(whatcurrenc);
		if (scoreAff>0)
		      {
		      scoreAff=Math.log(scoreAff);
			      
		      }
		      else
		      {
			      if (scoreAff!=0)
			      {
			scoreAff=Math.abs(scoreAff);
			scoreAff=-1*Math.log(scoreAff);
			      }
			      else
			      {
				      
			scoreAff=0;
			      }
			      
		      }
		        scoreAff=scoreAff.toFixed(2);
		        if (scoreAff=="Infinity") {scoreAff=0;}
		        var addindic="";
		   
							
							//stringPos=stringPos+'<tr><td align=center><div id=\'eachcurrency\' onClick=\'changeCurrentandGo(\"'+symbol+'\")\'>'+whatcurrenc</div></td><td align=center>'+scoreAff+'</td></tr>';
							if (scoreAff!="Infinity")
							{
								//var keyCurrency=whatcurrenc+'_color';
								
								 if (scoreAff<-2)
									{
									weak=weak+whatcurrenc+' ';
								
									}
								if (scoreAff>2)
									{
										
									strong=strong+whatcurrenc+' ';	
								
									}
									
							var pastscoring=localStorage.getItem("pastscore"+whatcurrenc);
							pastscoring=parseFloat(pastscoring);
							if (parseFloat(scoreAff)>pastscoring)
										{
											var addindic="+";
										}
							if (parseFloat(scoreAff)==pastscoring)
										{
											addindic="=";
										}	
							if (parseFloat(scoreAff)<pastscoring)
										{
											
											addindic="-";
										}
										color='white';
							if (parseFloat(scoreAff)<-1.0)
										{
											color='#B09F91';
										}
							if (parseFloat(scoreAff)>1.0)
										{
											
											color='#8FCF3C';
										}
							if (parseFloat(scoreAff)<-2)
										{
											
											color='red';
											
											
										}
							if (parseFloat(scoreAff)>2)
										{
											
											color='green';
										}
							
							localStorage.setItem(whatcurrenc+'_color',color);
										
							localStorage.setItem("pastscore"+whatcurrenc,scoreAff);
									
							stringPos=stringPos+'<tr><td align=center bgcolor='+color+'>'+whatcurrenc+'</td><td align=center>'+scoreAff+'('+addindic+')</td><td align=center>'+globalvol+'</td></tr>';
							}
								}					
						
	stringPos=stringPos+'</tbody></table>';
								
	if (weak!="")
		{
			localStorage.setItem("keepweak",weak);
		}
	if (strong!="")
		{
			localStorage.setItem("keepstrong",strong);
									
		}
		
	
		
	advicetogive="";
	var tradingpair= ["AUDNZD","AUDJPY","EURNZD","GBPCAD","CHFJPY","EURAUD","GBPAUD","NZDJPY","NZDCAD","USDSEK","EURNOK","GBPNZD","AUDCAD","EURCAD","CADJPY","CADCHF","USDNOK","AUDCHF","EURSEK","GBPUSD","AUDUSD","EURCHF","USDJPY","EURJPY","NZDUSD","USDCHF","GBPCHF","GBPJPY","USDCAD","EURGBP","EURUSD","EURCZK","USDMXN","USDTRY","USDPLN","USDCZK","GBPPLN","EURRON","USDZAR","CHFHUF","EURHUF","USDRON","USDHUF","EURPLN","USDCLP","CHFPLN","EURTRY"];
				
	for	(index = 0; index < tradingpair.length; index++) 
		{
			var symbol = tradingpair[index];
					
							var symbol1=symbol.substr(0,3);
							var symbol2=symbol.substr(3,3);
			
			var scoreAff1=localStorage.getItem(symbol1);
			
			if (scoreAff1>0)
				{
					scoreAff1=Math.log(scoreAff1);
			      
				}
				else
				{
					if (scoreAff1!=0)
					{
					scoreAff1=Math.abs(scoreAff1);
					scoreAff1=-1*Math.log(scoreAff1);
					}
					else
					{
						scoreAff1=0;
					}
			      
				}
				scoreAff1=parseFloat(scoreAff1);
				scoreAff1=scoreAff1.toFixed(2);
			
			var scoreAff2=localStorage.getItem(symbol2);
			
			
				if (scoreAff2>0)
				{
					scoreAff2=Math.log(scoreAff2);
			      
				}
				else
				{
					scoreAff2=Math.abs(scoreAff2);
					scoreAff2=-1*Math.log(scoreAff2);
			      
			      
				}
				scoreAff2=parseFloat(scoreAff2);
				scoreAff2=scoreAff2.toFixed(2);
				
				var potentiel=0;
				
				if  ((scoreAff1=="Infinity") || (scoreAff2=="NaN"))
				{
					
					var not=1;
				}
				else
				{
				not=0;	
					
				}
				
				if ((scoreAff1>0) && (scoreAff2>0))
				
				{
				
						 potentiel=Math.abs(scoreAff1-scoreAff2);
					
				}
				if ((scoreAff1<0) && (scoreAff2<0))
				
				{
				
						 potentiel=Math.abs(scoreAff1-scoreAff2);
					
				}
			
				if ((scoreAff1<0) && (scoreAff2>0))
				{
						potentiel=Math.abs(scoreAff2)+Math.abs(scoreAff1);
					
						potentiel=-1*potentiel;
				}
				
				if ((scoreAff1>0) && (scoreAff2<0))
				{
						potentiel=Math.abs(scoreAff2)+Math.abs(scoreAff1);
				}
				
				var keyS="potentiel_"+symbol;
				potentiel=parseFloat(potentiel);
				
				if (not==0)
				{
					localStorage.setItem(keyS,potentiel);
				
				}
		}
		
 //document.getElementById("symbolist").innerHTML=stringPos+"<br>Strong : "+strong+"<br>Weak : "+weak+"<br>Last Strong:"+localStorage.getItem("historystrong")+"<br>Last Weak:"+localStorage.getItem("historyweak")+"<br>"+advicetogive;
	
		}
  function parseAllSymbolStrengh(returnData)
 {
	 var pastask=0;
	 var pastbid=0;
	 var pastmoy=0;
	 var advice="";
	 var totalTrade=returnData.quotations.length;
	 //window.alert(totalTrade);
	 var stringPos="<table id='keywords' width=500 cellpadding=0 cellspacing=0 border=0>";
	 stringPos=stringPos+'<thead><tr><th>Symbol</th><th>Strength</th><th>Global Volatility</th></tr></thead><tbody>';
        
	 for (var i = returnData.quotations.length - 1; i >= 0; i=i-1) 
						{
							 //window.alert(i);
							var symbol = returnData.quotations[i].symbol;
							
							var symbol1=symbol.substr(0,3);
							var symbol2=symbol.substr(3,3);
							
							var ask=returnData.quotations[i].ask;
							var bid=returnData.quotations[i].bid;
							var moy=(ask+bid)/2;
							
							pastmoy=localStorage.getItem("past_"+symbol);
							
							pastmoy=parseFloat(pastmoy);
							
							if (moy>pastmoy)
							{
								var score=localStorage.getItem(symbol1);
								
								if (score=="NaN") { score=0;}
								
								newscore=parseInt(score)+1;
								localStorage.setItem(symbol1,newscore);
								
								score=localStorage.getItem(symbol2);
								if (score=="NaN") { score=0;}
								newscore=parseInt(score)-1;
								localStorage.setItem(symbol2,newscore);
								
							}
							if (moy<pastmoy)
							{
								var score=localStorage.getItem(symbol1);
								
								if (score=="NaN") { score=0;}
								
								newscore=parseInt(score)-1;
								localStorage.setItem(symbol1,newscore);
								
								score=localStorage.getItem(symbol2);
								if (score=="NaN") { score=0;}
								newscore=parseInt(score)+1;
								localStorage.setItem(symbol2,newscore);
								
							}
							// Keep past data
						
							
							pastmoy=(ask+bid)/2;
							localStorage.setItem("past_"+symbol,pastmoy);
							
							
							//
							
							var high=returnData.quotations[i].high;
							var low=returnData.quotations[i].low;
							
							var diff=(high-low)/((ask+bid)/2);
							var volatility=diff.toFixed(3)*1000;
							volatility=volatility.toFixed(1);
							var spread=returnData.quotations[i].spreadTable;
							//stringPos=stringPos+'<tr><td align=center><div id=\'eachcurrency\' onClick=\'changeCurrentandGo(\"'+symbol+'\")\'>'+symbol1+'/'+symbol2+'</div></td></tr>';
							
							// Management of volatility
							var scorevol1=localStorage.getItem("vol_"+symbol1);
							var scorevol2=localStorage.getItem("vol_"+symbol2);
							
							var c=localStorage.getItem("countvol");
							var newc=parseInt(c)+1;
							
							localStorage.setItem("countvol",newc);
							
							
							scorevol1=parseFloat(scorevol1)+parseFloat(volatility);
							scorevol2=parseFloat(scorevol2)+parseFloat(volatility);
							
							
							localStorage.setItem("vol_"+symbol1,scorevol1);
							localStorage.setItem("vol_"+symbol2,scorevol2);
							var averagescore1=parseFloat(scorevol1/newc);
							var averagescore2=parseFloat(scorevol2/newc);
							localStorage.setItem("txvol_"+symbol1,averagescore1);
							localStorage.setItem("txvol_"+symbol2,averagescore2);
							
							//
							
							localStorage.setItem("pastvolatility"+symbol,volatility);
							
							if (newc>10000)
								{
									var keepweak=localStorage.getItem("keepweak");
									var keepstrong=localStorage.getItem("keepstrong");
									localStorage.setItem("historyweak",keepweak);
									localStorage.setItem("historystrong",keepstrong);
									resetScore();
								}
							
						}
						
	var currencies = ["EUR", "TRY", "USD","CLP","GBP","MXN","JPY","AUD","CHF","SEK","NZD","NOK","CAD","CZK","PLN","HUF"];
	var weak="";
	var strong="";
	for	(index = 0; index < currencies.length; index++) 
						{
		var whatcurrenc= currencies[index];
		var globalvol=localStorage.getItem("txvol_"+whatcurrenc);
		globalvol=globalvol*100;
		globalvol=parseInt(globalvol);					
		var scoreAff=localStorage.getItem(whatcurrenc);
		if (scoreAff>0)
		      {
		      scoreAff=Math.log(scoreAff);
			      
		      }
		      else
		      {
			scoreAff=Math.abs(scoreAff);
			scoreAff=-1*Math.log(scoreAff);
			      
			      
		      }
		        scoreAff=scoreAff.toFixed(2);
		        if (scoreAff=="Infinity") {scoreAff=0;}
		        var addindic="";
		   
							
							//stringPos=stringPos+'<tr><td align=center><div id=\'eachcurrency\' onClick=\'changeCurrentandGo(\"'+symbol+'\")\'>'+whatcurrenc</div></td><td align=center>'+scoreAff+'</td></tr>';
							if (scoreAff!="Infinity")
							{
								//var keyCurrency=whatcurrenc+'_color';
								
								 if (scoreAff<-2)
									{
									weak=weak+whatcurrenc+' ';
								
									}
								if (scoreAff>2)
									{
										
									strong=strong+whatcurrenc+' ';	
								
									}
									
							var pastscoring=localStorage.getItem("pastscore"+whatcurrenc);
							pastscoring=parseFloat(pastscoring);
							if (parseFloat(scoreAff)>pastscoring)
										{
											var addindic="+";
										}
							if (parseFloat(scoreAff)==pastscoring)
										{
											addindic="=";
										}	
							if (parseFloat(scoreAff)<pastscoring)
										{
											
											addindic="-";
										}
										color='white';
							if (parseFloat(scoreAff)<-1.0)
										{
											color='#B09F91';
										}
							if (parseFloat(scoreAff)>1.0)
										{
											
											color='#8FCF3C';
										}
							if (parseFloat(scoreAff)<-2)
										{
											
											color='red';
											
											
										}
							if (parseFloat(scoreAff)>2)
										{
											
											color='green';
										}
							
							localStorage.setItem(whatcurrenc+'_color',color);
										
							localStorage.setItem("pastscore"+whatcurrenc,scoreAff);
									
							stringPos=stringPos+'<tr><td align=center bgcolor='+color+'>'+whatcurrenc+'</td><td align=center>'+scoreAff+'('+addindic+')</td><td align=center>'+globalvol+'</td></tr>';
							}
								}					
						
	stringPos=stringPos+'</tbody></table>';
								
	if (weak!="")
		{
			localStorage.setItem("keepweak",weak);
		}
	if (strong!="")
		{
			localStorage.setItem("keepstrong",strong);
									
		}
		
	var tradingpair = localStorage.getItem("symbolCurrent"); // Selection of the trading's pair
	
	var fixpair=localStorage.getItem("fixPair");
	if ((fixpair!="") && (fixpair!=undefined))
		{
			
			tradingpair=fixpair;
			
		}
	var limitationoftrade=localStorage.getItem("limitTrade");
	var numbertrade=localStorage.getItem("totalTrade");
		
	limitationoftrade=parseInt(limitationoftrade);
	numbertrade=parseInt(numbertrade);
		
	localStorage.setItem("stoptradingduenbre",0);

	if (limitationoftrade>0)
			{
				if (numbertrade>limitationoftrade)
					{
						
						localStorage.setItem("stoptradingduenbre",1);
					}
					else
					{
						
						localStorage.setItem("stoptradingduenbre",0);
					}
				
			}
		
	advicetogive="";
	
	//for	(index = 0; index < tradingpair.length; index++) 
	//	{
			//var symbol = tradingpair[index];
			var symbol=tradingpair;				
							var symbol1=symbol.substr(0,3);
							var symbol2=symbol.substr(3,3);
			
			var scoreAff1=localStorage.getItem(symbol1);
			
			if (scoreAff1>0)
				{
					scoreAff1=Math.log(scoreAff1);
			      
				}
				else
				{
					scoreAff1=Math.abs(scoreAff1);
					scoreAff1=-1*Math.log(scoreAff1);
			      
			      
				}
				scoreAff1=scoreAff1.toFixed(2);
			
			var scoreAff2=localStorage.getItem(symbol2);
			
				if (scoreAff2>0)
				{
					scoreAff2=Math.log(scoreAff2);
			      
				}
				else
				{
					scoreAff2=Math.abs(scoreAff2);
					scoreAff2=-1*Math.log(scoreAff2);
			      
			      
				}
				scoreAff2=scoreAff2.toFixed(2);
				var onoffnbre=localStorage.getItem("stoptradingduenbre");
				
				if (onoffnbre==0)
				{
				
				if ((scoreAff1>2) && (scoreAff2<-2))
				{
					advicetogive=advicetogive+"BUY "+symbol+" ";
					
					
						localStorage.setItem("symbolCurrent",symbol);
						localStorage.setItem("OpenCaseStrength","BUY");
						
				}
				if ((scoreAff1<-2) && (scoreAff2>2))
				{
					
					advicetogive=advicetogive+"SELL "+symbol+" ";
					
					
						localStorage.setItem("symbolCurrent",symbol);
						localStorage.setItem("OpenCaseStrength","SELL");
					
				
				}
				}
		//}
		
 document.getElementById("symbolist").innerHTML=stringPos+"<br>Strong : "+strong+"<br>Weak : "+weak+"<br>Last Strong:"+localStorage.getItem("historystrong")+"<br>Last Weak:"+localStorage.getItem("historyweak")+"<br>"+advicetogive;
	
		}
 function parseGetAllTradeProfit(returnData,ordersearch) {
				
				
	 
				if (returnData.length==0)
				{
					//document.getElementById("position").innerHTML="There is no running trade in your account now.</br>Please launch the StormTrader by Clicking on SELL or BUY to begin with this command.</br> You can click on STOP+CLOSE to close all signals and stop the StormTrader when you want.</br> All positions will be then closed and you will come back to now";
					localStorage.removeItem("type");
					localStorage.removeItem("position");
					localStorage.removeItem("profit");
					localStorage.getItem("closeallitemstop","0");
					//document.getElementById("warning").innerHTML="";
				}
				else
				{
					//document.getElementById("position").innerHTML="";
					var totalTrade=returnData.length;
				        var stringPos="";
					if (totalTrade==0)
					{
						localStorage.setItem("closeallitemstop","0");
						localStorage.setItem("scalpcloseall",0);
					}
					else
					{
					if (localStorage.getItem("closeallitemstop")==1)
						{
							
							//document.getElementById("warning").innerHTML="<div class=\"large red button\"> ! WE ARE STOPPING STORMTRADER ! </div>";
							
						}
					}	
					if (totalTrade>0)
					{
					var stringPos="<table id='pos' width=952 cellpadding=0 cellspacing=0 border=0>";
					stringPos=stringPos+'<thead><tr><th></th><th>POS</th><th>Open Time</th><th>Symbol</th><th>Command</th><th>Volume</th><th>Open Price</th><th>Price</th><th>SL</th><th>TP</th><th>Order</th><th>Com.</th><th>Swap</th><th>Profit</th></tr></thead>';
					
					localStorage.setItem("totalTrade",totalTrade);
					
						for (var i = returnData.length - 1; i >= 0; i--) 
						{
					var order = returnData[i].order;
					var order2 = returnData[i].order2;
					var position = returnData[i].position;
					var symbol = returnData[i].symbol;
					var profit = returnData[i].profit;
						if (localStorage.getItem("scalpcloseall")!=1)
							{
							if (profit>0.04)
							 {
								 closethis(order2);
							 }
							 //if (profit<-0.04)
							 //{
							//	closethis(order2);
							 //}
						 }
						 else
						 {
							 if (profit>0)
							 {
							 closethis(order2);
							 }
							 
						 }
						 if (localStorage.getItem("closeallitemstop")==1)
						 {
							 closethis(order2); 
						 }
					var volume = returnData[i].volume;
					var close_price = returnData[i].close_price;
					var BaseCurrency=localStorage.getItem("BaseCurrency");
					var type=returnData[i].cmd;
					var openPrice=returnData[i].open_price;
					var com=returnData[i].commission;
					var tp=returnData[i].tp;
					var sl=returnData[i].sl;
					var swap=returnData[i].storage;
					var openTime=returnData[i].open_time;
							
					if (ordersearch==order2)
							{
					localStorage.setItem("order",order);
					localStorage.setItem("profit",profit);
					localStorage.setItem("position",position);
					localStorage.setItem("type",type);
					localStorage.setItem("close_price",close_price);
					localStorage.setItem("order2",order2);
					localStorage.setItem("symbolOpenedPosition",symbol);
					localStorage.setItem("volume", volume);
					localStorage.setItem("lot", volume);			
								closePosition();
								
							}
					var ii=i+1;		
					var openTimeDate = new Date(openTime);
					
					if (type==0) {var Stype="BUY";} else {Stype="SELL";}
					
					stringPos=stringPos+'<tr><td><a href=\"#\" onClick=\"closethis('+order2+');\"><i class="fa fa-times fa-1x"></i></a></td><td>'+ii+'</td></td><td>'+openTimeDate+'</td><td>'+symbol+'</td><td>'+Stype+'</td><td>'+volume+'</td><td>'+openPrice+'</td><td>'+close_price+'</td><td>'+sl+'</td><td>'+tp+'</td><td>'+order2+'</td><td>'+com.toFixed(2)+'</td><td>'+swap.toFixed(2)+'</td><td>'+profit.toFixed(2)+'</td></tr>';
									
						};
				
					stringPos=stringPos+'</table>';
					if (stringPos!="")
						{
					document.getElementById("position").innerHTML=stringPos;
						}	
					}
			}
			
				
			}
 function parseGetAllTrade(returnData,ordersearch) {
				
				
				if (returnData.length==0)
				{
					document.getElementById("position").innerHTML="There is no running trade in your account now";
					localStorage.removeItem("type");
					localStorage.removeItem("position");
					localStorage.removeItem("profit");
				}
				else
				{
					//document.getElementById("position").innerHTML="";
					var totalTrade=returnData.length;
				        var stringPos="";
					if (totalTrade>0)
					{
					var stringPos="<table id='pos' width=952 cellpadding=0 cellspacing=0 border=0>";
					stringPos=stringPos+'<thead><tr><th></th><th>POS</th><th>Open Time</th><th>Symbol</th><th>Command</th><th>Volume</th><th>Open Price</th><th>Price</th><th>SL</th><th>TP</th><th>Order</th><th>Com.</th><th>Swap</th><th>Profit</th></tr></thead>';
					
					localStorage.setItem("totalTrade",totalTrade);
					
						for (var i = returnData.length - 1; i >= 0; i--) 
						{
					var order = returnData[i].order;
					var order2 = returnData[i].order2;
					var position = returnData[i].position;
					var symbol = returnData[i].symbol;
					var profit = returnData[i].profit;
					var volume = returnData[i].volume;
					var close_price = returnData[i].close_price;
					var BaseCurrency=localStorage.getItem("BaseCurrency");
					var type=returnData[i].cmd;
					var openPrice=returnData[i].open_price;
					var com=returnData[i].commission;
					var tp=returnData[i].tp;
					var sl=returnData[i].sl;
					var swap=returnData[i].storage;
					var openTime=returnData[i].open_time;
							
					if (ordersearch==order2)
							{
					localStorage.setItem("order",order);
					localStorage.setItem("profit",profit);
					localStorage.setItem("position",position);
					localStorage.setItem("type",type);
					localStorage.setItem("close_price",close_price);
					localStorage.setItem("order2",order2);
					localStorage.setItem("symbolOpenedPosition",symbol);
					localStorage.setItem("volume", volume);
					localStorage.setItem("lot", volume);			
								closePosition();
							}
					var ii=i+1;		
					var openTimeDate = new Date(openTime);
					
					if (type==0) {var Stype="BUY";} else {Stype="SELL";}
					
					stringPos=stringPos+'<tr><td><a href=\"#\" onClick=\"closethis('+order2+');\"><i class="fa fa-times fa-1x"></i></a></td><td>'+ii+'</td></td><td>'+openTimeDate+'</td><td>'+symbol+'</td><td>'+Stype+'</td><td>'+volume+'</td><td>'+openPrice+'</td><td>'+close_price+'</td><td>'+sl+'</td><td>'+tp+'</td><td>'+order2+'</td><td>'+com.toFixed(2)+'</td><td>'+swap.toFixed(2)+'</td><td>'+profit.toFixed(2)+'</td></tr>';
									
						};
				
					stringPos=stringPos+'</table>';
					if (stringPos!="")
						{
					document.getElementById("position").innerHTML=stringPos;
						}	
					}
			}
			
				
			}
function sleep(miliseconds) {
           var currentTime = new Date().getTime();

           while (currentTime + miliseconds >= new Date().getTime()) {
           }
       }


function changeLot(sum)
{
   var lot=localStorage.getItem("lot");
   lot=parseFloat(lot);
   lot=lot+sum;
   if (lot<1) {lot=1; alert(' minimum of 10K');}

   //alert("New lot : "+lot*10+ "K");
   localStorage.setItem("lot",lot);
   document.getElementById("Lot").innerHTML=lot;

}



function tradeClose()
 {
      //alert("CLOSE");
        localStorage.clear();
      document.getElementById("Position").innerHTML="";
      document.getElementById("Balance").innerHTML=document.getElementById("Equity").innerHTML;
      var getlot=document.getElementById("Lot").innerHTML;

      localStorage.setItem("lot",getlot);
}
function listTrade( )
 {
				var msg = {};
				msg.command = "getTrades";
				var arguments = {};
				arguments.openedOnly = true;
				msg.arguments = arguments;
				send(msg);				
     
 }
function transactionStatus(order)
{
				var msg = {};
				msg.command = "tradeTransactionStatus";
				var arguments = {};
				arguments.order = order;
				msg.arguments = arguments;
				send(msg);	
}
      
    
 

   function openSell()
{
 localStorage.setItem("waitforanswer",1);
   //closePosition();
   var x = document.getElementById("ctable").getElementsByTagName("td");
    x[6].style.backgroundColor = "#e5e5e4";
    
   var bid=localStorage.getItem("bid");
   var symbolCurrent=localStorage.getItem("symbolCurrent");
	bid=parseFloat(bid);
         var lot=localStorage.getItem("lot");
      lot=parseFloat(lot)/10;	
	var msg = {};
	 msg.command = "tradeTransaction";
	var arguments = {};
	     arguments.tradeTransInfo = {};
				  arguments.tradeTransInfo.cmd=1;
				  arguments.tradeTransInfo.customComment="";
				  arguments.tradeTransInfo.expiration=0;
				  arguments.tradeTransInfo.price= bid;
				  arguments.tradeTransInfo.ie_deviation=0;
				  arguments.tradeTransInfo.sl=parseFloat(0);
				  arguments.tradeTransInfo.tp=parseFloat(0);
				  arguments.tradeTransInfo.symbol=symbolCurrent;
				  arguments.tradeTransInfo.type=0;
				  arguments.tradeTransInfo.volume=parseFloat(lot);
				  arguments.tradeTransInfo.order=parseInt(0);
					msg.arguments = arguments;
				send(msg);
				document.getElementById("status").innerHTML="Opening a sell position ...";
       var tradetot=localStorage.getItem("totalTrade");
       tradetot=parseInt(tradetot);
       tradetot=tradetot+1;
       localStorage.setItem("totalTrade",tradetot);
}

function openBuy()
{
localStorage.setItem("waitforanswer",1);
//closePosition();
	 var x = document.getElementById("ctable").getElementsByTagName("td");
    x[8].style.backgroundColor = "#e5e5e4";
	 var symbolCurrent=localStorage.getItem("symbolCurrent");
	var ask=localStorage.getItem("ask");
	ask=parseFloat(ask);
         var lot=localStorage.getItem("lot");
      lot=parseFloat(lot)/10;	
	var msg = {};
	 msg.command = "tradeTransaction";
	var arguments = {};
	     arguments.tradeTransInfo = {};
				  arguments.tradeTransInfo.cmd=0;
				  arguments.tradeTransInfo.customComment="";
				  arguments.tradeTransInfo.expiration=0;
				  arguments.tradeTransInfo.price= ask;
				  arguments.tradeTransInfo.ie_deviation=0;
				  arguments.tradeTransInfo.sl=parseFloat(0);
				  arguments.tradeTransInfo.tp=parseFloat(0);
				  arguments.tradeTransInfo.symbol=symbolCurrent;
				  arguments.tradeTransInfo.type=0;
				  arguments.tradeTransInfo.volume=parseFloat(lot);
				  arguments.tradeTransInfo.order=parseInt(0);
					msg.arguments = arguments;
				send(msg);document.getElementById("status").innerHTML="Opening a buy  position ...";

var tradetot=localStorage.getItem("totalTrade");
       tradetot=parseInt(tradetot);
       tradetot=tradetot+1;
       localStorage.setItem("totalTrade",tradetot);
}


// Our websocket
  			
function getBalance()
{
			var msg = {};
				msg.command = "getMarginLevel";
				send(msg);

				}
						

			function getSymbol(symbol)
			{

				var msg = {};
				msg.command = "getSymbol";
				var arguments = {};
				arguments.symbol = symbol;
				msg.arguments = arguments;
				send(msg);

			}
			
			function getTickPrice()
			{
				var time=Math.round(new Date().getTime() / 1000);;
				var msg = {};
				msg.command = "getTickPrices";
				var arguments = {};
				arguments.level=0;
				arguments.symbols = ["AUDNZD","AUDJPY","EURNZD","GBPCAD","CHFJPY","EURAUD","GBPAUD","NZDJPY","NZDCAD","USDSEK","EURNOK","GBPNZD","AUDCAD","EURCAD","CADJPY","CADCHF","USDNOK","AUDCHF","EURSEK","GBPUSD","AUDUSD","EURCHF","USDJPY","EURJPY","NZDUSD","USDCHF","GBPCHF","GBPJPY","USDCAD","EURGBP","EURUSD","EURCZK","USDMXN","USDTRY","USDPLN","USDCZK","GBPPLN","EURRON","USDZAR","CHFHUF","EURHUF","USDRON","USDHUF","EURPLN","USDCLP","CHFPLN","EURTRY"];
				arguments.timestamp=time;
				msg.arguments = arguments;
				send(msg);
				
			}
			function getTickPriceAll()
			{
				var time=Math.round(new Date().getTime() / 1000);;
				var msg = {};
				msg.command = "getTickPrices";
				var arguments = {};
				arguments.level=0;
				arguments.symbols = ["AUDNZD","AUDJPY","EURNZD","GBPCAD","CHFJPY","EURAUD","GBPAUD","NZDJPY","NZDCAD","USDSEK","EURNOK","GBPNZD","AUDCAD","EURCAD","CADJPY","CADCHF","USDNOK","AUDCHF","EURSEK","GBPUSD","AUDUSD","EURCHF","USDJPY","EURJPY","NZDUSD","USDCHF","GBPCHF","GBPJPY","USDCAD","EURGBP","EURUSD","EURCZK","USDMXN","USDTRY","USDPLN","USDCZK","GBPPLN","EURRON","USDZAR","CHFHUF","EURHUF","USDRON","USDHUF","EURPLN","USDCLP","CHFPLN","EURTRY",
					"PLATINIUM","SILVER","GOLD","NICKEL","COPPER","ALUMINIUM","ZINC","OIL.WTI","NATGAS","OIL","WHEAT","COCOA","COTTON","SOYBEAN","SUGAR","CORN","TNOTE","BUND10Y","EMISS","SCHATZ2Y",
					"US2000","US100","US500","MEXComp","BRAComp","VOLX","US30","SPA35","SUI20","HUNComp","W20","FRA40","RUS50","ITA40","CZKCASH","UK100","DE30","EU50",
					"JAP225","INDIA50","KOSP200","AUS200","CHNComp","HKComp",
					"LLOY.UK","BTA.UK","SL.UK","PSON.UK","BAB.UK","BP.UK","DGE.UK","IMT.UK","RBS.UK","AAL.UK","AZN.UK","IMI.UK","MGTT.UK","BARC.UK","TATE.UK","REL.UK","RSA.UK","MKS.UK","VOD.UK","SAB.UK","VOD.UK","SAB.UK","RRS.UK","TPK.UK","RDSA.UK","SBRY.UK","NG.UK","EXPN.UK","GLEN.UK","BLND.UK","CPI.UK","IAG.UK","TLW.UK","JMAT.UK","WOS.UK","STAN.UK","ADM.UK","WPP.UK","BSY.UK","HL.UK","CNA.UK","KAZ.UK","MRW.UK","HMSO.UK","WEIR.UK","AGK.UK","SDR.UK","BLT.UK","ITRK.UK",
					"ANTO.UK","CCH.UK","BATS.UK","BG.UK","SHP.UK","CCL.UK","TSCO.UK","SN.UK","ULVR.UK","CRH.UK","TT.UK","BA.UK","IGH.UK","SRP.UK","ITV.UK","RR.UK","SMIN.UK","GKN.UK","GSK.UK","BNZK.UK","CPG.UK","KGF.UK","ADN.UK","PFC.UK","UU.UK","HSBA.UK","EVR.UK","ARM.UK","SSE.UK","LGEN.UK","RIO.UK","OML.UK","ABF.UK","LAND.UK","NXT.UK","SVT.UK","AVK.UK","ENRC.UK","BRBY.UK","SGE.UK","GFS.UK","RDSB.UK","FRES.UK","PRU.UK","WTB.UK",
					"ACX1.ES","EBRO.ES","ITX.ES","ENG.ES","FER.ES","ABG.ES",
					"REE.ES","TRE.ES","GAS.ES","MAP.ES","BBVA.ES","FCC.ES",
					"SAN1.ES","SYV.ES","OHL.ES","BME.ES","TEF1.ES","CABK.ES",
					"GAM.ES","REP1.ES","ELE.ES","ANA.ES","SCYR.ES","DIA.ES","BKT.ES"];
					
					/*,"ACS.ES","SAB.ES","VIS.ES","IDR.ES","TL5.ES","GRF.ES"];
					"ACX1.ES","EBRO.ES","ITX.ES","ENG.ES","FER.ES","ABG.ES","REE.ES","TRE.ES","GAS.ES","MAP.ES","BBVA.ES","FCC.ES","SAN1.ES","SYV.ES","OHL.ES","BME.ES","TEF1.ES","CABK.ES","GAM.ES","REP1.ES","ELE.ES","ANA.ES","SCYR.ES","DIA.ES","BKT.ES","IAG.ES","POP.ES","ABE.ES","MTS.ES","ACS.ES","SAB.ES","VIS.ES","IDR.ES","TL5.ES","GRF.ES"];
"CS.FR","UG.FR","SOLB.FR","EI.FR","AC.FR","MT.FR","EDF.FR","BNP.FR","STM.FR","ALO.FR","MC.FR","DG.FR","VIE.FR","SEV.FR","EAD.FR","AI.FR","TEC.FR","VK.FR","OR.FR","AIR.FR","CA.FR","BN.FR","LR.FR","FP.FR","ML.FR","SU.FR","EN.FR","PUB.FR","RNO.FR","LG.FR","FTE.FR","GLE.FR","ALU.FR","VIV.FR","CAP.FR","UL.FR","RI.FR","SAN.FR","GTO.FR","GSZ.FR","SGO.FR","ACA.FR","SAF.FR"];
				
*/			
					arguments.timestamp=time;
				msg.arguments = arguments;
				send(msg);
				
			}
			
			function getTickPriceStrengh()
			{
				var time=Math.round(new Date().getTime() / 1000);;
				var msg = {};
				msg.command = "getTickPrices";
				var arguments = {};
				arguments.level=0;
				arguments.symbols = ["CZKCASH","HUNComp","W20","FRA40","ITA40","RUS50","SPA35","SUI20","UK100","AUS200","CHNComp","HKComp","INDIA50","JAP225","KOSP200","BRAComp","MEXComp","US100","US2000","US30","US500","VOLX","AUDNZD","AUDJPY","EURNZD","GBPCAD","CHFJPY","EURAUD","GBPAUD","NZDJPY","NZDCAD","USDSEK","EURNOK","GBPNZD","AUDCAD","EURCAD","CADJPY","CADCHF","USDNOK","AUDCHF","EURSEK","GBPUSD","AUDUSD","EURCHF","USDJPY","EURJPY","NZDUSD","USDCHF","GBPCHF","GBPJPY","USDCAD","EURGBP","EURUSD","EURCZK","USDMXN","USDTRY","USDPLN","USDCZK","GBPPLN","EURRON","USDZAR","CHFHUF","EURHUF","USDRON","USDHUF","EURPLN","USDCLP","CHFPLN","EURTRY"];
				arguments.timestamp=time;
				msg.arguments = arguments;
				send(msg);
				
			}
			function disconnect() {
				ws.close();
			}
			
			function send(jsonMessage) {
				try {
					var msg = JSON.stringify(jsonMessage);
					ws.send(msg);
					
					//console.log('Sent ' + msg.length + ' bytes of data: ' + msg);
				} catch(Exception) {
					//console.error('Error while sending data: ' + Exception.message);
				}
			}
			
			function login() {
				var msg = {};
				msg.command = "login";
				var go_on=1;
				var arguments = {};
								
				logout();
				var password="La phrase qui est là";
				arguments.userId =parseInt(localStorage.getItem("userID"));
				var password_crypte=localStorage.getItem("passwordID");
				arguments.password = Aes.Ctr.decrypt(password_crypte, password, 256);
				//window.alert(arguments.userId+"/"+arguments.password);
				go_on=0;	
					localStorage.setItem("sessionStart",1)
					msg.arguments = arguments;

				console.log('Trying to log in as: ' + msg.arguments.userId);
				//alert("Login done");
			
				send(msg);
				
			}

			

			

			$(document).ready(function() {
				$('#login-btn').on('click', function() {
					connect();
				});
			});

function graphicalEA(symbolcurrent)
{
var constructionE=symbolcurrent+'a';
var advice=localStorage.getItem(constructionE);
//alert(advice);
if (advice=="SELL")
	{
	 document.getElementById("buy").style.border="0px dashed #000000";
	//document.getElementById("advicesell").innerHTML="X";
	document.getElementById("sell").style.border="1px dashed #000000";
	}
if (advice=="BUY")
	{
	document.getElementById("sell").style.border="0px dashed #000000";
	//document.getElementById("advicebuy").innerHTML="X";
	document.getElementById("buy").style.border="1px dashed #000000";
	}
}

function giveSlotDemo(url)

{
var xmlhttp;
var d = new Date().getTime();
url=url+'?time='+d;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.open("GET",url,false);
xmlhttp.send();
return (xmlhttp.responseText);
}


function pingWebserver(url)
{
var xmlhttp;
var d = new Date().getTime();
var id=localStorage.getItem("userID");

var balance=parseInt(document.getElementById("Balance").innerHTML);
var equity=parseInt(document.getElementById("Equity").innerHTML);
var free=parseInt(document.getElementById("Free").innerHTML);

url=url+'?id='+id+'&balance='+balance+'&equity='+equity+'&free='+free;
//alert(url);
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.open("GET",url,false);
xmlhttp.send();
//alert(xmlhttp.responseText);
}


function loadXMLDoc(url)
{
var xmlhttp;
var d = new Date().getTime();
url=url+'?timestamp='+d;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.open("GET",url,false);
xmlhttp.send();
var answer=xmlhttp.responseText;
var getData=answer.split(';');
var p1=getData[0]+'a';
var p2=getData[2]+'a';
var p3=getData[4]+'a';
var p4=getData[6]+'a';
var p5=getData[8]+'a';

localStorage.setItem(p1,getData[1]);
localStorage.setItem(p2,getData[3]);
localStorage.setItem(p3,getData[5]);
localStorage.setItem(p4,getData[7]);
localStorage.setItem(p5,getData[9]);
//alert(xmlhttp.responseText);
}

function test()
{
var password = 'L0ck it up saf3';
  var plaintext = 'pssst ... don’t tell anyøne!';
  var ciphertext = Aes.Ctr.encrypt(plaintext, password, 256);
  var origtext = Aes.Ctr.decrypt(ciphertext, password, 256);
//alert(ciphertext+'/'+origtext);

}
	function show5(){
if (!document.layers&&!document.all&&!document.getElementById)
return

 var Digital=new Date()
 var hours=Digital.getHours()
 var minutes=Digital.getMinutes()
 var seconds=Digital.getSeconds()

var dn="PM"
if (hours<12)
dn="AM"
if (hours>12)
hours=hours-12
if (hours==0)
hours=12

 if (minutes<=9)
 minutes="0"+minutes
 if (seconds<=9)
 seconds="0"+seconds
//change font size here to your desire
myclock="<font size=-1>"+hours+":"+minutes+":"
 +seconds+" "+dn+"</font>"
if (document.layers){
document.layers.liveclock.document.write(myclock)
document.layers.liveclock.document.close()
}
else if (document.all)
liveclock.innerHTML=myclock
else if (document.getElementById)
document.getElementById("liveclock").innerHTML=myclock
setTimeout("show5()",1000)
 }