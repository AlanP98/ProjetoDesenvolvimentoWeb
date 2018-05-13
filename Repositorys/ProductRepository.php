<?php

require_once '../config.php';
require_once DIR . 'Repositorys/IRepository.php';

class ProductRepository implements IRepository {
	private $conn;

	public function __construct() {
		$this->conn = MySqlConnection::getConnection(DSN, USER, PASSWORD);
	}

	public function add($product) {
		return insertQuery($product, $this->conn::$connection);
	}

	public function update($product) {
		$description = $product->getDescription();
		$recordNumber = $product->getRecordNumber();

		$query = 'UPDATE product SET description = ? WHERE recordNumber = ?';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->bindParam(1, $description, PDO::PARAM_STR);
		$stmt->bindParam(2, $recordNumber, PDO::PARAM_INT);
		return $stmt->execute();
	}

	public function delete($productId) {
		$query = 'DELETE FROM product WHERE id = ?';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->bindParam(1, $productId, PDO::PARAM_INT);
		return $stmt->execute();
	}

	public function batchDelete($ids) {
		if (!is_array($ids)) {
			return false;
		}

		$query = 'DELETE FROM product WHERE id IN (' . implode(',', $ids) . ')';
		$stmt = $this->conn::$connection->prepare($query);
		return $stmt->execute();
	}

	public function getById(int $id) {
		$query = 'SELECT * FROM product WHERE id = ?';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}

	public function getByFilters($filters) {
		$query = 'SELECT * FROM product WHERE description LIKE ? ';

		$binds = array(
			array('%' . $filters['description'] . '%', PDO::PARAM_STR)
		);

		if (!empty($filters['recordNumber'])) {
			$query .= 'AND recordNumber = ? ';
			$binds[] = array($filters['recordNumber'], PDO::PARAM_INT);
		}

		$stmt = $this->conn::$connection->prepare($query);

		foreach($binds as $i => $bind) {
			$stmt->bindParam(($i + 1), $bind[0], $bind[1]);
		}

		$stmt->execute();
		$res = $stmt->fetchAll();
		return $res;
	}

	public function getAll() {
		$query = 'SELECT * FROM product';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll();
	}

}