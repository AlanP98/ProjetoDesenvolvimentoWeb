<?php

require_once DIR . 'Factorys/Exporter/ExporterPerson.php';

class ExporterPersonJson extends ExporterPerson {

	public function serializeObj(&$data) : string {
		$persons = array();

		foreach($data as $person) {
			$persons[] = $person->getAttributes();
		}

		return json_encode($persons, true);
	}
}