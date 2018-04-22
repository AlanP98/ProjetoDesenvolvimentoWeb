<?php

require_once DIR . 'Classes/Person.php';

abstract class ExporterPerson {
	abstract function serializeObj(&$vetor) : string;
}