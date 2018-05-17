<?php

require_once DIR . 'Repositorys/IRepository.php';

class UserRepository implements IRepository {
	private $conn;

	public function __construct() {
		$this->conn = MySqlConnection::getConnection(DSN, USER, PASSWORD);
	}

	public function add($user) {
		return $this->conn::insertQuery($user);
	}

	public function update($user) {
		return $this->conn::updateQuery($user);
	}

	public function delete($id) {
		$query = 'DELETE FROM user WHERE id = ?';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		return $stmt->execute();
	}

	public function batchDelete($ids) {
		if (!is_array($ids)) {
			return false;
		}

		$query = 'DELETE FROM user WHERE id IN (' . implode(',', $ids) . ')';
		$stmt = $this->conn::$connection->prepare($query);
		return $stmt->execute();
	}

	public function getById(int $id) {
		$query = 'SELECT * FROM user WHERE id = ?';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}

	public function getByFilters(Array $filters) {
		$query = 'SELECT u.*, p.id as personId, p.name FROM user u ' .
			'LEFT JOIN person p ON p.idUser = u.id ' .
			'WHERE u.userName LIKE ? ';

		$binds = array(
			array('%' . $filters['userName'] . '%', PDO::PARAM_STR)
		);

		if (!empty($filters['name'])) {
			$query .= 'AND p.name LIKE ? ';
			$binds[] = array('%' . $filters['name'] . '%', PDO::PARAM_STR);
		}

		if (!empty($filters['accessLevel']) && is_array($filters['accessLevel'])) {
			$query .= 'AND u.accessLevel IN (' . implode(',', $filters['accessLevel']) . ') ';
		}

		$idConnectedUser = (Session::getInstance()->getByKey('AUTHENTICATION'))->getIdUser();
		$query .= 'AND u.id <> ? ';
		$binds[] = array($idConnectedUser, PDO::PARAM_INT);

		$stmt = $this->conn::$connection->prepare($query);

		foreach($binds as $i => $bind) {
			$stmt->bindParam(($i + 1), $bind[0], $bind[1]);
		}

		$stmt->execute();
		$res = $stmt->fetchAll();
		return $res;
	}

	public function getByUsername(String $userName) {
		$query = 'SELECT * FROM user WHERE userName = ?';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->bindParam(1, $userName, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch();
	}

	public function getPersonDataByIdUser(int $id) {
		$query = 'SELECT p.*, ' .
			'u.id as idUser, u.userName, u.accessLevel, u.password ' .
			'FROM person p ' .
			'LEFT JOIN user u ON u.id = p.idUser ' .
			'WHERE u.id = ?';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}

	public function getAll() {
		$query = 'SELECT * FROM user';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function getAdministratorsIds() {
		$query = 'SELECT id FROM user WHERE accessLevel = 2';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->execute();
		$rs = $stmt->fetchAll();
		return array_column($rs, 'id');
	}

	public function isAdministrator(int $id) {
		$query = 'SELECT accessLevel FROM user WHERE id = ?';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		$rs = $stmt->fetch(PDO::FETCH_ASSOC);
		return $rs['accessLevel'] == 2;
	}

}