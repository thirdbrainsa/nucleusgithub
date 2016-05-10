<?php

// setup autoloading
require_once('vendor/autoload.php');

$config = require('config.php');

$method = $_SERVER['REQUEST_METHOD'];

require_once('templater.php');

$m = templater();

if($method == 'POST') {
    $server = isset($_POST['server'])?$_POST['server']:'demo';

    if($server != 'demo' && $server != 'live')
        $server = 'demo';

    require_once('xmanager.php');

    $xmanager = new XManager($config['servers'][$server]);

    if($xmanager->register($_POST, $server, $config['account'][$server]['leverage'], $config['account'][$server]['deposit'])) {
        header('Location: confirm-fra.php');
        exit();
    } else {
        echo $m->render('layout', array(
            'content' => $m->render('index-fra', array(
                'account_type' => $server,
                'account_type_upper' => strtoupper($server),
                'groups' => $config['groups'][$server],
                'error' => $xmanager->lastError(),
                'fields' => $config['fields'],
                'required' => $config['required'],
                'defaults' => $_POST
            ))
        ));
    }
} else {
    // setup utilities
    $account_type = isset($_GET['server'])?$_GET['server']:'demo';

    if($account_type != 'demo' && $account_type != 'live')
        $account_type = 'demo';
    
    echo $m->render('layout', array(
        'content' => $m->render('index-fra', array(
            'account_type' => $account_type,
            'account_type_upper' => strtoupper($account_type),
            'groups' => $config['groups'][$account_type],
            'fields' => $config['fields'],
            'required' => $config['required'],
            'defaults' => array()
        ))
    ));
}