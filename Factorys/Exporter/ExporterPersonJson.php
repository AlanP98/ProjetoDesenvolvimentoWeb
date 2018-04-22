<?php

require_once DIR . 'Factorys/Exporter/ExporterPerson.php';

class ExporterPersonJson extends ExporterPerson {

	public function serializeObj(&$data) : string {
		$persons = array();

		foreach($data as $p) {
			$person = new Person($p['recordNumber'], $p['name'], $p['gender']);
			$persons[] = $person->getAttributes();
		}

		return json_encode($persons, JSON_PRETTY_PRINT);
	}
}