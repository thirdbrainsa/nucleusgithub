<?php

require_once('templater.php');

class Mailer {
    public function __construct() {
        $config = require('config.php');
        if(!isset($config['email'])) {
            return;
        }

        $mail = $config['email'];

        if ($mail['method'] == 'smtp') {
            if ($mail['ssl'])
                $this->transport = Swift_SmtpTransport::newInstance($mail['host'], $mail['port'], 'ssl');
            else
                $this->transport = Swift_SmtpTransport::newInstance($mail['host'], $mail['port']);
            $this->transport->setUsername($mail['username'])->setPassword($mail['password']);
        } else {
            $this->transport = Swift_MailTransport::newInstance();
        }
        $this->mailer = Swift_Mailer::newInstance($this->transport);  

        return true;      
    }

    public function sendConfirmation($email, $name, $surname, $login, $password, $server) {
        $m = templater();

        $config = require('config.php');
        if(!isset($config['email'])) {
            return false;
        }

        $mail = $config['email'];


        $message = Swift_Message::newInstance($mail['subject'])
            ->setFrom($mail['sender'])
            ->setTo(array($email => "{$name} {$surname}"))
            ->setBody($m->render("email/{$server}", array(
                    'name' => $name,
                    'surname' => $surname,
                    'login' => $login,
                    'password' => $password
                )), 'text/html');

        $this->mailer->send($message);

        return true;
	}
	public function dailymail($email, $name, $login, $password, $result) {
        $m = templater();

        $config = require('config-report.php');
        if(!isset($config['email'])) {
            return false;
        }
	
	$mail['subject']="Your daily report from ThirdBrainFx for ".date('l jS \of F Y');
        
	$mail = $config['email'];


        $message = Swift_Message::newInstance($mail['subject'])
            ->setFrom($mail['sender'])
            ->setTo(array($email => "{$name} {$surname}"))
            ->setBody($m->render("email/daily", array(
                    'name' => $name,
                    'login' => $login,
		    'password'=>$password,
                    'result' => $result
                )), 'text/html');

        $this->mailer->send($message);

        return true;
	}
	public function sendalert($email, $name, $login, $password, $result) {
        $m = templater();

        $config = require('config-report.php');
        if(!isset($config['email'])) {
            return false;
        }
	
	$mail['subject']="Goal Alert ".date('l jS \of F Y');
        
	$mail = $config['email'];


        $message = Swift_Message::newInstance($mail['subject'])
            ->setFrom($mail['sender'])
            ->setTo(array($email => "{$name} {$surname}"))
            ->setBody($m->render("email/daily", array(
                    'name' => $name,
                    'login' => $login,
		    'password'=>$password,
                    'result' => $result
                )), 'text/html');

        $this->mailer->send($message);

        return true;
	
	
    }
}