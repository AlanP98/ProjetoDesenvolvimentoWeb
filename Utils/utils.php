<?php

function insertQuery($object, $conn) {
	$attrs = $object->getAttributes();
	$table = strtolower($object->getClassName());

	$columns = $bindValues = '(';
	$keys = array_keys($attrs);
	$last = end($keys);

	foreach ($keys as $key) {
		$column = $key . ($last == $key ? ')' : ',');
		$columns .= $column;
		$bindValues .= ':' . $column;
	}

	$query = 'INSERT INTO ' . $table . ' ' . $columns . ' VALUES ' . $bindValues;
	$stmt = $conn->prepare($query);

	foreach ($attrs as $key => $value) {
		$stmt->bindParam(":$key", strval($value));
	}

	$st = $stmt->execute();
	if ($st === true) {
		return $conn->lastInsertId();
	} else {
		return null;
	}
}

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