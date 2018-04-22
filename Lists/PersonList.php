<?php

require_once '../config.php';
require_once DIR . 'Classes/Person.php';
require_once DIR . 'Repositorys/PersonRepository.php';

echo listing();

function listing() {

	try {
		$personRepository = new PersonRepository();
		$persons = $personRepository->getAll();

		// $return = array();
		// foreach($persons as $person) {
		// 	$return[] = $person->getAttributes();
		// }

		return json_encode($persons);
	} catch(Exception $e) {
		return json_encode(array(
			'error' => true,
			'msg' => $e->getMessage()
		));
	}
}