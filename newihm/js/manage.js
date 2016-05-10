function msieversion() {

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer, return version number
            {
		    //document.getElementById("boxglobalinfo").innerHTML="<font size=+2 color=red><b>This application is not compatible with Internet Explorer, all version, use Chrome, Safari or FireFox instead</b></font>";
	    }
   

   return false;
}

function buy(token)
{
	
	
}

function sell (token)
{
	
	
}
function changeMatrix(table)
{

	
	 $.get("getLastTradeTableMatrixHistory.php", function(data) 
	{ 
			
		    //alert(' GET data '+i+' '+data);
				var content = document.getElementsByClassName("details");
	var symbol= document.getElementsByClassName("symbol");
			var tablenew=JSON.parse(data);
		//alert(tablenew);	
		//alert(data);
			//alert(tablenew[1]);
		var i;
		var tour=0;j=0;
			for (i = 0; i < symbol.length;  i ++ ) 
			{
				
			//alert(i+'/'+tablenew[i]);
				j=i*5;
				symbol[i].innerHTML ='<b>'+tablenew[j]+'</b>';
				content[i].innerHTML = tablenew[j+1]+'<br>'+tablenew[j+2];
			}
		
			}
    
    );

   
	
	

}
function changeMatrixHistory(table)
{

	
	 $.get("getLastTradeTableHistory.php", function(data) 
	{ 
			
		    //alert(' GET data '+i+' '+data);
				var content = document.getElementsByClassName("details");
	var symbol= document.getElementsByClassName("symbol");
			var tablenew=JSON.parse(data);
		//alert(tablenew);	
		//alert(data);
			//alert(tablenew[1]);
		var i;
		var tour=0;j=0;
			for (i = 0; i < symbol.length;  i ++ ) 
			{
				
			//alert(i+'/'+tablenew[i]);
				j=i*5;
				symbol[i].innerHTML ='<b>'+tablenew[j]+'</b>';
				content[i].innerHTML = tablenew[j+1]+'<br>'+tablenew[j+2];
			}
		
			}
    
    );

   
	
	

}
function loadMeter(login)
{
	var balance=localStorage.getItem("BalanceCurrent");
	 $.get("meter.php?login="+login+"&balance="+balance, function(data) 
	{ 
			if (data!="")
		{
			$("#meter").html( data ); // assuming the only string returned is the title
		}
			}
    
    );
	
	
}
function adviceCFD()
{
    $.get("getAdviceCFD.php", function(data) 
	{ 
			if (data!="")
		{
			$("#adviceoutsideforex").html( data ); // assuming the only string returned is the title
		}
			}
    
    );
}
function classInstrument()
{
	
$.get("listClassInstrument.php", function(data) 
		{ 
		
        $("#classinstrument").html( data ); // assuming the only string returned is the title
		}
			);	
	
}
function infoTrade(login)
{
	
$.get("infoTrading.php?login="+login, function(data) 
		{ 
		
        $("#infoabouttrade").html( data ); // assuming the only string returned is the title
		}
			);	
	
}
function listDynTrade(token)
{
	var data=localStorage.getItem("listposition");
	if (data!=undefined)
	{
		$("#tradeglobal").html(data);
		
	}
	else
	{
	$.get("listeTrade.php?token="+token, function(data) 
		{ 
		
        $("#tradeglobal").html( data ); // assuming the only string returned is the title
		}
			);
	}
	
}
function listHysTrade(token)
{
var d = new Date();
var n = d.getTime();
	var data=localStorage.getItem("historylocal");
	if (data!=undefined)
	{
	$("#tradeglobal").html(data);
	}
	else
	{
	$.get("listeHistory.php?token="+token+"&time="+n, function(data) 
		{ 
					$("#tradeglobal").html( data ); // assuming the only string returned is the title
		}
	);
	}
	
}
function show(signature)
{	
	document.getElementById("datainfo").style.visibility='visible';
	$.get('html/'+signature+".html", function(data) 
		{ 
		
        $("#datainfo").html( data ); // assuming the only string returned is the title
		}
			);
}
function getInfoPairs(pair)
{
	
	
}

