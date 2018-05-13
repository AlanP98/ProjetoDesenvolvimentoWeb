<?php

class Authentication {

	private $userId;
	private $userName;
	private $permissions;
	private $loginTime;

	public function __construct($userId, $userName, $permissions, $loginTime) {
		$this->userId = $userId;
		$this->userName = $userName;
		$this->permissions = $permissions;
		$this->loginTime = $loginTime;
	}

	public function getUserId() {
		return $this->userId;
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

}