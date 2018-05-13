<?php

require_once '../config.php';
require_once DIR . 'Factorys/Exporter/ExporterFactoryProvider.php';

requireLogin();

try {
	if (isset($_GET['exporterType']) && isset($_GET['object'])) {
		echo nl2br(callExport());
	} else {
		throw new Exception('Tipo de exportador ou objeto não definido.');
	}
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}

function callExport() {
	switch($_GET['object']) {
		case 'Person':
			require_once DIR . 'Classes/Person.php';
			require_once DIR . 'Repositorys/PersonRepository.php';
			$obj = new PersonRepository();
			break;

		case 'Product':
			require_once DIR . 'Classes/Product.php';
			require_once DIR . 'Repositorys/ProductRepository.php';
			$obj = new ProductRepository();
			break;
	}

	$factory = new ExporterFactoryProvider();
	$exportadorFactory = $factory->create($_GET['exporterType']);
	$method = 'createExporter' . $_GET['object'];
	$exporter = $exportadorFactory->$method();
	$data = $obj->getAll();

	return $exporter->serializeObj($data);
}