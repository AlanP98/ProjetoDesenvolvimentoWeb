<?php

class Person {
	private $recordNumber;
	private $name;
	private $gender;
	private $email;
	private $idUser;

	public function __construct($recordNumber, $name, $gender, $email, $idUser = null) {
		$this->recordNumber = $recordNumber;
		$this->name = $name;
		$this->gender = $gender;
		$this->email = $email;
		$this->idUser = $idUser;
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

	public function getEmail() {
		return $this->email;
	}

	public function getIdUser() {
		return $this->idUser;
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

	public function setEmail($email) {
		$this->email = $email;
	}

	public function getAttributes() {
		return get_object_vars($this);
	}

	public function getClassName() {
		return get_class($this);
	}
}