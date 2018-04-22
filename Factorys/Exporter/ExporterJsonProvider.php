<?php

require_once DIR . 'Factorys/Exporter/IExporterProvider.php';
require_once DIR . 'Factorys/Exporter/ExporterPerson.php';
require_once DIR . 'Factorys/Exporter/ExporterPersonJson.php';
require_once DIR . 'Factorys/Exporter/ExporterProduct.php';
require_once DIR . 'Factorys/Exporter/ExporterProductJson.php';

class ExporterJsonProvider implements IExporterProvider {

	public function createExporterPerson() : ExporterPerson {
		return new ExporterPersonJson();
	}

	public function createExporterProduct() : ExporterProduct {
		return new ExporterProductJson();
	}

}