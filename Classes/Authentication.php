<?php

class Authentication {

	private $idUser;
	private $userName;
	private $permissions;
	private $loginTime;
	private $firstAccess;

	public function __construct($idUser, $userName, $permissions, $loginTime, $firstAccess = true) {
		$this->idUser = $idUser;
		$this->userName = $userName;
		$this->permissions = $permissions;
		$this->loginTime = $loginTime;
		$this->firstAccess = $firstAccess;
	}

	public function getIdUser() {
		return $this->idUser;
	}

	public function getUserName() {
		return $this->userName;
	}

	public function getPermissions() {
		return $this->permissions;
	}

	public function getLoginTime() {
		return $this->loginTime;
	}

	public function isFirstAccess() {
		return $this->firstAccess;
	}

}