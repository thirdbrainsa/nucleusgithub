 <?php
?>
<div id='disapear'><img src='../images/loading1.gif'></div>
<script type="text/javascript">
var listCurrency = ["EURGBP","AUDNZD","AUDJPY","EURNZD","GBPCAD","CHFJPY","EURAUD","GBPAUD","NZDJPY","NZDCAD","USDSEK","EURNOK","GBPNZD","AUDCAD","EURCAD","CADJPY","CADCHF","USDNOK","AUDCHF","EURSEK","GBPUSD","AUDUSD","EURCHF","USDJPY","EURJPY","NZDUSD","USDCHF","GBPCHF","GBPJPY","USDCAD","EUGBP","EURUSD","EURCZK","USDMXN","USDTRY","USDPLN","USDCZK","GBPPLN","EURRON","USDZAR","CHFHUF","EURHUF","USDRON","USDHUF","EURPLN","USDCLP","CHFPLN","EURTRY"];
	
localStorage.setItem("isOK","1");


</script>

<?php
?>
  <!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <title>Fighters FX</title>
   <!--[if lt IE 9]><script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]--> 
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <link rel="stylesheet" href="../css/tableTrade.css">
    <script type="text/javascript" src="js/smoothie.js"></script>
    <script type="text/javascript" src="js/aes_encrypt.js"></script>
    <script type="text/javascript" src="js/aes_encrypt_function.js"></script>
    <script src="js/jquery.min.js" type="text/javascript"></script>
      <script type="text/javascript" src="js/xAPI-live-quotation.js"></script> 
     <link rel="stylesheet" type="text/css" href="../autofighter.css">
     <script type="text/javascript" src="../js/managePortofolio-2.js?time=<?php echo time(); ?>"></script> 
     <link rel="stylesheet" href="../font/css/font-awesome.min.css">
  </head>

  <body>
<script type="text/javascript">

 // Inital liquitidy Provider SETUP
 // For the moment only mode - xOpennHub
 // Receiver for Bubble Chart based JSON files (replace data in the failes).
 
 // LAUNCH BUBBLE
 
 //PRE PROD ///
//var url_matrix="http://pre-prod.nucleus.thirdbrainfx.com/receiver-matrix.php";
 
 var url_matrix="http://localhost/frontofficeweb/receiver-rates.php";
 
 var L_P=1; //xOpenHub via xAPI (XTB comptabile also and with all xStation Brokers).
 
 // Give back an account number for a demo to start playing just when the user arrive (no need to register ect..) 
 var demo_slot="http://localhost/forexattribute/giveDemoSlot.php";    // Give back an xOpenHub demo slot (need to fill the DB with account with test as password)
 
 // Send to the servers the ID/BALANCE/EQUITY/FREE of the account (enable social aspect and stats aspects)
 var web_server="http://178.22.68.239/forexattribute/onlineGui.php";  // Ping webserver with balance, equity ect...
  var no_external=1;  // no_external=0 if you want to send info of the user to the webserver to web_server variable (becarefull testing with cross domain pb security)
 
 // Where the GUI take the EA advice ? what file. Need to be on the same servers as the GUI !!! or via proxy please 
 var get_info="result.txt";
 
//Url of connection for the xAPI demo
 var url ="wss://ws.xapi.pro/demo";