function hide(signature)
{
	
	//document.getElementById("datainfo").style.visibility='hidden';
	
}
function displayInfo( instrument )
{
	if (document.getElementById('info_'+instrument).style.visibility=='hidden')
		{	
	document.getElementById('info_'+instrument).style.visibility='visible'; 
	document.getElementById('info_'+instrument).style.position='relative'; 
		}
		else
		{
	document.getElementById('info_'+instrument).style.visibility='hidden'; 
	document.getElementById('info_'+instrument).style.position='absolute'; 		
			
		}
}

function balanceRefresh(token)
{
	
    if (localStorage.getItem("BalanceCurrent")!=undefined)
	{
		var Balance=localStorage.getItem("BalanceCurrent");
		var Equity=localStorage.getItem("EquityC");
		var MarginFree=localStorage.getItem("MarginFree");
		var profitT=Equity-Balance;
		document.getElementById("balance").innerHTML="<div class='large green button'>BALANCE : "+Balance+" USD</div> <div class='large green button'><a href='TradeManagement.php'>EQUITY :"+Equity+" USD</a></div><div class='large green button'>PROFIT :"+profitT.toFixed(2)+" USD</div><div class='large green button'>FREE MARGIN :"+MarginFree+" USD</div>";
	
		$.get("insertBalance.php?token="+new Date().getTime()+"&balance="+Balance, function(data) 
			{ 
			if (data!="")
				{
				//$("#balance").html( data ); // assuming the only string returned is the title
				}
			}
    
			);
		
	}
	
	else
	{
    $.get("balanceGetData.php?token="+new Date().getTime(), function(data) 
	{ 
			if (data!="")
		{
				$("#balance").html( data ); // assuming the only string returned is the title
		}
	}
    
    );
	
	}
}

function registerRunningTradexStation()
{
	
	
}
function startRefreshRate(token)
{
    $.get("refresh-rates.php?token="+new Date().getTime(), function(data) 
	{ 
			if (data!="")
		{
        $("#currencyglobal").html( data ); // assuming the only string returned is the title
		}
			}
    
    );
}

function getbackriskandgain(token,balance)
{

 $.get("compute.php?token="+token+'&balance='+balance, function(data) 
	{ 
	if (data!="")
		{
				
			$("#riskandgain").html( data ); // assuming the only string returned is the title
		}
	}
    
    );

}	

function startRefreshRateDb(token)
{
    $.get("refresh-rates-db.php?token="+new Date().getTime(), function(data) 
	{ 
			if (data!="")
		{
        $("#currencyglobal").html( data ); // assuming the only string returned is the title
		}
			}
    
    );
	
	
}
function changeAuto(token)
{
	
		 $.get("change-stat-automated.php?token="+token, function(data) 
	{ 
			if (data!="")
					{
						
			
					}
			}
    
    );
		}
function changeAutoNucleus(token)
{
	
		 $.get("change-stat-nucleus.php?token="+token, function(data) 
	{ 
			if (data!="")
					{
						
			
					}
			}
    
    );
}
function changeEmail(token)
{
	
		 $.get("change-stat-email.php?token="+token, function(data) 
	{ 
			if (data!="")
					{
						
			
					}
			}
    
    );
	
}
function startRefreshRateForTrading(token)
{
    $.get("refresh-rates-trading.php?token="+new Date().getTime(), function(data) 
	{ 
			if (data!="")
		{
			$("#currencyglobal").html( data ); // assuming the only string returned is the title
		}
			}
    
    );
	
	
}

function registerPortfolio(login,token,strategy,instrument)
{
	document.getElementById('lot_'+strategy+instrument).innerHTML="wait..";
	 $.get("portofolio-register.php?token="+token+"&login="+login+"&strategy="+strategy+"&instrument="+instrument, function(data) 
	{ 
			if (data!="")
					{
						//window.alert(data);
						if (data=="MAXSTRAT")
						{
							document.getElementById('por_'+strategy+instrument).innerHTML="<a href=\"javascript:registerPortfolio('"+login+"','"+token+"','"+strategy+"','"+instrument+"');\"'><i class=\"fa fa-square-o fa-2x\"></i></a>";
							document.getElementById('lot_'+strategy+instrument).innerHTML="You reached limit of number of strategies, unselect one to add this one";
						}
						if (data=="GOOD")
						{
							//window.alert(data);
						document.getElementById('por_'+strategy+instrument).innerHTML="<a href=\"javascript:removePortfolio('"+login+"','"+token+"','"+strategy+"','"+instrument+"');\"><i class=\"fa fa-check-square fa-2x\"></a>";
						document.getElementById('lot_'+strategy+instrument).innerHTML="0.01<a href=\"javascript:changelotsizeup('0.01','"+login+"','"+token+"','"+strategy+"','"+instrument+"');\"'>(+)</a>";
						}
						else
						{
							if ($data=="BAD")
							{
						document.getElementById('por_'+strategy+instrument).innerHTML="Open a demo account";
							}
							
						}
					}
			}
    
    );
}

