<?php

require_once '../config.php';
require_once DIR . 'Repositorys/UserRepository.php';

Authenticator::requireLogin();
Authenticator::verifyPermission('DELETE_USER');

try {
	echo json_encode(deleteUsers());
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}

function deleteUsers() {
	$connectedUserId =  Session::getInstance()->getByKey('AUTHENTICATION')->getIdUser();

	if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
		parse_str(file_get_contents('php://input'), $_DELETE);
		$deleteIds = (isset($_DELETE['ids']) && is_array($_DELETE['ids']) ? $_DELETE['ids'] : array());

		if (!empty($deleteIds)) {
			$userRepository = new UserRepository();
			$administratorIds = $userRepository->getAdministratorsIds();
			$deleteAdmins = array_intersect($deleteIds, $administratorIds);

			if (count($administratorIds) <= count($deleteAdmins)) {
				return new ErrorObj(400, 'Não foi possível excluir sua conta, pois você é o único administrador cadastrado.');
			}

			if (!empty(array_diff($deleteAdmins, array($connectedUserId)))) {
				return new ErrorObj(400, 'Não é possível excluir a conta de outros administradores. Somente o dono da conta pode realizar essa ação.');
			}

			if (is_array($deleteIds)) {
				$result = $userRepository->batchDelete($deleteIds);
			} else {
				$result = $userRepository->delete($deleteIds);
			}

			return $result;
		} else {
			return new ErrorObj(400, 'Nenhum usuário foi selecionado.');
		}
	} else {
		return new ErrorObj(400, 'DELETE requerido através do método incorreto: "' . $_SERVER['REQUEST_METHOD'] . '"');
	}
}