<?php

require_once DIR . 'Factorys/Exporter/ExporterPerson.php';

class ExporterPersonJson extends ExporterPerson {

	public function serializeObj(&$data) : string {
		$persons = array();

		foreach($data as $p) {
			$person = new Person($p['recordNumber'], $p['name'], $p['gender'], $p['email']);
			$personArray = $person->getAttributes();
			$personArray['gender'] = $this->parseGender($person->getGender());
			$persons[] = $personArray;
		}

		return json_encode($persons, JSON_PRETTY_PRINT);
	}

	private function parseGender($gender) {
		switch ($gender) {
			case 'M':
				return 'Masculino';

			case 'W':
				return 'Feminino';

			case 'O':
				return 'Outro';

			default:
				return 'Não informado';
		}
	}
}