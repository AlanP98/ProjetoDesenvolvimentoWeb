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

class Permission {

	private $id;
	private $name;
	private $minimumAccessLevel;

	public function __construct($id, $name, $minimumAccessLevel) {
		$this->id = $id;
		$this->name = $name;
		$this->minimumAccessLevel = $minimumAccessLevel;
	}

	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function setId($id) {
		$this->id = $id;
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