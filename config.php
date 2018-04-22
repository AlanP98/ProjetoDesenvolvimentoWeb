<?php

define('DIR', dirname(__FILE__) . '/');

require_once DIR . 'Utils/MySqlConnection.php';
require_once DIR . 'Utils/utils.php';

$connection = null;

try {
	if (is_null($connection)) {
		$connection = new MySqlConnection('mysql:dbname=projeto_desenvolvimento_web;host=127.0.0.1', 'root', '');
	}
} catch(Exception $e) {
	exit('Não foi possível conectar-se à base de dados.');
}

//$con->close();
// var_dump($connection);

function autoload($classPath) {
	require_once(DIR . $classPath . '.php');
 }

 spl_autoload_register('autoload');