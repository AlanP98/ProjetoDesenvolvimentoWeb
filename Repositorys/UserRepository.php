<?php

require_once DIR . 'Repositorys/IRepository.php';

class UserRepository implements IRepository {
	private $conn;

	public function __construct() {
		$this->conn = MySqlConnection::getConnection(DSN, USER, PASSWORD);
	}

	public function add($user) {
		return insertQuery($user, $this->conn::$connection);
	}

	public function update($user) {
		$id = $user->getUserName();
		$userName = $user->getUserName();
		$password = $user->getPassword();
		$accessLevel = $user->getAccessLevel();

		$query = 'UPDATE user SET userName = ?, password = ?, accessLevel = ? WHERE id = ?';
		$stmt = $this->conn::$connection->prepare($query);
		$stmt->bindParam(1, $userName, PDO::PARAM_STR);
		$stmt->bindParam(2, $password, PDO::PARAM_STR);
		$stmt->bindParam(3, $accessLevel, PDO::PARAM_INT);
		$stmt->bindParam(4, $id, PDO::PARAM_INT);
		return $stmt->execute();
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
		$query = 'SELECT u.*, p.id as idPerson, p.name FROM user u ' .
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

		$connectedUserId = (Session::getInstance()->getByKey('AUTHENTICATION'))->getUserId();
		$query .= 'AND u.id <> ? ';
		$binds[] = array($connectedUserId, PDO::PARAM_INT);

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

	public function getPersonDataByUserId(int $id) {
		$query = 'SELECT p.*, ' .
			'u.userName, u.accessLevel, u.password ' .
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

}