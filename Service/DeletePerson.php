<?php

require_once '../config.php';
require_once DIR . 'Repositorys/PersonRepository.php';
require_once DIR . 'Repositorys/UserRepository.php';

Authenticator::requireLogin();
Authenticator::verifyPermission('DELETE_PERSON');

try {
	echo json_encode(deletePersons());
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}

function deletePersons() {

	$method = $_SERVER['REQUEST_METHOD'];
	if ($method != 'DELETE') {
		return new ErrorObj(400, 'DELETE requested from a wrong method: "' . $method . '"');
	}

	parse_str(file_get_contents('php://input'), $_DELETE);
	$ids = $_DELETE['ids'];

	if (empty($ids)) {
		return new ErrorObj(400, 'Nenhuma pessoa foi selecionada.');
	}

	$personRepository = new PersonRepository();
	$userRepository = new UserRepository();
	$warnings = array();

	foreach ($ids as $i => $id) {
		$idUser = $personRepository->hasUser($id);
		if (!empty($idUser)) {
			if (!Authenticator::hasPermission('DELETE_USER')) {
				unset($ids[$i]);
				$warnings[] = 'Não foi possível excluir a pessoa de registro ' . $id . ', pois há usuário vinculado e você não possui permissão para gerenciar usuários.';
				continue;
			}

			if ($userRepository->isAdministrator($idUser)) {
				unset($ids[$i]);
				$warnings[] = 'Não foi possível excluir a pessoa de registro ' . $id . ', pois ela possui usuário administrador.';
				continue;
			}
		}
	}

	if (!empty($ids)) {
		$personRepository->batchDelete($ids);
	}

	if (!empty($warnings)) {
		$msg = implode('<br>', $warnings);
		return new ErrorObj(400, $msg);
	}

	return true;
}