<?php

return array(
    'servers' => array(
        'demo' => array(
            'host' => 'xm-demo.xopenhub.pro',
            'port' => 4444,
            'login' => 'Third Brain Demo',
            'password' => 'adsO42$'
        ),
        'live' => array(
            'host' => 'xm-real.xopenhub.pro',
            'port' => 4444, 
            'login' => 'Third Brain',
            'password' => 'xxxx'
        ),
    ),

    'account' => array(
        'demo' => array(
            'deposit' => 50000.0,
            'leverage' => '1:50'
        ),
        'live' => array(
            'deposit' => 0.0,
            'leverage' => '1:500'
        )
    ),

    'fields' => array(
        'email', 'phone'
    ),

    'required' => array(
        'email', 'phone'
    ),

    'email' => array(
        'method' => 'smtp', //'smtp' or 'mail'
        'host' => 'smtp.gmail.com',
        'port' => 465,
        'ssl' => true,
        'username' => 'support@thirdbrain.ch',
        'password' =>  'contactsa!2105',
        'sender' => array('support@thirdbrain.ch' => 'ThirdBrainFx Customer Care'),
        'subject' => 'Your account registration with ThirdBrainFx was done'
    ),

    'groups' => array(
        'demo' => array(
array(
                			'group' => 'ThirdbrainFXDepthGroupDemoUsd',
                			'name' => 'CLASSIC (FLOATING SPREAD)'
            		     ), 

            		array(
                			'group' => 'ThirdbrainFxDemoVariableG1',
                			'name' => 'NO SPREAD / NO SWAP'
            		     )
				

        ),
        'live' => array(
        
        )
    )
);
