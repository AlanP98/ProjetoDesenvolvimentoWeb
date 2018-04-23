<?php

require_once '../config.php';
require_once DIR . 'Classes/Product.php';
require_once DIR . 'Repositorys/ProductRepository.php';

try {
	$productRepository = new ProductRepository();
	$products = $productRepository->getAll();
	echo json_encode($products);
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}