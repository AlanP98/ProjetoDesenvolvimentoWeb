<?php

require_once '../config.php';
require_once DIR . 'Repositorys/PersonRepository.php';

requireLogin();

try {
	$method = $_SERVER['REQUEST_METHOD'];
	if ($method === 'DELETE') {
		parse_str(file_get_contents('php://input'), $_DELETE);
		$ids = $_DELETE['ids'];

		if (isset($ids) && !empty($ids)) {
			$personRepository = new PersonRepository();
			foreach ($ids as $id) {
				$personRepository->deletePersonUser($id);
			}

			echo json_encode($personRepository->batchDelete($ids));
		} else {
			echo json_encode(new ErrorObj(400, 'Nenhuma pessoa foi selecionada.'));
		}
	} else {
		echo json_encode(new ErrorObj(400, 'DELETE requested from a wrong method: "' . $method . '"'));
	}
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}