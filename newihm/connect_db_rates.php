<?php
	
	$mysql=mysql_connect($dburl_rates, $dblogin_rates,$dbpass_rates);
	mysql_select_db($dbbase_rates);
	echo mysql_error();
?>