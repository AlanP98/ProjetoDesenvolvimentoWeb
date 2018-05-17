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

	public static function insertQuery($object) {
		$table = strtolower($object->getClassName());
		$attrs = $object->getAttributes();
		$attrs = array_filter($attrs, function($val) {
			return (!is_null($val));
		});

		$columns = $bindValues = '(';
		$keys = array_keys($attrs);
		$last = end($keys);

		foreach ($keys as $key) {
			$column = $key . ($last == $key ? ')' : ',');
			$columns .= $column;
			$bindValues .= ':' . $column;
		}

		$query = 'INSERT INTO ' . $table . ' ' . $columns . ' VALUES ' . $bindValues;
		$stmt = self::$connection->prepare($query);

		foreach ($attrs as $key => $value) {
			$stmt->bindParam(":$key", strval($value));
		}

		$st = $stmt->execute();
		if ($st === true) {
			return self::$connection->lastInsertId();
		} else {
			return null;
		}
	}

	public static function updateQuery($object) {
		$table = strtolower($object->getClassName());
		$attrs = $object->getAttributes();
		$attrs = array_filter($attrs, function($val) {
			return (!is_null($val));
		});

		$binds = array();
		$keys = array_keys($attrs);
		$last = end($keys);
		$query = 'UPDATE ' . $table . ' SET ';

		foreach ($attrs as $key => $value) {
			$query .= $key . ' = :' . $key . ($last != $key ? ', ' : ' ');
			$binds[$key] = $value;
		}

		$query .= 'WHERE id = :id ';

		$stmt = self::$connection->prepare($query);
		foreach ($binds as $key => $value) {
			$stmt->bindParam(":$key", strval($value));
		}

		return $stmt->execute();
	}

}