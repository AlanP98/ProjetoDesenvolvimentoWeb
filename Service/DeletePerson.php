<?php

require_once '../config.php';
require_once DIR . 'Repositorys/PersonRepository.php';

try {
	$method = $_SERVER['REQUEST_METHOD'];
	if ($method === 'DELETE') {
		parse_str(file_get_contents('php://input'), $_DELETE);

		if (isset($_DELETE['ids']) && !empty($_DELETE['ids'])) {
			$personRepository = new PersonRepository();
			echo json_encode($personRepository->batchDelete($_DELETE['ids']));
		} else {
			throw new Exception('Nenhum cliente foi selecionado.');
		}
	} else {
		throw new Exception('DELETE requested from a wrong method: "' . $method . '"');
	}
} catch(Exception $e) {
	http_response_code(400);
	echo $e->getMessage();
}