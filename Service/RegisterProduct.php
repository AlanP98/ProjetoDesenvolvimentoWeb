<?php

require_once '../config.php';
require_once DIR . 'Classes/Product.php';
require_once DIR . 'Repositorys/ProductRepository.php';

requireLogin();

$module = new Module('cadastrar produtos', 1);
$result = Authenticator::verifyPermission($module);
if ($result !== true) {
	echo json_encode($result);
	exit;
}

try {
	$result = registerProduct();
	echo json_encode($result);
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}


function registerProduct() {
	$productId = (isset($_POST['productId']) ? (empty($_POST['productId']) ? 0 : $_POST['productId']) : 0);
	$recordNumber = (isset($_POST['recordNumber']) ? $_POST['recordNumber'] : '');
	$description = (isset($_POST['description']) ? $_POST['description'] : '');

	if (!empty($recordNumber) && !empty($description)) {
		if (!isValidRecordNumber($recordNumber)) {
			return new ErrorObj(400, 'Número de registro inválido.', '');
		}

		$product = new Product($recordNumber, $description, $productId);
		$productRepository = new ProductRepository();

		$result = false;
		if (empty($productId)) {
			$result = $productRepository->add($product);
		} else {
			$result = $productRepository->update($product);
		}

		return (int) $result;
	}

	return new ErrorObj(400, 'Preencha todos os campos', '');
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