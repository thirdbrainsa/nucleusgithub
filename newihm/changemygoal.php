<?php
session_start();
include("config.php");
include("connect_db.php");
$SQL="delete from nucleusrun where account='".$_SESSION['login']."'";
mysql_query($SQL);
include("end_db.php");
header("location:nucleus.php");
?>  