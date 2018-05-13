<?php

require_once '../config.php';
require_once DIR . 'Classes/Product.php';
require_once DIR . 'Repositorys/ProductRepository.php';

requireLogin();
$response = registerProduct();
echo json_encode($response);

function registerProduct() {
	$productId = (isset($_POST['productId']) ? $_POST['productId'] : 0);
	$recordNumber = (isset($_POST['recordNumber']) ? $_POST['recordNumber'] : '');
	$description = (isset($_POST['description']) ? $_POST['description'] : '');

	if (!empty($recordNumber) && !empty($description)) {
		if (!isValidRecordNumber($recordNumber)) {
			return (array) new ErrorObj(400, 'Número de registro inválido.', '');
		}

		$product = new Product($recordNumber, $description);
		$productRepository = new ProductRepository();

		$result = false;
		if (empty($productId)) {
			$result = $productRepository->add($product);
		} else {
			$result = $productRepository->update($product);
		}

		return (int) $result;
	}

	return (array) new ErrorObj(400, 'Preencha todos os campos', '');
}

function isValidRecordNumber($recordNumber) {
	try {
		if (!is_numeric($recordNumber)) {
			return false;
		}

		if (mb_strlen($recordNumber) === 6) {
			$numbers = str_split($recordNumber);
			$sum = (array_sum($numbers) - $numbers[5]);
			$checker = ($sum % 9);
			$checker = ($checker !== 0 ? $checker : 9);
			return ($checker == $numbers[5]);
		} else {
			return false;
		}
	} catch (Exception $e) {
		return false;
	}
}