<?php

class Sanitizer {
	private function __construct() {

	}

	private function __clone() {

	}

	public static function cleanString($str) {
		return harmlessString(removeSpaces(filter_var($str, FILTER_SANITIZE_STRING)));
	}

	public static function cleanArray($items) {
		$values = []; $keys = [];

		foreach ($items as $key => $value) {
			array_push($values, self::cleanString($value));
			array_push($keys, $key);
		}

		return array_combine($keys, $values);
	}

	public static function cleanEmail($email) {
		return filter_var(removeSpaces($email), FILTER_SANITIZE_EMAIL);
	}

	public static function cleanURL($url) {
		return filter_var(removeSpaces($url), FILTER_SANITIZE_URL);
	}

	public static function cleanInt($int) {
		return (int) filter_var((int) $int, FILTER_SANITIZE_NUMBER_INT);
	}

	public static function cleanFloat($float) {
		return (float) filter_var((float) $float, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	}

	public static function cleanHTML($html) {
		return harmlessHTML(removeSpaces($html));
	}
}

?>