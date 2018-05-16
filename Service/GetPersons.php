<?php

require_once '../config.php';
require_once DIR . 'Repositorys/PersonRepository.php';

requireLogin();

try {
	$filters = array(
		'id' => (isset($_GET['id']) ? $_GET['id'] : ''),
		'name' => (isset($_GET['name']) ? $_GET['name'] : ''),
		'filterId' => (isset($_GET['filterId']) ? $_GET['filterId'] : ''),
		'gender' => (isset($_GET['gender']) ? $_GET['gender'] : '')
	);

	$personRepository = new PersonRepository();
	if (!empty($filters['id'])) {
		$persons = $personRepository->getById($filters['id']);
	} else {
		$persons = $personRepository->getByFilters($filters);
	}

	echo json_encode($persons);
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}