<?php

require_once DIR . 'Factorys/Exporter/ExporterProduct.php';

class ExporterProductJson extends ExporterProduct {

	public function serializeObj(&$data) : string {
		$products = array();

		foreach($data as $p) {
			$product = new Product($p['recordNumber'], $p['description'], $p['id']);
			$aProduct = $product->getAttributes();
			unset($aProduct['id']);
			$products[] = $aProduct;
		}

		return json_encode($products, JSON_PRETTY_PRINT);
	}
}