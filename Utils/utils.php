<?php

class ErrorObj {

	public $errorCode;
	public $errorMessage;
	public $element;

	public function __construct($errorCode, $errorMessage, $element = null) {
		$this->errorCode = $errorCode;
		$this->errorMessage = $errorMessage;
		$this->element = $element;
	}

}

class Module {

	private $name;
	private $minimumAccessLevel;

	public function __construct($name, $minimumAccessLevel) {
		$this->name = $name;
		$this->minimumAccessLevel = $minimumAccessLevel;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getMinimumAccessLevel() {
		return $this->minimumAccessLevel;
	}

	public function setMinimumAccessLevel($minimumAccessLevel) {
		$this->minimumAccessLevel = $minimumAccessLevel;
	}

}