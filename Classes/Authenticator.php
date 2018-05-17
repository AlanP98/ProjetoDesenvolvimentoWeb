<?php

require_once DIR . 'Repositorys/UserRepository.php';
require_once DIR . 'Classes/Authentication.php';
require_once DIR . 'Classes/User.php';

class Authenticator {

	public function authenticate($userName, $password) {
		//TODO: UTILIZAR CRIPTOGRAFIA PARA A SENHA
		$userRepository = new UserRepository();
		$user = $userRepository->getByUsername($userName);

		if (! $user) {
			return new ErrorObj('401', 'Usuário não encontrado.', 'userName');
		} else {
			$userObj = new User($user['userName'], $user['password'], $user['accessLevel'], $user['id'], $user['firstAccess']);
			if ($userObj->checkPassword($password)) {
				if (self::isLogged()) {
					session_destroy();
				}

				return self::updateAuth($userObj);
			} else {
				return new ErrorObj('401', 'Senha incorreta.', 'password');
			}
		}
	}

	public static function updateAuth($user = null) {
		$session = Session::getInstance();

		if ($user instanceof User) {
			$auth = new Authentication($user->getId(), $user->getUserName(), $user->getAccessLevel(), date('d-m-Y H:i:s'), $user->isFirstAccess());
			$session->save('isLogged', true);
			$session->save('AUTHENTICATION', $auth);
			return $auth;
		} else {
			$session->save('isLogged', false);
			return null;
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

	public static function redirectFirstAccess() {
		if (self::isFirstAccess()) {
			header('Location: updateAccount.php');
			die;
		}
	}

	public static function isFirstAccess() {
		$session = Session::getInstance();
		$auth = $session->getByKey('AUTHENTICATION');
		return ($auth->isFirstAccess());
	}

	public static function verifyPermission($module) {
		$session = Session::getInstance();
		$auth = $session->getByKey('AUTHENTICATION');

		$isModule = ($module instanceof Module);
		$havePermission = ($auth->getPermissions() >= $module->getMinimumAccessLevel());

		if ($isModule && $havePermission) {
			return true;
		}

		return new ErrorObj(401, 'Você não possui permissão para ' . $module->getName());
	}

}