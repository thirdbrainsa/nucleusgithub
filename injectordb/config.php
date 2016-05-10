<?php
$dburl="localhost";
$dblogin="root";
$dbpass="";
$dbbase="mirror";

$dburl_rates="localhost";
$dblogin_rates="root";
$dbpass_rates="";
$dbbase_rates="mirror";
$_RATE_COMMISSION=0.065;
$_delta_order=60*60*4;
$_url_for_mailer="http://localhost/mailer/mailer.php";
$_url_to_catch_rate="http://localhost/frontofficeweb/rates";
$_path_matrix_config="../frontofficeweb/rates/";
$_path_fopen="E://xampp//htdocs//frontofficeweb//rates";
$_Currency= ["CZKCASH","HUNComp","W20","FRA40","ITA40","RUS50","SPA35","SUI20","UK100","AUS200","CHNComp","HKComp","INDIA50","JAP225","KOSP200","BRAComp","MEXComp","US100","US2000","US30","US500","VOLX","AUDNZD","AUDJPY","EURNZD","GBPCAD","CHFJPY","EURAUD","GBPAUD","NZDJPY","NZDCAD","USDSEK","EURNOK","GBPNZD","AUDCAD","EURCAD","CADJPY","CADCHF","USDNOK","AUDCHF","EURSEK","GBPUSD","AUDUSD","EURCHF","USDJPY","EURJPY","NZDUSD","USDCHF","GBPCHF","GBPJPY","USDCAD","EURGBP","EURUSD","EURCZK","USDMXN","USDTRY","USDPLN","USDCZK","GBPPLN","EURRON","USDZAR","CHFHUF","EURHUF","USDRON","USDHUF","EURPLN","USDCLP","CHFPLN","EURTRY"];
$mt4_deltatime=10*60;
$_URL_TO_CRON="http://localhost/nucleusgithub/frontoffice/cron-populate.php";
$_URL_FOPEN="http://localhost/nucleusgithub";
$_lock="lock/";
$_leverage=200;
$_leverage_factor=50;
$_limitoftime=60*10;
$_cron_path="http://localhost/newihm/";
function multipips($instrument,$digit)

{
		if ($digit==5) {$multi=0.0001;}
		if ($digit==4) {$multi=0.0001;}
		if ($digit==3) {$multi=0.01;}
		if ($digit==2) {$multi=0.01;}
		if ($digit==1) {$multi=0.1;}
		if ($digit==0) {$multi=1;}

		return $multi;
}
?>