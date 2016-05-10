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
	alert("Connect");
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

localStorage.setItem("lot",lot);
 var x = document.getElementById("risk").getElementsByTagName("td");
  if (lot==1) {  x[1].style.backgroundColor = "#e5e5e4";x[2].style.backgroundColor = "white";x[3].style.backgroundColor = "white"; }
  if (lot==3) {  x[2].style.backgroundColor = "#e5e5e4";x[1].style.backgroundColor = "white";x[3].style.backgroundColor = "white"; }
  if (lot==10) {  x[3].style.backgroundColor = "#e5e5e4";x[2].style.backgroundColor = "white";x[1].style.backgroundColor = "white"; }
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
		 localStorage.setItem("symbolCurrent","USDCAD");
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
	 msg.command = "closePosition";
	var arguments = {};
	   
				  //arguments.tradeTransInfo.cmd=parseInt(cmd);
				  //arguments.tradeTransInfo.customComment="";
				  //arguments.tradeTransInfo.expiration=0;
		                  arguments.position=parseInt(order);
				  arguments.price= parseFloat(price);
				  //arguments.tradeTransInfo.ie_deviation=0;
				  //arguments.tradeTransInfo.sl=parseFloat(0);
				  //arguments.tradeTransInfo.tp=parseFloat(0);
				  //arguments.tradeTransInfo.symbol=symbolOpenedPosition;
				  //arguments.tradeTransInfo.type=2;
				  arguments.volume=parseFloat(lot/10);
				  
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
 function parseGetAllTrade(returnData) {
				
				
				if (returnData.length==0)
				{
					document.getElementById("position").innerHTML="";
					localStorage.removeItem("type");
					localStorage.removeItem("position");
					localStorage.removeItem("profit");
				}
				else
				{
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
					
					
					localStorage.setItem("order",order);
					localStorage.setItem("profit",profit);
					localStorage.setItem("position",position);
					localStorage.setItem("type",type);
					localStorage.setItem("close_price",close_price);
					localStorage.setItem("order2",order2);
					localStorage.setItem("symbolOpenedPosition",symbol);
					localStorage.setItem("volume", volume);
				};
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
   closePosition();
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
closePosition();
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
			function disconnect() {
				ws.close();
			}
			
			function send(jsonMessage) {
				try {
					var msg = JSON.stringify(jsonMessage);
					ws.send(msg);
					
					console.log('Sent ' + msg.length + ' bytes of data: ' + msg);
				} catch(Exception) {
					console.error('Error while sending data: ' + Exception.message);
				}
			}
			
			function login() {
				var msg = {};
				msg.command = "login";
				var go_on=1;
				var arguments = {};
				
				
				
				//arguments.userId = parseInt($('#userId').val());
				//arguments.password = $('#password').val();
				if (localStorage.getItem("sessionStart")!=1)
				{
				var password="La phrase qui est là";
				var loginasked=giveSlotDemo(demo_slot);
				//alert(loginasked);
				if (loginasked=="")
					{
					alert("There is no slot available for the demo 'on the fly'. You need to create a personnal demo by going to the link available on this screen or just wait");
				
					}
					else
					{
				arguments.userId =parseInt(loginasked);
				arguments.password =Aes.Ctr.decrypt("dwPhkV73w1ODv2zX", password, 256);
				        }
				 //var ciphertext = Aes.Ctr.encrypt(arguments.password, password, 256);
				
				localStorage.setItem("userID",arguments.userId);
				}
				else
				{
				
				logout();
				var password="La phrase qui est là";
				arguments.userId =parseInt(localStorage.getItem("userID"));
				var password_crypte=localStorage.getItem("passwordID");
				arguments.password = Aes.Ctr.decrypt(password_crypte, password, 256);
				go_on=0;	
				}
				
				
				msg.arguments = arguments;

				console.log('Trying to log in as: ' + msg.arguments.userId);
				//alert("Login done");
				if ( (loginasked!="") || (go_on!=1))
				{
				send(msg);
				}
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