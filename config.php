<?php

define('DIR', dirname(__FILE__) . '/');
define('DSN', 'mysql:dbname=projeto_desenvolvimento_web;host=127.0.0.1');
define('USER', 'root');
define('PASSWORD', '');

require_once DIR . 'Utils/utils.php';
require_once DIR . 'Classes/MySqlConnection.php';
require_once DIR . 'Classes/Authenticator.php';
require_once DIR . 'Classes/Session.php';
include_once DIR . 'Utils/FirePHPCore/fb.php';

ob_start();
Session::getInstance();

try {
	MySqlConnection::getConnection(DSN, USER, PASSWORD);
} catch(Exception $e) {
	exit('Não foi possível conectar-se à base de dados.');
}

function isLogged() {
	return Authenticator::isLogged();
}

function requireLogin() {
	// $auth = Session::getInstance()->getByKey('AUTHENTICATION');
	//TODO: validar tempo de sessão - permitir até 30 min sem atividade

	if (!isLogged()) {
		Authenticator::logout();
	}
}