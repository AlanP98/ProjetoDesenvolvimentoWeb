<?php

require_once '../config.php';
require_once DIR . 'Classes/User.php';
require_once DIR . 'Classes/Person.php';
require_once DIR . 'Repositorys/UserRepository.php';
require_once DIR . 'Repositorys/PersonRepository.php';

Authenticator::requireLogin();

try {
	echo json_encode(updateAccount());
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}

function updateAccount() {

	if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
		parse_str(file_get_contents('php://input'), $_PUT);
	} else {
		return new ErrorObj(400, 'PUT requerido através do método incorreto: "' . $_SERVER['REQUEST_METHOD'] . '"');
	}

	$connectedUserId = Session::getInstance()->getByKey('AUTHENTICATION')->getIdUser();
	$personId = (isset($_PUT['personId']) && !empty($_PUT['personId']) ? $_PUT['personId'] : null);
	$name = (isset($_PUT['name']) ? $_PUT['name'] : '');
	$gender = (isset($_PUT['gender']) ? $_PUT['gender'] : '');
	$email = (isset($_PUT['email']) ? $_PUT['email'] : '');
	$userName = (isset($_PUT['userName']) ? $_PUT['userName'] : '');
	$password = (isset($_PUT['password']) ? $_PUT['password'] : '');
	$confirmPassword = (isset($_PUT['confirmPassword']) ? $_PUT['confirmPassword'] : '');
	$updateFirstAccess = (isset($_PUT['firstAccess']) ? (bool) $_PUT['firstAccess'] : false);

	if (empty($name) || empty($gender) || empty($email) || empty($userName) || empty($password) || (empty($connectedUserId))) {
		return new ErrorObj(400, 'Preencha todos os campos.');
	}

	if ($password != $confirmPassword) {
		return new ErrorObj(400, 'As senhas não conferem.');
	}

	$userRepository = new UserRepository();
	$personRepository = new PersonRepository();
	$user = new User($connectedUserId, $userName, $password, null);

	if ($updateFirstAccess) {
		$user->setFirstAccess(0);
	}

	$updated = $userRepository->update($user);
	if ($updated) {
		$aUser = $userRepository->getById($connectedUserId);
		$user->setUserName($aUser['userName']);
		$user->setAccessLevel($aUser['accessLevel']);
		$user->setFirstAccess($aUser['firstAccess']);
		Authenticator::updateAuth($user);

		$person = new Person($personId, $name, $gender, $email, $connectedUserId);
		$updated = $personRepository->update($person);

		if ($updated) {
			Session::getInstance()->save('realName', $name);
		}
	}

	if (!$updated) {
		return new ErrorObj(400, 'Não foi possível atualizar os seus dados.');
	}

	return $updated;
}
