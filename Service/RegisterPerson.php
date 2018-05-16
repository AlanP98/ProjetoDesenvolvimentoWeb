<?php

require_once '../config.php';
require_once DIR . 'Classes/Person.php';
require_once DIR . 'Repositorys/PersonRepository.php';

requireLogin();

try {
	echo json_encode(registerPerson());
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}

function registerPerson() {
	$personId = (isset($_POST['personId']) && !empty($_POST['personId']) ? $_POST['personId'] : null);
	$name = (isset($_POST['name']) ? $_POST['name'] : '');
	$gender = (isset($_POST['gender']) ? $_POST['gender'] : '');
	$email = (isset($_POST['email']) ? $_POST['email'] : '');

	if (!empty($name) && !empty($gender)) {
		$person = new Person($personId, $name, $gender, $email);
		$personRepository = new PersonRepository();

		$result = false;
		if (empty($personId)) {
			$result = $personRepository->add($person);
		} else {
			$result = $personRepository->update($person);
		}

		return json_encode($result);
	}

	return new ErrorObj(400, 'Preencha todos os campos.');
}
