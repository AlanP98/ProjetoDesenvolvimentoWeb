<?php

require_once DIR . 'Classes/Product.php';

abstract class ExporterProduct {
	abstract function serializeObj(&$vetor) : string;
}