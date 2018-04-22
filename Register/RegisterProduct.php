<?php

require_once '../config.php';
require_once DIR . 'Classes/Product.php';
require_once DIR . 'Repositorys/ProductRepository.php';

echo register();

function register() {
	try {
		if (isset($_POST['recordNumber']) && isset($_POST['description'])) {
			if (!empty($_POST['recordNumber']) && !empty($_POST['description'])) {
				$productRepository = new ProductRepository();
				$product = new Product($_POST['recordNumber'], $_POST['description']);
				return $productRepository->add($product);
			}
		}

		throw new Exception('Preencha todos os campos.');
	} catch(Exception $e) {
		return json_encode(array(
			'error' => true,
			'msg' => $e->getMessage()
		));
	}
}