<?php

class User {

	private $id;
	private $userName;
	private $password;
	private $accessLevel;
	private $firstAccess;

	public function __construct($id, $userName, $password, $accessLevel = 0, $firstAccess = null) {
		$this->id = $id;
		$this->userName = $userName;
		$this->password = $password;
		$this->accessLevel = $accessLevel;
		$this->firstAccess = $firstAccess;
	}

	public function getId() {
		return $this->id;
	}

	public function getUserName() {
		return $this->userName;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getAccessLevel() {
		return $this->accessLevel;
	}

	public function isFirstAccess() {
		return $this->firstAccess;
	}

	public function checkPassword($password) {
		return $this->password == $password;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setUserName($userName) {
		$this->userName = $userName;
	}

	public function setAccessLevel($accessLevel) {
		$this->accessLevel = $accessLevel;
	}

	public function setFirstAccess($firstAccess) {
		$this->firstAccess = $firstAccess;
	}

	public function getAttributes() {
		return get_object_vars($this);
	}

	public function getClassName() {
		return get_class($this);
	}
}