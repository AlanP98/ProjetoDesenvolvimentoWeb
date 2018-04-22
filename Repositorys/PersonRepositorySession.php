<?php

session_start();
require_once DIR . 'Repositorys/IRepository.php';

class PersonRepositorySession implements IRepository {
	private $persons;

	public function __construct() {
		$this->loadData();
	}

	private function loadData() {
		if (isset($_SESSION['persons'])) {
			$this->persons = unserialize($_SESSION['persons']);
		} else {
			$this->persons = array();
		}
	}

	public function add($person) {
		$this->persons[] = $person;
		$this->persistenceSave();
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
		return $this->persons;
	}


	private function persistenceSave() {
		$_SESSION['persons'] = serialize($this->persons);
	}

}