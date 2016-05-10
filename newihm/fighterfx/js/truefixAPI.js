function changeLot_truefix(sum)
{
   var lot=localStorage.getItem("lot");
   lot=parseFloat(lot);
   lot=lot+sum;
   if (lot<1) {lot=1; alert(' minimum of 10K');}

   //alert("New lot : "+lot*10+ "K");
   localStorage.setItem("lot",lot);
   document.getElementById("Lot").innerHTML=lot;

}

function tradeClose_truefix()
 {
      //alert("CLOSE");
        localStorage.clear();
      document.getElementById("Position").innerHTML="";
      document.getElementById("Balance").innerHTML=document.getElementById("Equity").innerHTML;
      var getlot=document.getElementById("Lot").innerHTML;

      localStorage.setItem("lot",getlot);
}
function listTrade_truefix( bid, ask)
 {
     var bid=parseFloat(bid);
     var ask=parseFloat(ask);


     var type=localStorage.getItem("position1");
     if ((type=="SELL") || (type=="BUY")) 
     { 
      var time=localStorage.getItem("position1Time");
      var openprice=localStorage.getItem("position1OpenPrice");
      var openprice=parseFloat(openprice);    
      var d = new Date();
      var n = d.getTime();
      var diffTime=(n-time)/1000;
      var lot=localStorage.getItem("lot");
      lot=parseFloat(lot);

     if (type=="SELL") { var pips=(openprice-ask)*10000*lot; }
     if (type=="BUY")  { var pips=(bid-openprice)*10000*lot; }
     
     document.getElementById("Position").innerHTML="<tr><td><font size=+7>"+diffTime.toFixed(0)+"s  </font><td><td>  </td><td><font size=+7>"+pips.toFixed(2)+ " USD</font>("+type+","+lot*10+" K )</td></tr>"; 
     
     var equity=document.getElementById("Balance").innerHTML;
     
     equity=parseFloat(equity);
     
     var newequity=equity+parseFloat(pips.toFixed(2));
     
     document.getElementById("Equity").innerHTML=newequity.toFixed(2)+ " USD";
     
 }
      
      
    
 
 }
   function openSell_truefix()
{
document.getElementById("Balance").innerHTML=document.getElementById("Equity").innerHTML;
 
      var d = new Date();
      var n = d.getTime();

      getRateTrueFx();

      var reponseData=localStorage.getItem('eurusd');
      var dataFinalArray=reponseData.split(',');
      var priceOpen=dataFinalArray['2']+dataFinalArray['3'];

      var lot=localStorage.getItem("lot");

      priceOpen=parseFloat(priceOpen);
      localStorage.setItem("position1","SELL");
      localStorage.setItem("position1Time",n);
      localStorage.setItem("positionLot",lot);
      lot=parseFloat(lot);
      localStorage.setItem("position1OpenPrice",priceOpen);
      //alert("Sell");
       
}

function openBuy_truefix()
{
document.getElementById("Balance").innerHTML=document.getElementById("Equity").innerHTML;

      var d = new Date();
      var n = d.getTime();
      
      getRateTrueFx();
      var reponseData=localStorage.getItem('eurusd');
      var dataFinalArray=reponseData.split(',');
      var numAsk=dataFinalArray['5'];
            //var numAsk=parseFloat(numAsk)-35;

      var priceOpen=dataFinalArray['4']+numAsk;
      priceOpen=parseFloat(priceOpen);
      var lot=localStorage.getItem("lot");
      lot=parseFloat(lot);
      localStorage.setItem("position1","BUY");
      localStorage.setItem("position1Time",n);
      localStorage.setItem("positionLot",lot);
      localStorage.setItem("position1OpenPrice",priceOpen);
     //alert("Buy");
}


   function getRateTrueFx_truefix()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    var serveranswer=xmlhttp.responseText;
    localStorage.setItem('eurusd',serveranswer);
    }
  }
xmlhttp.open("GET","connector/truefx/get-rate.php",true);
xmlhttp.send();

} 