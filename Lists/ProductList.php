<?php

require_once '../config.php';
require_once DIR . 'Classes/Product.php';
require_once DIR . 'Repositorys/ProductRepositorySession.php';

echo listing();

function listing() {
	try {
		$productRepository = new ProductRepositorySession();
		$products = $productRepository->getAll();

		$return = array();
		foreach($products as $product) {
			$return[] = $product->getAttributes();
		}

		return json_encode($return);
	} catch(Exception $e) {
		return json_encode(array(
			'error' => true,
			'msg' => $e->getMessage()
		));
	}
}