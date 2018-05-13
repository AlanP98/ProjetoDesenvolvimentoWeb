<?php

class Session {

	private static $instance;

	private function __construct() {}

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new Session();
			session_start();
			session_regenerate_id(true);
		}

		return self::$instance;
	}

	public function save(string $key, $content) {
		$_SESSION[$key] = serialize($content);
	}

	public function getByKey(string $key) {
		if (!$this->keyExists($key)){
			return null;
		}

		$content = unserialize($_SESSION[$key]);
		return $content;
	}

	public function keyExists(string $key) {
		return isset($_SESSION[$key]);
	}

	public function destroy() {
		session_destroy();
		self::$instance = null;
	}
}