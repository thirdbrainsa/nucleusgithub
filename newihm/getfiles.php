<?php
$file=file_get_contents("http://unbouncepages.com/nucleus-explanation/");
echo $file;
$filex=fopen("nucleus-explanation.html","w");
fputs($filex,$file);
fclose($filex);
?>