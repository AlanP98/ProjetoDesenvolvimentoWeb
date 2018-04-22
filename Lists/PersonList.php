<?php

require_once '../config.php';
require_once DIR . 'Classes/Person.php';
require_once DIR . 'Repositorys/PersonRepositorySession.php';

echo listing();

function listing() {
	try {
		$personRepository = new PersonRepositorySession();
		$persons = $personRepository->getAll();

		$return = array();
		foreach($persons as $person) {
			$return[] = $person->getAttributes();
		}

		return json_encode($return);
	} catch(Exception $e) {
		return json_encode(array(
			'error' => true,
			'msg' => $e->getMessage()
		));
	}
}