<?php

session_start();
require_once DIR . 'Repositorys/IRepository.php';

class ProductRepositorySession implements IRepository {
	private $products;

	public function __construct() {
		$this->loadData();
	}

	private function loadData() {
		if (isset($_SESSION['products'])) {
			$this->products = unserialize($_SESSION['products']);
		} else {
			$this->products = array();
		}
	}

	public function add($product) {
		$this->products[] = $product;
		$this->persistenceSave();
	}

	public function update($product) {

	}

	public function delete($product) {

	}

	public function getById(int $id) {
		foreach ($this->products as $product) {
			if ($product->getRecordNumber() == $id) {
				return $product;
			}
		}

		return null;
	}

	public function getAll() {
		return $this->products;
	}

	private function persistenceSave() {
		$_SESSION['products'] = serialize($this->products);
	}

}