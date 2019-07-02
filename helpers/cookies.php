<?php

class Cookie {
	private function __construct() {

	}

	private function __clone() {

	}

	public static function set($key, $value) {
		setcookie($key, $value, time()+60*60*24*31, "/");
	}

	public static function get($key) {
		if (isset($_COOKIE[$key])) return $_COOKIE[$key];
	}

	public static function terminate($key, $value) {
		if (isset($_COOKIE[$key])) setcookie($key, $value, time()-60*60*24*31, "/");
	}

	public static function terminateAll() {
		if (isset($_SERVER['HTTP_COOKIE'])) {
			$cookies = explode(';', $_SERVER['HTTP_COOKIE']);

			foreach($cookies as $cookie) {
				$parts = explode('=', $cookie);
				$name = trim($parts[0]);
				setcookie($name, '', time()-60*60*24*31);
				setcookie($name, '', time()-60*60*24*31, '/');
			}
		}
	}
}

?>