<?php

require_once DIR . 'Factorys/Exporter/IExporterProvider.php';
require_once DIR . 'Factorys/Exporter/ExporterPerson.php';
require_once DIR . 'Factorys/Exporter/ExporterPersonCsv.php';
require_once DIR . 'Factorys/Exporter/ExporterProduct.php';
require_once DIR . 'Factorys/Exporter/ExporterProductCsv.php';

class ExporterCsvProvider implements IExporterProvider {

	public function createExporterPerson() : ExporterPerson {
		return new ExporterPersonCsv();
	}

	public function createExporterProduct() : ExporterProduct {
		return new ExporterProductCsv();
	}

}