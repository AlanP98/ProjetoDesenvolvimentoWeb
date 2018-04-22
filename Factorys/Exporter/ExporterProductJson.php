<?php

require_once DIR . 'Factorys/Exporter/ExporterProduct.php';

class ExporterProductJson extends ExporterProduct {

	public function serializeObj(&$data) : string {
		$products = array();

		foreach($data as $person) {
			$products[] = $person->getAttributes();
		}

		return json_encode($products, true);
	}
}