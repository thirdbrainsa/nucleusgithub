<script>
storage.clear();
</script>

<?php
session_start();
session_regenerate_id();
session_destroy();
include("config.php");
include("connect_db.php");
$ip=$_SERVER['REMOTE_ADDR'];
@mysql_query("delete from temp_login where ip='".$ip."'");
include("end_db.php");
header("location:index.php");
?>