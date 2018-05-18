<?php

require_once '../config.php';
require_once DIR . 'Classes/Product.php';
require_once DIR . 'Repositorys/ProductRepository.php';

Authenticator::requireLogin();

try {
	$filters = array(
		'id' => (isset($_GET['id']) ? $_GET['id'] : ''),
		'description' => (isset($_GET['description']) ? $_GET['description'] : ''),
		'recordNumber' => (isset($_GET['recordNumber']) ? $_GET['recordNumber'] : '')
	);

	$productRepository = new ProductRepository();
	if (!empty($filters['id'])) {
		$persons = $productRepository->getById($filters['id']);
	} else {
		$persons = $productRepository->getByFilters($filters);
	}

	echo json_encode($persons);
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}