function addAsset(asset,login,token,type)
{
	document.getElementById('asset_'+asset).innerHTML="wait..";
	
	 $.get("asset-register.php?token="+token+"&login="+login+"&asset="+asset+"&type="+type, function(data) 
	{ 
			if (data!="")
					{
						
						if (data=="GOOD")
						{
							
							document.getElementById('adviceoutsideforex').innerHTML="<img src='img/ajax-loader.gif'>";
							adviceCFD();
							
							//window.alert(data);
							if (type=="add")
							{
								rtype="remove";
						document.getElementById('asset_'+asset).innerHTML="<a href=\"javascript:addAsset('"+asset+"','"+login+"','"+token+"','"+rtype+"');\"><i class='fa fa-bell-o'> "+asset+" </a>";
							}
							else
							{
								rtype="add";
						document.getElementById('asset_'+asset).innerHTML="<a href=\"javascript:addAsset('"+asset+"','"+login+"','"+token+"','"+rtype+"');\"><i class='fa fa-bell-slash-o'> "+asset+" </a>";
								
							}
								}
						else
						{
							if ($data=="BAD")
							{
						document.getElementById('asset_'+asset).innerHTML="Not possible...";
							}
							
						}
					}
			}
    
    );
}
function removeAsset(asset,login,token)
{
	document.getElementById('asset_'+asset).innerHTML="wait..";
	
	 $.get("asset-remove.php?token="+token+"&login="+login+"&asset="+asset, function(data) 
	{ 
			if (data!="")
					{
						
						if (data=="GOOD")
						{
							//window.alert(data);
						document.getElementById('asset_'+asset).innerHTML="<a href=\"javascript:addAsset('"+asset+"','"+login+"','"+token+"','add');\"><i class='fa fa-bell-o'></i> "+asset+" </i></a>";
						}
						else
						{
							if ($data=="BAD")
							{
						document.getElementById('asset_'+asset).innerHTML="Not possible...";
							}
							
						}
					}
			}
    
    );
}
function removePortfolio(login,token,strategy,instrument)
{
	document.getElementById('lot_'+strategy+instrument).innerHTML="wait..";
	 $.get("portofolio-register.php?command=DELETE&token="+token+"&login="+login+"&strategy="+strategy+"&instrument="+instrument, function(data) 
	{ 
			if (data!="")
					{
						if (token.length!=32)
						{
						document.getElementById('adviceoutsideforex').innerHTML="<img src='img/ajax-loader.gif'>";
						adviceCFD();
						}
						 document.getElementById('por_'+strategy+instrument).innerHTML="<a href=\"javascript:registerPortfolio('"+login+"','"+token+"','"+strategy+"','"+instrument+"');\"'><i class=\"fa fa-square-o fa-2x\"></i></a>";
						 document.getElementById('lot_'+strategy+instrument).innerHTML="";
			
					}
			}
    
    );
}
function changelotsizedown(lot_size,login,token,strategy,instrument)
{
	document.getElementById('lot_'+strategy+instrument).innerHTML="wait..";
	 $.get("portofolio-register.php?command=LOTSIZEDOWN&token="+token+"&login="+login+"&strategy="+strategy+"&instrument="+instrument, function(data) 
	{ 
			if (data!="")
					{
						lot_size=parseFloat(lot_size)-parseFloat(0.01);lot_size=parseFloat(lot_size).toFixed(2);
						if (lot_size<0.01) {lot_size="0.01";}
						document.getElementById('lot_'+strategy+instrument).innerHTML="<a href=\"javascript:changelotsizedown('"+lot_size+"','"+login+"','"+token+"','"+strategy+"','"+instrument+"');\"'><i class=\"fa fa-sort-desc\"></i></a> "+lot_size+"</a> <a href=\"javascript:changelotsizeup('"+lot_size+"','"+login+"','"+token+"','"+strategy+"','"+instrument+"');\"'><i class=\"fa fa-sort-asc\"></i></a>";
						
					}
			}
    
    );
}
function changelotsizeup(lot_size,login,token,strategy,instrument)
{
	document.getElementById('lot_'+strategy+instrument).innerHTML=".wait..";
	 $.get("portofolio-register.php?command=LOTSIZEUP&token="+token+"&login="+login+"&strategy="+strategy+"&instrument="+instrument, function(data) 
	{ 
			if (data!="")
					{
						lot_size=parseFloat(lot_size)+parseFloat(0.01);lot_size=parseFloat(lot_size).toFixed(2);
				document.getElementById('lot_'+strategy+instrument).innerHTML="<a href=\"javascript:changelotsizedown('"+lot_size+"','"+login+"','"+token+"','"+strategy+"','"+instrument+"');\"'><i class=\"fa fa-sort-desc\"></i></a> "+lot_size+"</a> <a href=\"javascript:changelotsizeup('"+lot_size+"','"+login+"','"+token+"','"+strategy+"','"+instrument+"');\"'><i class=\"fa fa-sort-asc\"></i></a>";
						
					}
			}
    
    );
}
function startRefresh(token)
{
	startTime();
	//window.alert(token);

	$.get("getLastTrade.php?token="+token+"&time="+new Date().getTime(), function(data) 
	{ 
			if (data!="")
		{
        $("#activesignal").html( data ); // assuming the only string returned is the title
		}
			}
    
    );
	
}
function closeTrade(signature,token)
{
	
	document.getElementById('clicksign_'+signature).innerHTML="Sending..<br><i class=\"fa fa-circle-o\"></i>";
	$.get("register-trade-journal.php?signature="+signature+"&token="+token+"&close=1", function(data) 
	{ 
		
		//window.alert(data);
			if (data!="")
		{			//window.alert('answer_'+signature);
			
			
			if (data=="GOOD")
				{
					
				document.getElementById('clicksign_'+signature).innerHTML="Done..<br><i class=\"fa fa-circle\"></i>";	
				}
			
			if (data=="BAD")
				{
				document.getElementById('clicksign_'+signature).innerHTML="<i class=\"fa fa-ban\"></i>";	
					
				self.location.href='onlySignal.php?userID=XXX';
					
				}
					//localStorage.setItem('answer_'+signature,data);
		}
			}
    
	);
}
function registerTrade(signature,token)
{
	document.getElementById('clicksign_'+signature).innerHTML="Sending..<br><i class=\"fa fa-circle-o\"></i>";
	if (token==0)
	{
				document.getElementById('clicksign_'+signature).innerHTML="<i class=\"fa fa-ban\"></i>";	
					
				self.location.href='login-demo-dashboard.php';
	}
	else
	{
	$.get("register-trade-journal.php?signature="+signature+"&token="+token, function(data) 
	{ 
		
		//window.alert(data);
			if (data!="")
		{			//window.alert('answer_'+signature);
			
			
			if (data=="GOOD")
				{
					
				document.getElementById('clicksign_'+signature).innerHTML="Done..<br><i class=\"fa fa-circle\"></i>";	
				}
			
			if (data=="BAD")
				{
				document.getElementById('clicksign_'+signature).innerHTML="<i class=\"fa fa-ban\"></i>";	
					
				//self.location.href='login-demo-dashboard.php';
					
				}
					//localStorage.setItem('answer_'+signature,data);
		}
			}
    
    );
		}
}
function startRefreshHistory(token)
{
	startTime();
	
	$.get("getLastTradeHistory.php?token="+token+"&time="+new Date().getTime(), function(data) 
	{ 
			if (data!="")
		{
        $("#historysignal").html( data ); // assuming the only string returned is the title
		}
			}
    
    );
	
}
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    //document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
    //var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}

