<?php

require_once '../config.php';
require_once DIR . 'Classes/Person.php';
require_once DIR . 'Repositorys/PersonRepository.php';

Authenticator::requireLogin();

try {
	$personRepository = new PersonRepository();
	$persons = $personRepository->getAll();
	echo json_encode($persons);
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}