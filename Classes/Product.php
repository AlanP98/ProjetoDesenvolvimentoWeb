<?php

class Product {
	private $id;
	private $recordNumber;
	private $description;

	public function __construct($recordNumber, $description, $id = 0) {
		$this->recordNumber = $recordNumber;
		$this->description = $description;
		$this->id = $id;
	}

	public function getRecordNumber() {
		return $this->recordNumber;
	}

	public function getDescription() {
		return $this->description;
	}

	public function getId() {
		return $this->id;
	}

	public function setRecordNumber($recordNumber) {
		$this->recordNumber = $recordNumber;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getClassName() {
		return get_class($this);
	}

	public function getAttributes() {
		return get_object_vars($this);
	}

}