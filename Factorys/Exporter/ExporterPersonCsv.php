<?php

require_once DIR . 'Factorys/Exporter/ExporterPerson.php';

class ExporterPersonCsv extends ExporterPerson {

	public function serializeObj(&$data) : string {
		$lines = array();
		foreach ($data as $i => $p) {
			$person = new Person($p['id'], $p['name'], $p['gender'], $p['email']);
			$attrs = $person->getAttributes();
			unset($attrs['idUser']);
			$lines[0] = implode(';', array_keys($attrs)) . ';' . PHP_EOL;
			$lines[$i + 1] = '';
			foreach($attrs as $property => $value) {
				$lines[$i + 1] .= $value . ';';
			}

			$lines[$i + 1] .= PHP_EOL;
		}

		$csv = implode($lines);
		return $csv;
	}
}