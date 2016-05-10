<?php

$config = require('config.php');
require_once('xmanager_modified.php');
$server="demo";
$xmanager = new XManager($config['servers'][$server]);
 if($xmanager->addPosition($_POST, $server, $config['account'][$server]['leverage'])) 
 
 {
       
}
?>