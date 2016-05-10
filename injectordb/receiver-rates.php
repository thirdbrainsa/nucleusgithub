<?php

/// LIST OF FUNCTION USED BY RECEIVER-RATES.PHP
function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
       } 
     } 
     reset($objects); 
     rmdir($dir); 
   } 
} 


///
// FX RATES INSIDE XOPENHUB PRODUCT.
$_Currency= ["CZKCASH","HUNComp","W20","FRA40","ITA40","RUS50","SPA35","SUI20","UK100","AUS200","CHNComp","HKComp","INDIA50","JAP225","KOSP200","BRAComp","MEXComp","US100","US2000","US30","US500","VOLX","AUDNZD","AUDJPY","EURNZD","GBPCAD","CHFJPY","EURAUD","GBPAUD","NZDJPY","NZDCAD","USDSEK","EURNOK","GBPNZD","AUDCAD","EURCAD","CADJPY","CADCHF","USDNOK","AUDCHF","EURSEK","GBPUSD","AUDUSD","EURCHF","USDJPY","EURJPY","NZDUSD","USDCHF","GBPCHF","GBPJPY","USDCAD","EURGBP","EURUSD","EURCZK","USDMXN","USDTRY","USDPLN","USDCZK","GBPPLN","EURRON","USDZAR","CHFHUF","EURHUF","USDRON","USDHUF","EURPLN","USDCLP","CHFPLN","EURTRY"];
//print_r ($_GET);
// Receive all $_GET
//echo"<li>OK";
// Configuration of the Matrix Receiver.
$_maximum_tick=60; // deep of history. Multiply this by $_rate_of_history to get the whole history kept in server, here 60  ticks x (60  x 1000 ) ms = 3600 seconds ) 1 hour
$_path_matrix_config="rates/";
$_rate_of_history=60*1000; // in milliseconds (delay between 2 history insert).- here 2min, history will take then 60 x this delay = 2 hours now.
$_total=count($_Currency);

//print_r($last_value);
for ($i=0;$i<$_total;$i++)

