<?php

require_once '../config.php';
require_once DIR . 'Repositorys/UserRepository.php';

requireLogin();

try {
	if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
		parse_str(file_get_contents('php://input'), $_DELETE);
		$deleteIds = (isset($_DELETE['ids']) ? $_DELETE['ids'] : 0);

		if (!empty($deleteIds)) {
			$userRepository = new UserRepository();
			$administratorIds = $userRepository->getAdministratorsIds();
			$deleteAdmins = array_intersect($deleteIds, $administratorIds);

			if (!empty($deleteAdmins)) {
				echo json_encode(new ErrorObj(400, 'Você não pode excluir a conta de outro administrador.'));
			}

			if (is_array($deleteIds)) {
				echo json_encode($userRepository->batchDelete($deleteIds));
			} else {
				echo json_encode($userRepository->delete($deleteIds));
			}
		} else {
			echo json_encode(new ErrorObj(400, 'Nenhum usuário foi selecionado.'));
		}
	} else {
		echo json_encode(new ErrorObj(400, 'DELETE requerido através do método incorreto: "' . $method . '"'));
	}
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}