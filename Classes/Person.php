<?php

class Person {
	protected $recordNumber;
	protected $name;
	protected $gender;

	public function __construct($recordNumber, $name, $gender) {
		$this->recordNumber = $recordNumber;
		$this->name = $name;
		$this->gender = $gender;
	}

	public function getAttributes() {
		return get_object_vars($this);
	}

	public function getRecordNumber() {
		return $this->recordNumber;
	}

	public function getName() {
		return $this->name;
	}

	public function getGender() {
		return $this->gender;
	}

	public function setRecordNumber($recordNumber) {
		$this->recordNumber = $recordNumber;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setGender($gender) {
		$this->gender = $gender;
	}

	public function getClassName() {
		return get_class($this);
	}
}