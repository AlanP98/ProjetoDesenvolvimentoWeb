<?php

class MySqlConnection {

	private static $dsn;
	private static $user;
	private static $password;
	private static $instance;

	public static $connection;

	private function __construct($dsn, $user, $password) {
		self::$dsn = $dsn;
		self::$user = $user;
		self::$password = $password;

		self::$connection = new PDO($dsn, $user, $password);
		self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public static function getConnection($dsn, $user, $password) {
		try {

			if (!isset(self::$instance)) {
				self::$instance = new MySqlConnection($dsn, $user, $password);
			}

			return self::$instance;
		} catch (PDOException $e) {
			throw new Exception('Connection failed: ' . $e->getMessage());
		}
	}

}