<?php

defined("BASEURL") || die("Direct Access Denied");

function validatePassword($input) {
	return strlen($input) < 6 ? "Password Must Contain At Least SIX Characters" : "";
}

function validateUsername($input) {
	if (preg_match("/[^a-zA-Z0-9_.-]/")) return "Username Must Contain Valid Characters";
	if (strlen($input) < 6) return "Username Must Be At Least SIX Characters Long";

	return "";
}

function validateFullName($input) {
	return preg_match("/[^a-zA-Z0-9 ._-]/", $input) ? "Full Name Must Contain Valid Characters" : "";
}

function validateEmail($input) {
	if (filter_var($input, FILTER_VALIDATE_EMAIL) === false) return "$input Is Not A Valid Email Address";
	if (!((strpos($input, "@") > 1) && (strpos($input, ".") > 0)) || preg_match("/[^a-zA-Z0-9.@_-]/", $input)) return "$input Is Not A Valid Email Address";

	return "";
}

function validateGender($input) {
	switch ($input) {
		case 'male':
		case 'female':
			return "";
			break;

		default:
			return "Please Select Your Gender";
			break;
	}
}

function validateUrl($input) {
	return filter_var($input, FILTER_VALIDATE_URL) ? $input." Is Not A Valid URL" : "";
}

function validateBtcAddress($input) {
	return preg_match("/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/", $input) ? true : false;
}

?>