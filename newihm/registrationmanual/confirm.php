<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56538817-3', 'auto');
  ga('send', 'pageview');

</script>
<?php

// autoloader
require_once 'vendor/autoload.php';

require_once('templater.php');

// setup
$m = templater();

$data = array(
    'name' => isset($_COOKIE['name'])?$_COOKIE['name']:'',
    'surname' => isset($_COOKIE['surname'])?$_COOKIE['surname']:'',
    'email' => isset($_COOKIE['email'])?$_COOKIE['email']:'',
    'login' => isset($_COOKIE['login'])?$_COOKIE['login']:'',
    'server' =>  isset($_COOKIE['server'])?strtoupper($_COOKIE['server']):'',
    'password' => isset($_COOKIE['password'])?$_COOKIE['password']:false
);

if(!isset($data['name']) || !$data['name']) {
    header('Location: register.php');
    exit();
}

// clear cookies
setcookie('name', '', time() - 3600);
setcookie('surname', '', time() - 3600);
setcookie('email', '', time() - 3600);
setcookie('login', '', time() - 3600);
setcookie('server', '', time() - 3600);
setcookie('password', '', time() - 3600);

echo $m->render('layout', array(
    'content' => $m->render('confirm', $data)
));