<?php
include("mailer.php");
if (isset($_GET['code']))
	{
		if (isset($_GET['code']!="98989kjikdsujnsdmnv£!jiwufijkefkwefjn"))
			{
			exit;
			
			}
			else
			{
			include("mailer");
			$mailer = new Mailer();
			$title=json_decode($_GET['title']);
			$body=json_decode($_GET['body']);
			$to=$_GET['email'];
			$name=$_GET['name'];
			$login=$_GET['login'];
			$password="";
			$mailer->sendalert($to,$name,$login,$password,$body);
			
			}
	
	}

?>