{
	$keyAsk="Ask_".$_Currency[$i];
	$keyBid="Bid_".$_Currency[$i];
	$keyTm="tm_".$_Currency[$i];
	
	
	$value_ask=trim($_GET[$keyAsk]);
	$value_bid=trim($_GET[$keyBid]);
	$value_tm=trim($_GET[$keyTm]);
	
	//
	$value_ask=floatval($value_ask);
	$value_bid=floatval($value_bid);
	if (($value_ask!=0) && ($value_bid!=0))
	{
	//$value_tm=intval($value_tm);
	
	$value_ask=round($value_ask,5);
	$value_bid=round($value_bid,5);
	//
	$write_history=FALSE;
	//
	if (file_exists($_path_matrix_config.$_Currency[$i]."/timestamp.txt"))
	{
		$time=time();
		$last_timestamp=file_get_contents($_path_matrix_config.$_Currency[$i]."/timestamp.txt");

	
		if (($value_tm-$last_timestamp)>$_rate_of_history)
			{
			$write_history=TRUE; // we add one tick in history
				$file=@fopen($_path_matrix_config.$_Currency[$i]."/timestamp.txt","w");
				fputs($file,$value_tm);
				fclose($file);
			}
			else
			{
			
			$write_history=FALSE;
			
			}
	
	}
	else
	{
	$file=@fopen($_path_matrix_config.$_Currency[$i]."/timestamp.txt","w");
	fputs($file,$value_tm);
	fclose($file);
	
	// 
	$write_history=FALSE; // creation of the history
	
	}
	
	if ($write_history)
	{
	
	if (file_exists($_path_matrix_config.$_Currency[$i]."/MAX/value.txt"))
	{
		$value=file_get_contents($_path_matrix_config.$_Currency[$i]."/MAX/value.txt");
		
		if (floatval($value)<floatval($value_ask))
			{
				$file=@fopen($_path_matrix_config.$_Currency[$i]."/MAX/value.txt","w");
				fputs($file,$value_ask);
				fclose($file);
		
			}
			
	}
	else
	
	{
	
		@mkdir($_path_matrix_config.$_Currency[$i]."/MAX");
		$file=@fopen($_path_matrix_config.$_Currency[$i]."/MAX/value.txt","w");
		fputs($file,$value_ask);
		fclose($file);
	}
	
	if (file_exists($_path_matrix_config.$_Currency[$i]."/MIN/value.txt"))
	{
	
		$value=file_get_contents($_path_matrix_config.$_Currency[$i]."/MIN/value.txt");
		
		if (floatval($value)>floatval($value_bid))
			{
				$file=@fopen($_path_matrix_config.$_Currency[$i]."/MIN/value.txt","w");
				fputs($file,$value_bid);
				fclose($file);
		
			}
	}
	else
	
	{
	
		@mkdir($_path_matrix_config.$_Currency[$i]."/MIN");
		$file=@fopen($_path_matrix_config.$_Currency[$i]."/MIN/value.txt","w");
		fputs($file,$value_bid);
		fclose($file);
	}
	//
	//
	}
	
	if (file_exists($_path_matrix_config.$_Currency[$i]."/ASK/value.txt"))
	
	{
	//echo "<li>".$_Currency[$i];
	$file=@fopen($_path_matrix_config.$_Currency[$i]."/ASK/value.txt","w");
	fputs($file,$value_ask);
	fclose($file);
	
	$file=@fopen($_path_matrix_config.$_Currency[$i]."/BID/value.txt","w");
	fputs($file,$value_bid);
	fclose($file);
	
	
	// STORAGE MANAGEMENT WITH MAX OF TICKS //
	// AUTODELETE THE FOLDER WITH OLD FOLDER//
        if ($write_history)
	
	{
	
	$scanD=scandir($_path_matrix_config.$_Currency[$i]."/HISTORY");
	$nb_folder=count($scanD)-1;
	
	if ($nb_folder>=$_maximum_tick)
		{
		echo"<li>".$nb_folder;
		$where_folder=$_path_matrix_config.$_Currency[$i]."/HISTORY/TICK*";
		//cho "<li>".$where_folder;
		$list_of_tick_folders=glob($where_folder);
		// SORT BY CREATION TIME - DELETE THE OLDEST ONE AFTER $_MAXIMUM_TICK TICKS
		usort($list_of_tick_folders, create_function('$a,$b', 'return filemtime($a) - filemtime($b);'));
		$oldest_folder=$list_of_tick_folders[0];		
		rrmdir ($oldest_folder);
		//print_r($list_of_tick_folders);
		//
		$nb_folder_new=str_replace("rates/".$_Currency[$i]."/HISTORY/TICK","",$oldest_folder);
		//
		
		$newfolder="TICK".$nb_folder_new;	
	//echo"<li> Change to ".$newfolder;
	
	//echo"<br>";
		}

	else
	
	{
	
	
	$newfolder="TICK".$nb_folder;
	
	}
	}
	//echo"<li>".$newfolder;
	
	if ($write_history)
	{
	//echo"<li> >".$newfolder;
	
	mkdir($_path_matrix_config.$_Currency[$i]."/HISTORY/".$newfolder);
	@mkdir($_path_matrix_config.$_Currency[$i]."/HISTORY/".$newfolder."/ASK");
	@mkdir($_path_matrix_config.$_Currency[$i]."/HISTORY/".$newfolder."/BID");
	
	$file=@fopen($_path_matrix_config.$_Currency[$i]."/HISTORY/".$newfolder."/ASK/value.txt","w");
	fputs($file,$value_ask);
	fclose($file);
	
	$file=@fopen($_path_matrix_config.$_Currency[$i]."/HISTORY/".$newfolder."/BID/value.txt","w");
	fputs($file,$value_bid);
	fclose($file);
	
	$file=@fopen($_path_matrix_config.$_Currency[$i]."/HISTORY/".$newfolder."/timestamp.txt","w");
	fputs($file,$value_tm);
	fclose($file);
	}
	
	//
	}
	else
	
	{
	@mkdir($_path_matrix_config.$_Currency[$i]);
	@mkdir($_path_matrix_config.$_Currency[$i]."/ASK");
	@mkdir($_path_matrix_config.$_Currency[$i]."/BID");
	@mkdir($_path_matrix_config.$_Currency[$i]."/HISTORY");
	
	$file=@fopen($_path_matrix_config.$_Currency[$i]."/ASK/value.txt","w");
	fputs($file,$value_ask);
	fclose($file);
	$file=@fopen($_path_matrix_config.$_Currency[$i]."/BID/value.txt","w");
	fputs($file,$value_bid);
	fclose($file);
	}
	}
}



?>