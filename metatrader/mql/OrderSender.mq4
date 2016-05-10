//+-----------------------------------------------------------------------------+
//|                                                   OrderSend.mq4             |
//|                        Copyright 2016, ThirdBrain SA. Pierre Jean Duvivier. |
//|                                             https://www.thirdbrainfx.com    |
//+-----------------------------------------------------------------------------+
#property copyright "Copyright 2016, ThirdBrain SA - Pierre Jean Duvivier."
#property link      "https://www.thirdbrainfx.com"
#property version   "1.00"
#property strict

extern string strategy="NONAME";
//+------------------------------------------------------------------+
//| Expert initialization function                                   |
//+------------------------------------------------------------------+
int OnInit()
  {
//---

   
  
  



//---
   return(INIT_SUCCEEDED);
  }
//+------------------------------------------------------------------+
//| Expert deinitialization function                                 |
//+------------------------------------------------------------------+
void OnDeinit(const int reason)
  {
//---
   
  }
//+------------------------------------------------------------------+
//| Expert tick function                                             |
//+------------------------------------------------------------------+
void OnTick()
  {
//---
   string cookie=NULL,headers;
   char post[],result[];
   int res;
//--- to enable access to the server, you should add URL "https://www.google.com/finance"
//--- in the list of allowed URLs (Main Menu->Tools->Options, tab "Expert Advisors"):
string nucleus_url="http://localhost/nucleusgithub/injectordb/receive-order-mql.php";

   ResetLastError();
//--- Loading a html page from Google Finance
  int total = OrdersTotal();
  int timeout=0;
  
  for(int i=total-1;i>=0;i--)
  {
  if(OrderSelect(i,SELECT_BY_POS,MODE_TRADES))
  
         {
           
           int cmd=OrderType();
           string instrument=OrderSymbol();
           double takeprofit=OrderTakeProfit();
           double stoploss=OrderStopLoss();
           double swap=OrderSwap();
           double orderOpenPrice=OrderOpenPrice();
           datetime timeOpen=OrderOpenTime();
           double profit=OrderProfit();
           double vpoint  = MarketInfo(instrument,MODE_POINT);
           int    vdigits = MarketInfo(instrument,MODE_DIGITS);
           int    vspread = MarketInfo(instrument,MODE_SPREAD);
string nucleus_url_global=nucleus_url+"?cmd="+cmd+"&instrument="+instrument+"&takeprofit="+takeprofit+"&stoploss="+stoploss+"&swap="+swap+"&openprice="+orderOpenPrice+"&timeopen="+timeOpen+"&profit="+profit+"&vpoint="+vpoint+"&digit="+vdigits+"&spread="+vspread+"&strategy="+strategy;
           
         Print (nucleus_url_global);
           res=WebRequest("GET",nucleus_url_global,cookie,NULL,timeout,post,0,result,headers);
//--- Checking errors
          /*
            if(res==-1)
               {
               // Print("Error in WebRequest. Error code  =",GetLastError());
      //--- Perhaps the URL is not listed, display a message about the necessity to add the address
               //rint("Add the address "+nucleus_url+" in the list of allowed URLs on tab Expert Advisors","Error",MB_ICONINFORMATION);
               }
            else
            {
               //--- Load successfully
                //--
               
               }    
               */
         }
         }
  }
//+------------------------------------------------------------------+
