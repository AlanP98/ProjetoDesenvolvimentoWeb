<?php

session_start();
require_once DIR . 'Repositorys/IRepository.php';

class PersonRepository implements IRepository {
	private $persons;

	public function __construct() {
		// var_dump($_SESSION);
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
		echo 'PersonRepository add';
		$this->persons[] = $person;
		$this->persistenceSave();
	}

	public function update($person) {
		echo 'PersonRepository update';
	}

	public function delete($person) {
		echo 'PersonRepository delete';
	}

	public function getById(int $id) {
		echo 'PersonRepository getById';
		foreach ($this->persons as $person) {
			if ($person->getRecordNumber() == $id) {
				return $person;
			}
		}

		return null;
	}

	public function getAll() {
		//echo 'PersonRepository getAll';
		return $this->persons;
	}


	private function persistenceSave() {
		$_SESSION['persons'] = serialize($this->persons);
	}

}