// Other url for xaPI connection are
     //wss://ws.xapi.pro/demo
     //wss://ws.xapi.pro/demoStream
     //wss://ws.xapi.pro/real
     //wss://ws.xapi.pro/realStream

 // Initialize all position, and digits 
    //localStorage.clear();
     localStorage.setItem("startAll",0);
     localStorage.setItem("lot",1);
     localStorage.setItem("stopall",0);
     localStorage.setItem("firstTestError",0);
     //document.getElementById("Balance").innerHTML="";
     //document.getElementById("Equity").innerHTML="";
     localStorage.setItem("totalbonuscount",0);
     localStorage.setItem("totalTrade",0);
     localStorage.setItem("symbolCurrent","EURUSD");
     localStorage.setItem("symbolCurrentId",1);
     localStorage.setItem("timer",1790);
     localStorage.setItem("tradeID","0");
     localStorage.setItem("userID","546950");
     localStorage.setItem("passwordID","test");
     
    
      var line1 = new TimeSeries();
      //var line2 = new TimeSeries();
      var ws;
      
     
    
    
      //var demo_slot="http://178.22.68.239/forexattribute/giveDemoSlot.php";
      
       // Connection to demo by default.
      //var url = "ws://62.181.0.153:8099/demo";

     
    
     
      console.log('Connecting to: ' + url);
       ws = new WebSocket(url);
	ws.onopen = function() 
	{
        console.log('Connected');
	login();
	//getTickPriceStrengh();
	};
	
	
        setInterval(function() {
	 // Get the clock
	 
	 if (localStorage.getItem("stopall")==0)
	 {
	 
	  //show5();
         
          // Return to white after clicking  - Only display things
	   //var x = document.getElementById("ctable").getElementsByTagName("td");
           //x[6].style.backgroundColor = "white";
	   //x[8].style.backgroundColor = "white";
	   //x[7].style.backgroundColor = "white";
	   //document.getElementById("status").innerHTML="<div id='blank'>blank</div>";
	   // --- End of Return initial graphical state 
	    //connect();
	   
	   //document.getElementById("scurrent").innerHTML=symbolCurrent;
          if (localStorage.getItem("startAll")==1)
           {	  
	  
	    listTrade() ;
	    // Get the balance
	    getBalance();
	   
	    // This part have to be loaded only one time every 30 minutes....
	    var timer=parseInt(localStorage.getItem("timer"));
	    timer=timer+1;
	    localStorage.setItem("timer",timer);
	    
	    if (timer>1800)
	    {
	    
	   // Send info  to webserver 
	    if (no_external==0)
	    {
	    pingWebserver(web_server);
	    } 
	    // Get Latest Information about EA
	    //loadXMLDoc(get_info);
	    // Put the graphicak aspect of the EA
	    //graphicalEA(symbolCurrent);
	     localStorage.setItem("timer",0);
	    }
	    // ---
            } 
	    ws.onmessage = function(evt)
				{
					
					console.log("sent : " + evt.data);
					
					
					try {
						var response = JSON.parse(evt.data);

						if(response.status == true) {
							
							if(response.streamSessionId != undefined) 
							{
							localStorage.setItem("startAll",1);	
							} 
							else 
							{
							
							//var orderReturn=response.returnData.order;
							//f ( (orderReturn!=undefined) && (localStorage.getItem("oneway")!=1))
							//{
						       //localStorage.setItem("orderReturn",orderReturn);
						       //transactionStatus(orderReturn);
						       //localStorage.setItem("oneway",1);
						       
							//}
							//var responseTrade=response.returnData.requestStatus;
							
												
							
							var ask = response.returnData.ask;
							
							if (ask != undefined)
							{
							 var bid = response.returnData.bid;
							 localStorage.setItem("ask",ask);
							 localStorage.setItem("bid",bid);
							 storeTickVariable(response.returnData);
							 }
						
							if (localStorage.getItem("type")!=undefined)
							{
							
											
								
							localStorage.setItem("notrade",0);
							}
							
							else
							{
							 localStorage.setItem("notrade",1);
							
							}

							if (response.returnData.balance!=undefined)
							
									{
									
									}
									
							 
							}

						} else {
							console.log('Error: ' + response.errorDescr);
							if (response.errorDescr=="Login in progress")
							{
							//alert("We are in process to log in ");
							document.getElementById("status").innerHTML=" Login in process ... ";
							}
						        
							
							// Just try one time
							
						}
					} catch (Exception) {
						console.log('Fatal error while receiving data! :('+Exception);
					}
				}


    	    var bid=localStorage.getItem("bid");
            var ask=localStorage.getItem("ask");
	     
	     //document.getElementById("Bid").innerHTML=bid;
	     //document.getElementById("Ask").innerHTML=ask;
	   

	     bidRate=parseFloat(bid);
  	     askRate=parseFloat(ask);
           
	               
            var delta=(askRate-bidRate)*10000;
            //document.getElementById("spread").innerHTML=delta.toFixed(2);
            // when market is closed to animate it...	     
            // bidRate=bidRate+Math.random() * 0.00001
         
            //line1.append(new Date().getTime(), bidRate) ;
	   
	  ////// FEED THE JSON FILES FOR BUBBLE CHARTS

        /// PREPARE THE VARIABLE OF THE MATRIX BUBBLE.
				
	///
			var KeyS="";
			var buildVariable="";
			for (var i =0 ; i <=listCurrency.length - 1; i++) 
						{
						
							keyS=listCurrency[i];
							nameOfThekeyS=keyS;
							var get_value_ask=localStorage.getItem("Ask_"+nameOfThekeyS);
							if (get_value_ask=="Infinity") { get_value_ask=0;}
							if (get_value_ask=="-Infinity") {get_value_ask=0;}
							
							var get_value_bid=localStorage.getItem("Bid_"+nameOfThekeyS);
							if (get_value_ask=="Infinity") { get_value_ask=0;}
							if (get_value_ask=="-Infinity") {get_value_ask=0;}
							
							buildVariable=buildVariable+"&Ask_"+keyS+"="+get_value_ask+"&Bid_"+keyS+"="+get_value_bid;
						
						}
			var url_matrix_enrich=url_matrix+"?userID="+localStorage.getItem("userID")+buildVariable;
			//alert(url_matrix_enrich);
			//document.getElementById("launch").innerHTML=url_matrix_enrich;
			//window.open(url_matrix_enrich);
			
			sendDatatoFilesJSON(url_matrix_enrich);


	//////
	   
	   
	   
	   
            ws.onclose = function() {
					console.log('Connection closed');
					//alert("Connection is closed");
					console.log("we will try to re-connect");
					console.log('Connecting to: ' + url);
					ws = new WebSocket(url);
					ws.onopen = function() 
						{
							console.log('Connected');
							login();
						};
	
					
				};
	    
	      
	     
	   
	   
}
            
       },500);

     



    </script>

</body>
</head>
</html>