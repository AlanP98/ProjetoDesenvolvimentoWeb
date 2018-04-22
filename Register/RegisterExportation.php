<?php

require_once '../config.php';
require_once DIR . 'Factorys/Exporter/ExporterFactoryProvider.php';

if (isset($_GET['exporterType']) && isset($_GET['object'])) {
	echo nl2br(callExport());
} else {
	throw new Exception('Exportador e/ou objeto não definido.');
}

function callExport() {
	switch($_GET['object']) {
		case 'Person':
			require_once DIR . 'Classes/Person.php';
			require_once DIR . 'Repositorys/PersonRepositorySession.php';
			$obj = new PersonRepositorySession();
			break;

		case 'Product':
			require_once DIR . 'Classes/Product.php';
			require_once DIR . 'Repositorys/ProductRepositorySession.php';
			$obj = new ProductRepositorySession();
			break;
	}

	$factory = new ExporterFactoryProvider();
	$exportadorFactory = $factory->create($_GET['exporterType']);
	$method = 'createExporter' . $_GET['object'];
	$exporter = $exportadorFactory->$method();
	$data = $obj->getAll();

	return $exporter->serializeObj($data);
}