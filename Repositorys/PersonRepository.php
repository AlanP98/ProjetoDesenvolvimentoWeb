<?php

require_once '../config.php';
require_once DIR . 'Repositorys/IRepository.php';

class PersonRepository implements IRepository {
	private $conn;

	public function __construct() {
		$this->conn = MySqlConnection::getConnection(DSN, USER, PASSWORD);
	}

	public function add($person) {
		return $this->conn::insertQuery($person);
	}

	public function update($person) {
		return $this->conn::updateQuery($person);
	}

	public function delete($id) {
		$query = 'DELETE FROM person WHERE id = ?';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		return $stmt->execute();
	}

	public function batchDelete($ids) {
		if (!is_array($ids)) {
			return false;
		}

		$query = 'DELETE FROM person WHERE id IN (' . implode(',', $ids) . ')';
		$stmt = $this->conn::$connection->prepare($query);
		return $stmt->execute();
	}

	public function deletePersonUser($personId) {
		if (empty($personId)) {
			return false;
		}

		$query = 'DELETE FROM user WHERE id = (SELECT idUser FROM person WHERE id = ?)';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->bindParam(1, $personId, PDO::PARAM_INT);
		return $stmt->execute();
	}

	public function getById(int $id) {
		$query = 'SELECT * FROM person WHERE id = ?';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}

	public function getByFilters(Array $filters) {
		$query = 'SELECT * FROM person WHERE name LIKE ? ';

		$binds = array(
			array('%' . $filters['name'] . '%', PDO::PARAM_STR)
		);

		if (!empty($filters['filterId'])) {
			$query .= 'AND id LIKE ? ';
			$binds[] = array('%' . $filters['filterId'] . '%', PDO::PARAM_INT);
		}

		if (!empty($filters['gender'])) {
			$query .= 'AND gender = ? ';
			$binds[] = array($filters['gender'], PDO::PARAM_STR);
		}

		$idConnectedUser = (Session::getInstance()->getByKey('AUTHENTICATION'))->getIdUser();
		$query .= 'AND (idUser IS NULL OR idUser <> ?) ';
		$binds[] = array($idConnectedUser, PDO::PARAM_INT);

		$stmt = $this->conn::$connection->prepare($query);

		foreach($binds as $i => $bind) {
			$stmt->bindParam(($i + 1), $bind[0], $bind[1]);
		}

		$stmt->execute();
		$res = $stmt->fetchAll();
		return $res;
	}

	public function getAll() {
		$query = 'SELECT * FROM person';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll();
	}

}