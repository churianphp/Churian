<?php 

class Auth {
	private function __construct() {

	}

	private function __clone() {

	}

	public static function hash($str) {
		return password_hash($str, PASSWORD_DEFAULT);
	}

	public static function check($str, $hash) {
		return password_verify($str, $hash) ? true : false;
	}
}

?>