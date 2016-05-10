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
    header('Location: register-fra.php');
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
    'content' => $m->render('confirm-fra', $data)
));