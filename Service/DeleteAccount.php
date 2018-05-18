<?php

require_once '../config.php';
require_once DIR . 'Repositorys/UserRepository.php';
require_once DIR . 'Repositorys/PersonRepository.php';

Authenticator::requireLogin();

try {
	echo json_encode(deleteAccount());
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}

function deleteAccount() {
	$connectedUserId =  Session::getInstance()->getByKey('AUTHENTICATION')->getIdUser();

	if (!empty($connectedUserId )) {
		$userRepository = new UserRepository();
		$personRepository = new PersonRepository();

		$administratorIds = $userRepository->getAdministratorsIds();
		$deleteAdmins = array_intersect(array($connectedUserId), $administratorIds);

		if (count($administratorIds) <= count($deleteAdmins)) {
			return new ErrorObj(400, 'Não foi possível excluir sua conta, pois você é o único administrador cadastrado.');
		}

		if (!empty(array_diff($deleteAdmins, array($connectedUserId)))) {
			return new ErrorObj(400, 'Não é possível excluir a conta de outros administradores. Somente o dono da conta pode realizar essa ação.');
		}

		$personRepository->deleteByUserId($connectedUserId);
		return $userRepository->delete($connectedUserId);
	} else {
		return new ErrorObj(400, 'Não foi possível excluir a sua conta. Tente logar-se novamente.');
	}
}