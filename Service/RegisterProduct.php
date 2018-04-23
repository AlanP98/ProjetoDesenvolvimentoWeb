<?php

require_once '../config.php';
require_once DIR . 'Classes/Product.php';
require_once DIR . 'Repositorys/ProductRepository.php';

try {
	if (isset($_POST['recordNumber']) && isset($_POST['description'])) {
		if (!empty($_POST['recordNumber']) && !empty($_POST['description'])) {
			$productRepository = new ProductRepository();
			$product = new Product($_POST['recordNumber'], $_POST['description']);
			echo $productRepository->add($product);
		}
	} else {
		throw new Exception('Preencha todos os campos.');
	}
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}
