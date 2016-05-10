<?php
include_once("librairies/manage.php");
// GENERAL DB SETTINGS
$dburl="localhost";
$dblogin="root";
$dbpass="";
$dbbase="mirror";

// DB FOR RATES
$dburl_rates="localhost";
$dblogin_rates="root";
$dbpass_rates="";
$dbbase_rates="mirror";

$_MINTOCLOSE=20;
$_MODIFY_DELTA=0;
$_RISKPROFILE=["1","2","5","10","20"];
$_RATE_COMMISSION=0.15; //1% of commission
$dburl_drupal="localhost";
$dblogin_drupal="root";
$dbpass_drupal="";
$dbbase_drupal="drupal";
$_URL_LOGIN="http://localhost/frontofficeweb";
$_max_dashboard=80;
$_cron_path="http://localhost/newihm/";
$_leverage=200;
$_leverage_factor=50;
$_dynamic_rates_url="<IP OF SERVER>";
$_window_os=1;
$_SENDCOMMAND=1; //ENABLE SEND COMMAND TO TRADE MANAGER
$_delta_order=60*60*4;
$_url_to_catch_rate="http://localhost/frontofficeweb/rates";
$_path_matrix_config="../frontofficeweb/rates/";
$_path_fopen="E://xampp//htdocs//frontofficeweb//rates";
$mons = array(1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June", 7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December");
$_Currency= ["CZKCASH","HUNComp","W20","FRA40","ITA40","RUS50","SPA35","SUI20","UK100","AUS200","CHNComp","HKComp","INDIA50","JAP225","KOSP200","BRAComp","MEXComp","US100","US2000","US30","US500","VOLX","AUDNZD","AUDJPY","EURNZD","GBPCAD","CHFJPY","EURAUD","GBPAUD","NZDJPY","NZDCAD","USDSEK","EURNOK","GBPNZD","AUDCAD","EURCAD","CADJPY","CADCHF","USDNOK","AUDCHF","EURSEK","GBPUSD","AUDUSD","EURCHF","USDJPY","EURJPY","NZDUSD","USDCHF","GBPCHF","GBPJPY","USDCAD","EURGBP","EURUSD","EURCZK","USDMXN","USDTRY","USDPLN","USDCZK","GBPPLN","EURRON","USDZAR","CHFHUF","EURHUF","USDRON","USDHUF","EURPLN","USDCLP","CHFPLN","EURTRY"];
$_FX= ["AUDNZD","AUDJPY","EURNZD","GBPCAD","CHFJPY","EURAUD","GBPAUD","NZDJPY","NZDCAD","USDSEK","EURNOK","GBPNZD","AUDCAD","EURCAD","CADJPY","CADCHF","USDNOK","AUDCHF","EURSEK","GBPUSD","AUDUSD","EURCHF","USDJPY","EURJPY","NZDUSD","USDCHF","GBPCHF","GBPJPY","USDCAD","EURGBP","EURUSD","EURCZK","USDMXN","USDTRY","USDPLN","USDCZK","GBPPLN","EURRON","USDZAR","CHFHUF","EURHUF","USDRON","USDHUF","EURPLN","USDCLP","CHFPLN","EURTRY"];

$_EQUIVALENCE_CFD=array ("GER30"=>"DE30",
                                 "ESP35"=>"SPA35",
				 "USOil"=>"OIL.WTI",
				 "UKOil"=>"OIL",
				 "SPX500"=>"US500");

$_live=0; // Include Tracking or not

#TWITTER CODE

$_MODE_TWITTER=0; // 0=NO SENDING, 1= SEND

### FOR THIRDBRAINFX ACCESS (REMPLACE WITH YOUR OWN KEYS !)

$consumerKey='';
$consumerSecret='';
$accessToken='';	
$accessTokenSecret='';

### FOR THIRDBRAINFX2 ACCESS
$consumerKey2='';
$consumerSecret2='';
$accessToken2='';	
$accessTokenSecret2='';

### FOR THIRDBRAINFX3 ACCESS
$consumerKey3='';
$consumerSecret3='';
$accessToken3='';	
$accessTokenSecret3='i';

### FOR THIRDBRAINFX4 ACCESS
$consumerKey4='';
$consumerSecret4='';
$accessToken4='';	
$accessTokenSecret4='';



### RSS FEED CODE
$_RSSFEED="
<rss version=\"2.0\">
<channel>
<item>
<guid isPermaLink=\"false\">
http://signal.thirdbrainfx.com
</guid>
<pubDate>[DATE]</pubDate>
<title>[TITLE]</title>
<description>
[DESCRIPTION]
</description>
<link>
[IFLINK]
</link>
<author>ThirdBrainFx</author>
</item>
</channel>
</rss>";

