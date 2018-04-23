<?php

require_once '../config.php';
require_once DIR . 'Repositorys/IRepository.php';

class ProductRepository implements IRepository {
	private $conn;

	public function __construct() {
		$this->conn = MySqlConnection::getConnection();
	}

	public function add($product) {
		return insertQuery($product, $this->conn);
	}

	public function update($product) {

	}

	public function delete($product) { }

	public function batchDelete($ids) {
		if (!is_array($ids)) {
			return false;
		}

		$query = 'DELETE FROM product WHERE id IN (' . implode(',', $ids) . ')';
		$stmt = $this->conn->prepare($query);
		return $stmt->execute();
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
		$query = 'SELECT * FROM product';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll();
	}


	private function persistenceSave() {

	}

}