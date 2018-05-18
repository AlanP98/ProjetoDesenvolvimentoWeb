<?php

require_once DIR . 'Repositorys/UserRepository.php';
require_once DIR . 'Classes/Authentication.php';
require_once DIR . 'Classes/User.php';

class Authenticator {

	//TODO: UTILIZAR CRIPTOGRAFIA PARA A SENHA
	public function authenticate($userName, $password) {
		$userRepository = new UserRepository();
		$user = $userRepository->getByUsername($userName);

		if (! $user) {
			return new ErrorObj('401', 'Usuário não encontrado.', 'userName');
		} else {
			$realName = $userRepository->getPersonNameByIdUser($user['id']);
			Session::getInstance()->save('realName', $realName);

			$userObj = new User($user['id'], $user['userName'], $user['password'], $user['accessLevel'], $user['firstAccess']);
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

	//TODO: validar tempo de sessão - permitir até 30 min sem atividade
	public static function requireLogin() {
		if (!self::isLogged()) {
			self::logout();
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
		exit;
	}

	public static function redirectFirstAccess() {
		if (self::isFirstAccess()) {
			header('Location: updateAccount.php');
			exit;
		}
	}

	public static function isFirstAccess() {
		$session = Session::getInstance();
		$auth = $session->getByKey('AUTHENTICATION');
		return ($auth->isFirstAccess());
	}

	public static function verifyPermission($permissionId) {
		if (self::hasPermission($permissionId)) {
			return true;
		} else {
			$permission = self::getPermissionById($permissionId);
			$permissionError = new ErrorObj(401, 'Você não possui permissão para ' . $permission->getName());
			echo json_encode($permissionError);
			exit;
		}
	}

	public static function hasPermission($permissionId) {
		$session = Session::getInstance();
		$auth = $session->getByKey('AUTHENTICATION');

		$permission = self::getPermissionById($permissionId);
		$isPermission = ($permission instanceof Permission);
		return ($auth->getPermissions() >= $permission->getMinimumAccessLevel());
	}

	private static function getPermissionById($permissionId) {
		$permissions = self::getPermissions();

		foreach ($permissions as $permission) {
			if ($permission->getId() == $permissionId) {
				return $permission;
			}
		}

		return null;
	}

	private static function getPermissions() {
		return array(
			new Permission('WRITE_USER', 'gerenciar usuários', 2),
			new Permission('WRITE_PERSON', 'gerenciar pessoas', 1),
			new Permission('WRITE_PRODUCT', 'gerenciar produtos', 1),

			new Permission('DELETE_USER', 'excluir usuários', 2),
			new Permission('DELETE_PERSON', 'excluir pessoas', 2),
			new Permission('DELETE_PRODUCT', 'excluir produtos', 2),
		);
	}

}