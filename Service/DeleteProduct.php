<?php

require_once '../config.php';
require_once DIR . 'Repositorys/ProductRepository.php';

try {
	$method = $_SERVER['REQUEST_METHOD'];
	if ($method === 'DELETE') {
		parse_str(file_get_contents('php://input'), $_DELETE);

		if (isset($_DELETE['ids']) && !empty($_DELETE['ids'])) {
			$productRepository = new ProductRepository();
			echo json_encode($productRepository->batchDelete($_DELETE['ids']));
		} else {
			throw new Exception('Nenhum produto foi selecionado.');
		}
	} else {
		throw new Exception('DELETE requerido através do método incorreto: "' . $method . '"');
	}
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}