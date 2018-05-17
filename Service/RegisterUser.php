<?php

require_once '../config.php';
require_once DIR . 'Classes/User.php';
require_once DIR . 'Classes/Person.php';
require_once DIR . 'Repositorys/UserRepository.php';
require_once DIR . 'Repositorys/PersonRepository.php';

requireLogin();

requireLogin();

$module = new Module('cadastrar e atualizar usuários', 2);
$result = Authenticator::verifyPermission($module);
if ($result !== true) {
	echo json_encode($result);
	exit;
}

try {
	echo json_encode(registerUser());
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}

function registerUser() {

	$personId = (isset($_POST['personId']) && !empty($_POST['personId']) ? $_POST['personId'] : null);
	$idUser = (isset($_POST['idUser']) && !empty($_POST['idUser']) ? $_POST['idUser'] : null);
	$name = (isset($_POST['name']) ? $_POST['name'] : '');
	$gender = (isset($_POST['gender']) ? $_POST['gender'] : '');
	$email = (isset($_POST['email']) ? $_POST['email'] : '');
	$userName = (isset($_POST['userName']) ? $_POST['userName'] : '');
	$password = (isset($_POST['password']) ? $_POST['password'] : '');
	$confirmPassword = (isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '');
	$accessLevel = (isset($_POST['accessLevel']) ? $_POST['accessLevel'] : null);
	$accessLevel = (is_null($idUser) ? $accessLevel : null);
	$updateFirstAccess = (isset($_POST['firstAccess']) ? (bool) $_POST['firstAccess'] : false);

	if (!empty($name) && !empty($gender) && !empty($email) && !empty($userName) && !empty($password) && !(empty($idUser) && $accessLevel == '')) {
		if ($password != $confirmPassword) {
			return new ErrorObj(400, 'As senhas não conferem.');
		}

		$userRepository = new UserRepository();
		$personRepository = new PersonRepository();
		$user = new User($userName, $password, $accessLevel, $idUser);

		if ($updateFirstAccess) {
			$user->setFirstAccess(0);
			Authenticator::updateAuth($user);
		}

		if (empty($idUser)) {
			$idUser = $userRepository->add($user);
		} else {
			$userRepository->update($user);
		}

		$result = false;
		if (!empty($idUser)) {
			$person = new Person($personId, $name, $gender, $email, $idUser);
			if (empty($personId)) {
				$result = $personRepository->add($person);
			} else {
				$result = $personRepository->update($person);
			}
		}

		return json_encode($result);
	}

	return new ErrorObj(400, 'Preencha todos os campos.');
}
