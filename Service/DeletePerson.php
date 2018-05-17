<?php

require_once '../config.php';
require_once DIR . 'Repositorys/PersonRepository.php';
require_once DIR . 'Repositorys/UserRepository.php';

requireLogin();

$module = new Module('excluir pessoas', 2);
$result = Authenticator::verifyPermission($module);
if ($result !== true) {
	echo json_encode($result);
	exit;
}

try {
	echo json_encode(deletePersons());
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}

function deletePersons() {
	$method = $_SERVER['REQUEST_METHOD'];
	if ($method === 'DELETE') {
		parse_str(file_get_contents('php://input'), $_DELETE);
		$ids = $_DELETE['ids'];

		if (isset($ids) && !empty($ids)) {
			$personRepository = new PersonRepository();
			$userRepository = new UserRepository();
			$deletingAdmins = false;

			foreach ($ids as $i => $id) {
				if ($userRepository->isAdministrator($id)) {
					$deletingAdmins = true;
					unset($ids[$i]);
					continue;
				} else {
					$personRepository->deletePersonUser($id);
				}
			}

			if (!empty($ids)) {
				return $personRepository->batchDelete($ids);
			}

			if ($deletingAdmins) {
				return new ErrorObj(400, 'Não é possível excluir a conta de outros administradores. Somente o dono da conta pode realizar essa ação.');
			}
		} else {
			return new ErrorObj(400, 'Nenhuma pessoa foi selecionada.');
		}
	} else {
		return new ErrorObj(400, 'DELETE requested from a wrong method: "' . $method . '"');
	}
}