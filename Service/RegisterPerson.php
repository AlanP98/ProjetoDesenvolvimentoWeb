<?php

require_once '../config.php';
require_once DIR . 'Classes/Person.php';
require_once DIR . 'Repositorys/PersonRepository.php';

try {
	if (isset($_POST['recordNumber']) && isset($_POST['name']) && isset($_POST['gender'])) {
		if (!empty($_POST['recordNumber']) && !empty($_POST['name']) && !empty($_POST['gender'])) {
			$personRepository = new PersonRepository();
			$person = new Person($_POST['recordNumber'], $_POST['name'], $_POST['gender']);
			echo json_encode($personRepository->add($person));
		}
	} else {
		throw new Exception('Preencha todos os campos.');
	}
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}
