<?php

class Product {
	public $recordNumber;
	public $description;

	public function __construct($recordNumber, $description) {
		$this->recordNumber = $recordNumber;
		$this->description = $description;
	}

	public function getAttributes() {
		return get_object_vars($this);
	}

	public function getRecordNumber() {
		return $this->recordNumber;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setRecordNumber($recordNumber) {
		$this->recordNumber = $recordNumber;
	}

	public function setDescription($description) {
		$this->description = $description;
	}
}