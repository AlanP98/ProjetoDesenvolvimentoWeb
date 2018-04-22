<?php

require_once '../config.php';
require_once DIR . 'Repositorys/IRepository.php';

class PersonRepository implements IRepository {
	private $conn;

	public function __construct() {
		$this->conn = MySqlConnection::getConnection();
	}

	public function add($person) {
		return insertQuery($person, $this->conn);
	}

	public function update($person) {

	}

	public function delete($person) {

	}

	public function getById(int $id) {
		foreach ($this->persons as $person) {
			if ($person->getRecordNumber() == $id) {
				return $person;
			}
		}

		return null;
	}

	public function getAll() {
		$query = 'SELECT * FROM person';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll();
	}


	private function persistenceSave() {

	}

}