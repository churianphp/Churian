<?php 

class Auth {
	private function __construct() {

	}

	private function __clone() {

	}

	public static function hash($password) {
		return password_hash($password, PASSWORD_DEFAULT);
	}

	public static function check($password, $hash) {
		return password_verify($password, $hash);
	}
}

?>