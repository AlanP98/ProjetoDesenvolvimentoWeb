<?php

class MySqlConnection {

	protected static $dsn;
	protected static $user;
	protected static $password;
	protected static $connection;

	function __construct($dsn, $user, $password) {
		self::$dsn = $dsn;
		self::$user = $user;
		self::$password = $password;

		self::$connection = self::getConnection();
	}

	public static function getConnection() {
		try {
			if (is_null(self::$connection)) {
				return new PDO(self::$dsn, self::$user, self::$password);
			} else {
				return self::$connection;
			}
		} catch (PDOException $e) {
			throw new Exception('Connection failed: ' . $e->getMessage());
		}
	}

}