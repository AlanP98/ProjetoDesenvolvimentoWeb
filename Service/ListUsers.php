<?php

require_once '../config.php';
require_once DIR . 'Repositorys/UserRepository.php';

requireLogin();

// try {
// 	$userRepository = new UserRepository();
// 	$users = $userRepository->getAll();
// 	echo json_encode($users);
// } catch(Exception $e) {
// 	http_response_code(400);
// 	echo $e->getMessage();
// }

try {
	$filters = array(
		'id' => (isset($_GET['id']) ? $_GET['id'] : 0),
		'name' => (isset($_GET['name']) ? $_GET['name'] : ''),
		'userName' => (isset($_GET['userName']) ? $_GET['userName'] : ''),
		'accessLevel' => (isset($_GET['accessLevel']) ? $_GET['accessLevel'] : array())
	);

	$userRepository = new UserRepository();
	if (!empty($filters['id'])) {
		$users = $userRepository->getPersonDataByUserId($filters['id']);
	} else {
		$users = $userRepository->getByFilters($filters);
	}
	fb($users);
	echo json_encode($users);
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}