<?php

abstract class ExporterProduct {
	abstract function serializeObj(&$vetor) : string;
}