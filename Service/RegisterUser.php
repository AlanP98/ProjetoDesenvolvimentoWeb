<?php

require_once '../config.php';
require_once DIR . 'Classes/User.php';
require_once DIR . 'Classes/Person.php';
require_once DIR . 'Repositorys/UserRepository.php';
require_once DIR . 'Repositorys/PersonRepository.php';

requireLogin();

try {
	echo json_encode(registerUser());
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}

function registerUser() {
	fb($_POST);

	$personId = (isset($_POST['personId']) ? $_POST['personId'] : null);
	$userId = (isset($_POST['userId']) ? $_POST['userId'] : null);
	$recordNumber = (isset($_POST['recordNumber']) ? $_POST['recordNumber'] : '');
	$name = (isset($_POST['name']) ? $_POST['name'] : '');
	$gender = (isset($_POST['gender']) ? $_POST['gender'] : '');
	$email = (isset($_POST['email']) ? $_POST['email'] : '');
	$password = (isset($_POST['password']) ? $_POST['password'] : '');
	$accessLevel = (isset($_POST['accessLevel']) ? $_POST['accessLevel'] : 0);

	if (!empty($recordNumber) && !empty($name) && !empty($gender) && !empty($email) && !empty($password) && $accessLevel != '') {
		$userRepository = new UserRepository();
		$personRepository = new PersonRepository();

		$user = new User($email, $password, $accessLevel, $userId);
		if (empty($userId)) {
			$userId = $userRepository->add($user);
		} else {
			$userRepository->update($user);
		}

		$result = false;
		if (!empty($userId)) {
			$person = new Person($recordNumber, $name, $gender, $email, $userId);
			if (empty($personId)) {
				$result = $personRepository->add($person);
			} else {
				$result = $personRepository->update($person);
			}
		}

		fb($result);
		return json_encode($result);
	}

	return new ErrorObj(400, 'Preencha todos os campos.');
}
