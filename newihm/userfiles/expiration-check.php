<?php
$_dir="E://xampp//htdocs//frontofficeweb//userfiles";
$_expiration=21;
// expire.nucleus;
$files1 = scandir($_dir);
foreach ($files1 AS $key=>$value)
{
$what=$_dir."//".$value;
//@unlink($what."/expire.nucleus");
if (strlen($value)==6)
{
if (is_dir($what))
{
$time=filectime($what);
$delta=time()-$time;
$deltaJ=intval((time()-$time)/(3600*24)); 
echo"<li>".$value."-".$time."/".$deltaJ. " days";
if ($deltaJ>$_expiration)
{
echo " - EXPIRED !";
  $file=fopen($what."/expire.nucleus","w");
  fputs($file,"+");
  fclose($file);
  
echo" - STOPPED";
	$file=fopen($what."/stop.nucleus","w");
	fputs($file,"+");
	fclose($file);
}

$stop=file_get_contents($what."/".$value.".nucleus");
if ($stop=="")
{

echo" - STOPPED";
	$file=fopen($what."/stop.nucleus","w");
	fputs($file,"+");
	fclose($file);
}
else
{

 if (file_exists($what."/stop.nucleus"))
 {
   echo"<li>".$what."/stop.nucleus";
   echo" -- is already stopped ";
 }

}

}
}
else
{
if (strlen($value)>7)
{
$time=filectime($what);
$delta=time()-$time;
$deltaJ=intval((time()-$time)/(3600*24)); 
echo"<li>".$value."-".$time."/".$deltaJ. " days";
if ($deltaJ>1)
	{
	Echo"<li> We delete $what";
	shell_exec('rm -r -f  '.$what);
	
	}
}
}
}
?>