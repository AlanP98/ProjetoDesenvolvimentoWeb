<?php

require_once DIR . 'Repositorys/UserRepository.php';
require_once DIR . 'Classes/Authentication.php';
require_once DIR . 'Classes/User.php';

class Authenticator {

	public function authenticate($userName, $password) {
		//TODO: UTILIZAR CRIPTOGRAFIA PARA A SENHA
		$usersRepository = new UserRepository();
		$user = $usersRepository->getByUsername($userName);

		if (! $user) {
			return new ErrorObj('401', 'Usuário não encontrado.', 'userName');
		} else {
			$userObj = new User($user['userName'], $user['password'], $user['accessLevel'], $user['id']);
			if ($userObj->checkPassword($password)) {
				if (self::isLogged()) {
					session_destroy();
				}

				$auth = new Authentication($userObj->getId(), $userObj->getUserName(), $userObj->getAccessLevel(), date('d-m-Y H:i:s'));
				$session = Session::getInstance();
				$session->save('isLogged', true);
				$session->save('AUTHENTICATION', $auth);
				return $auth;
			} else {
				return new ErrorObj('401', 'Senha incorreta.', 'password');
			}
		}
	}

	public static function isLogged() {
		$session = Session::getInstance();
		return ($session->getByKey('isLogged') === true);
	}

	public static function logout() {
		$session = Session::getInstance();
		$session->destroy();
		echo "<script>window.location.href='index.php'</script>";
		die;
	}

}