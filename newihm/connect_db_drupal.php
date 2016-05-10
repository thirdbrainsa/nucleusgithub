<?php
	echo"<li>".$dburl_drupal;
	$mysql=mysql_connect($dburl_drupal, $dblogin_drupal,$dbpass_drupal);
	echo mysql_error();
	mysql_select_db($dbbase_drupal);
	echo mysql_error();
?>