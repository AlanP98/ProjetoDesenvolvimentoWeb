<?php

function insertQuery1($object) {
	$attrs = $object->getAttributes();
	$table = strtolower($object->getClassName());

	$columns = $values = '(';
	$keys = array_keys($attrs);
	$last = end($keys);

	foreach ($attrs as $key => $value) {
		$columns .= $key . ($last == $key ? ')' : ',');
		$values .= '\'' . $value . '\'' . ($last == $key ? ')' : ',');
	}

	return 'INSERT INTO ' . $table . ' ' . $columns . ' VALUES ' . $values;
}

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

	var_dump($attrs);

	$query = 'INSERT INTO ' . $table . ' ' . $columns . ' VALUES ' . $bindValues;
	var_dump($query);
	$stmt = $conn->prepare($query);

	foreach ($attrs as $key => $value) {
		var_dump('bindParam ' . ":$key" . ' = ' . $value);
		$stmt->bindParam(":$key", strval($value));
	}

	var_dump($stmt);
	$st = $stmt->execute();
	var_dump($st);
	return $st;
}

// function selectQuery($object) {
// 	$table = strtolower($object->getClassName());
// 	return 'SELECT * FROM ' . $table;
// }