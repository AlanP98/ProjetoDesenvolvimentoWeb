<?php

require_once '../config.php';
require_once DIR . 'Repositorys/ProductRepository.php';

requireLogin();

$module = new Module('excluir produtos', 2);
$result = Authenticator::verifyPermission($module);
if ($result !== true) {
	echo json_encode($result);
	exit;
}

try {
	$method = $_SERVER['REQUEST_METHOD'];
	if ($method === 'DELETE') {
		parse_str(file_get_contents('php://input'), $_DELETE);

		if (isset($_DELETE['ids']) && !empty($_DELETE['ids'])) {
			$productRepository = new ProductRepository();
			echo json_encode($productRepository->batchDelete($_DELETE['ids']));
		} else {
			echo json_encode(new ErrorObj(400, 'Nenhum produto foi selecionado.'));
		}
	} else {
		echo json_encode(new ErrorObj(400, 'DELETE requerido através do método incorreto: "' . $method . '"'));
	}
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}