$_MSG_MATRIX=array("is doing great"=>array(" is doing great  with"," is the good strategy with"," really rocks with","is doing a good job with", "is the strategy to follow with"),
                               "is still doing great"=>array("is still doing great with", "still have good performances with ", "is really the strategy to follow now with ","is still a good strategy with"),
			       "during the last 24 hours"=>array("during the last 24 hours", "today", "in the last 24 hours", "since yesterday"),
			       "playing with"=>array("playing with ", "using","running on","with") ,
			       "win"=>array("won","is winning","continue to win")
			       );
$_TOCHECK_TRADENCY=array ("1"=>array ("reenfx"=>"cadjpy"),
					  "2"=>array ("mars"=>"eurgbp"),
					    "3"=>array ("fxthunder"=>"cadjpy"),
					    "4"=>array ("007fx"=>"eurgbp"),
					    "6"=>array ("thirdbrainfx"=>"audusd"),
					   "7"=>array ("thirdbrainfx"=>"eurjpy"),
					   "8"=>array ("thirdbrainfx"=>"euraud"),
					  "9"=>array ( "coreliancharts"=>"chfjpy"),
					   "10"=>array ("thirdbrainfx"=>"chfjpy"),
					   "11"=>array ("thirdbrainfx"=>"gbpjpy"),
					   "12"=>array ("ontheriver"=>"usdcad"),
					   "13"=>array ("thirdbrainfx"=>"eurcad"),
					  "14"=>array ( "thirdbrainfx"=>"eurgbp"),
					   "15"=>array ("sphynx"=>"usdcad"),
					   "16"=>array ("ontheriver"=>"nzdjpy"),
					   "17"=>array ("coreliancharts"=>"gbpusd"),
					   "18"=>array ("thirdbrainfx"=>"usdcad"),
					   "19"=>array ("thirdbrainfx"=>"gbpusd"),
					   "20"=>array ("sphynx"=>"gbpjpy"),
					   "21"=>array ("thirdbrainfx"=>"eurchf"),
					   "22"=>array ("sphynx"=>"usdjpy"),
					   "23"=>array ("glimspy"=>"eurjpy"),
					   "24"=>array ("goldenfx"=>"nzdjpy"),
					  "25"=>array ( "exotic"=>"audusd"),
					  "26"=>array ( "exotic"=>"chfjpy"),
					   "27"=>array ("exotic"=>"eurjpy"),
					   "28"=>array ("sphynx"=>"eurjpy"),
					  "29"=>array ( "eveningbear"=>"euraud"),
					   "30"=>array ("ontheriver"=>"eurgbp"),
					  "31"=>array ( "morningbull"=>"eurjpy"),
					   "32"=>array ("sphynx"=>"gbpusd"),
					   "33"=>array ("morningbull"=>"euraud"),
					  "34"=>array ( "ontheriver"=>"eurcad"),
					   "35"=>array ("sphynx"=>"audusd"),
					   "36"=>array ("quantum"=>"eurjpy"),
					  "37"=>array ("sphynx"=>"chfjpy"),
					   "38"=>array ("sphynx"=>"cadjpy"),
					   "39"=>array ("x112"=>"gbpjpy"),
					   "40"=>array ("sphynx"=>"audcad"),
					   "41"=>array ("mahonfx"=>"cadjpy"),
					   "42"=>array ("sphynx"=>"nzdusd"),
					   "43"=>array ("sphynx"=>"audjpy"),
					   "44"=>array ("sphynx"=>"eurgbp"),
					   "45"=>array ("fxthunder"=>"chfjpy"),
					   "46"=>array ("ontheriver"=>"xagusd"),
					   "47"=>array ("glimspy"=>"chfjpy"),
					  "48"=>array ( "drake"=>"gbpusd"),
					   "49"=>array ("quantum"=>"cadjpy"),
					   "50"=>array ("exoticfx"=>"eurcad"),
					  "51"=>array ( "x112"=>"usdjpy"),
					   "52"=>array ("coreliancharts"=>"gpbaud"),
					   "53"=>array ("reenfx"=>"gbpjpy"),
					   "54"=>array ("mars"=>"cadjpy"),
					   "55"=>array ("fxthunder"=>"euraud"),
					   "56"=>array ("exoticfx"=>"nzdjpy"),
					   "57"=>array ("007fx"=>"euraud"),
					   "58"=>array ("mars"=>"eurgbp"),
					   "59"=>array ("exoticfx"=>"usdcad"),
					   "60"=>array ("sphynxlight"=>"gpbusd"),
					   "61"=>array ("shortmove"=>"usdcad"),
					   "62"=>array ("exoticfx"=>"gbpusd"),
					   "63"=>array ("dtfx"=>"usdjpy"),
					  "64"=>array ( "acronfx"=>"audjpy"),
					   "65"=>array ("acronfx"=>"cadjpy"),
					   "66"=>array ("drake"=>"cadjpy"),
					   "67"=>array ("drake"=>"nzdjpy"),
					   "68"=>array ("exoticfx"=>"audjpy"),
					   "69"=>array ("exoticfx"=>"cadjpy"),
					   "70"=>array ("007fx"=>"eurgbp"),
					   "71"=>array ("reenfx"=>"usdjpy"),
					  "72"=>array ( "eveningbear"=>"eurjpy"),
					   "73"=>array ("atlanta"=>"cadjpy"),
					   "74"=>array ("wolverine"=>"nzdjpy"),
					   "75"=>array ("richbrain"=>"gbpusd"),
					   "76"=>array ("sphynxjr"=>"gbpusd"),
					  "77"=>array ( "007fx"=>"chfjpy"),
					   "78"=>array ("glimspy"=>"gbpusd"),
					   "79"=>array ("fxthunder"=>"eurjpy"),
					  "80"=>array ( "exotic"=>"eurchf"),
					   "81"=>array ("mahonfx"=>"gbpjpy"),
					   "82"=>array ("reenfx"=>"gbpusd"),
					   "83"=>array ("mars"=>"euraud"),
					   "84"=>array ("reenfx"=>"gbpaud"),
					   "85"=>array ("sphynxlight"=>"usdjpy"),
					   "86"=>array ("007fx"=>"usdjpy"),
					   "87"=>array ("mahonfx"=>"gbpaud"),
					   "88"=>array ("glimspy"=>"nzdusd"),
					  "89"=>array ( "acronfx"=>"usdjpy"),
					   "90"=>array ("nok9"=>"cadjpy"),
					   "91"=>array ("glimspy"=>"cadjpy"),
					  "92"=>array ( "fxthunder"=>"gbpjpy"),
					   "93"=>array ("mahonfx"=>"audjpy"),
					   "94"=>array ("eveningbear"=>"eurusd"),
					  "95"=>array ("mars"=>"audnzd"),
					   "96"=>array ("wolverine"=>"chfjpy"),
					   "97"=>array ("007fx"=>"gbpaud"),
					   "98"=>array ("wolverine"=>"gbpusd"),
					   "99"=>array ("richbrain"=>"cadjpy"),
					   "100"=>array ("drake"=>"nzdusd"),
					   "101"=>array ("reenfx"=>"nzdjpy"),
					   "102"=>array ("atlanta"=>"eurjpy"),
					   "103"=>array ("goldenfx"=>"audusd"),
					   "104"=>array ("morningbull"=>"usdcad"),
					   "105"=>array ("007fx"=>"nzdusd"),
					   "106"=>array ("wolverine"=>"audjpy"),
					   "107"=>array ("goldenfx"=>"gbpusd"),
					   "108"=>array ("fxthunder"=>"cadjpy"),
					  "109"=>array ( "007fx"=>"gbpusd"),
					   "110"=>array ("007fx"=>"audjpy"),
					   "111"=>array ("acronfx"=>"gbpusd"),
					   "112"=>array ("riskchecker"=>"cadjpy"),
					   "113"=>array ("007fx"=>"nzdjpy"),
					   "114"=>array ("007fx"=>"cadjpy"),
					   "115"=>array ("007fx"=>"gbpjpy"),
					  "116"=>array ( "quantum"=>"nzdjpy"),
					  "117"=>array ( "mahonfx"=>"euraud"),
					  "118"=>array ( "goldenfx"=>"gbpaud"),
					   "119"=>array ("007fx"=>"eurjpy"),
					   "120"=>array ("acronfx"=>"euraud"),
					   "121"=>array ("thirdbrainfxlight"=>"cadjpy"),
					   "122"=>array ("afx"=>"eurjpy"),
					   "123"=>array ("fxthunder"=>"gbpaud"),
					   "124"=>array ("atlanta"=>"gbpusd"),
					   "125"=>array ("reenfx"=>"gbpchf"),
					   "126"=>array ("drake"=>"audusd"),
					   "127"=>array ("nok9"=>"audnzd"),
					  "128"=>array ( "atlanta"=>"usdjpy"),
					   "129"=>array ("acronfx"=>"nzdjpy"),
					   "130"=>array ("daisyforex"=>"gbpchf"),
					   "131"=>array ("drake"=>"audcad"),
					   "132"=>array ("007fx"=>"usdcad")
					   );
$_MONITORED=array ("coreliancharts","glimspy","sphynx","morningbull","eveningbear","mars","exotic","ontheriver","thirdbrainfx","drake","dtfx","lynx","x112","fxthunder","007fx","riskchecker","quantum","daysyforex","reenfx","stockmanager","cfdmaster");

?>