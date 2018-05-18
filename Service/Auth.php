<?php

require_once '../config.php';
require_once DIR . 'Classes/Authenticator.php';

if (isset($_POST['userName']) && isset($_POST['password'])) {
	$auth = new Authenticator();
	$response = $auth->authenticate($_POST['userName'], $_POST['password']);

	if ($response instanceof ErrorObj) {
		echo json_encode((array) $response);
	} else {
		echo json_encode(array('success' => 1, 'accessLevel' => $response->getPermissions()));
	}
} else {
	$response = new ErrorObj(401, 'Usuário ou senha inválidos.', '');
	echo json_encode((array) $response);
}