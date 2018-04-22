<?php

interface IRepository {

	public function add($obj);
	public function update($obj);
	public function delete($obj);
	public function getById(int $id);
	public function getAll();

}
