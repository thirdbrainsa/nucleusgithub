<?php
require ("config.php");
require ("connect_db_drupal.php");
require ("librairies/manage.php");
$time=time();
$title="CLKLCKLCKLKLKNEW";$body="NEW STUFF";
$SQL="insert into node_revision values('','','','','','".$time."','1','','','' )";
$r=mysql_query($SQL,$mysql);
echo mysql_error();
$id_nx=mysql_insert_id();



$SQL="insert into node values ('','".$id_nx."','blog','eng','".$title."','1','1','".$time."','".$time."','0','1','0','0','0')";
$r=mysql_query($SQL,$mysql);
echo mysql_error();
$id_n=mysql_insert_id();

echo "<li>".$id_n;
$SQL="insert into field_data_body values ('node','blog','0','".$id_n."','".$id_nx."','und','0','".$body."','','filtered_html')";
$r=mysql_query($SQL,$mysql);
echo mysql_error();
$id_n=mysql_insert_id();

$SQL="update node_revision set nid='".$id_n."', title='".$title."' where vid='".$id_nx."'";
mysql_query($SQL);

require ("end_db.php");
?>