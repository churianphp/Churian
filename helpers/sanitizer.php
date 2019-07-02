<?php

class Sanitize {
	private function __construct() {

	}

	private function __clone() {

	}

	public static function string($var) {
		return sanitizeString(clearSpaces(filter_var($var, FILTER_SANITIZE_STRING)));
	}

	public static function array_data(array $var) {
		$filterValue = [];
		$valueKey = [];

		foreach ($var as $key => $value) {
			array_push($valueKey, $key);
			array_push($filterValue, sanitizeString(clearSpaces(filter_var($value, FILTER_SANITIZE_STRING))));
		}

		# Return Combined Keys And Values
		return array_combine($valueKey, $filterValue);
	}

	public static function email($email) {
		return filter_var(clearSpaces($email), FILTER_SANITIZE_EMAIL);
	}

	public static function url($url) {
		return filter_var(clearSpaces($url), FILTER_SANITIZE_URL);
	}

	public static function int($num) {
		return (int) filter_var((int) $num, FILTER_SANITIZE_NUMBER_INT);
	}

	public static function float($num) {
		return filter_var((float) $num, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	}

	public static function html($str) {
		return sanitizeHtml(clearSpaces($str));
	}
}

?>