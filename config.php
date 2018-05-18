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
	$msg = '<div class="p-5 text-center text-white bg-danger"><p style="font-size:25px;"><strong>Não foi possível conectar-se à base de dados.</strong></p><p class="mt-5">Verifique se a base de dados foi criada. Para criá-la execute o SQL em "' . DIR . 'Utils/DBDefinitions.sql"</p><p>As configurações de acesso à base de dados podem ser alteradas no arquivo config.php</p></div>';
	http_response_code(403);
	exit($msg);
}