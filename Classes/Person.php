<?php

class Person {
	private $id;
	private $name;
	private $gender;
	private $email;
	private $idUser;

	public function __construct($id, $name, $gender, $email, $idUser = null) {
		$this->id = $id;
		$this->name = $name;
		$this->gender = $gender;
		$this->email = $email;
		$this->idUser = $idUser;
	}

	public function getId() {
		return $this->id;
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

	public function setId($id) {
		$this->id = $id;
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

	public function setIdUser($idUser) {
		$this->idUser = $idUser;
	}

	public function getAttributes() {
		return get_object_vars($this);
	}

	public function getClassName() {
		return get_class($this);
	}
}