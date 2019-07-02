<?php

defined("BASEURL") || die("Direct Access Denied");

function customError($errno, $errstr) {
	echo "<b>Error: </b>[$errno] $errstr<br>";
	echo "Ending Script...";
	die();
}

function redirect($path) {
	header("Location: ".URL.$path);
	exit;
}

function stripSlash($str) {
	return get_magic_quotes_gpc() ? stripslashes($str) : $str;
}

function sanitizeString($str) {
	return htmlentities(strip_tags(stripSlash($str)));
}

function sanitizeHtml($str) {
	return htmlentities(stripSlash($str));
}

function hasher($string) {
	return hash("ripemd128", $string);
}

function mdHasher($string) {
	return md5($string);
}

function clearSpaces($str) {
	return trim(preg_replace("/\s\s+/", "", $str));
}

function codeGen($string) {
	$char = "abcdegijklmnpqrstuvwxyzABCDEFGHIJKMNOPQRSTVWXWZ023456789";
	srand((double) microtime()*1000000);
	$count = strlen($char);
	$str = "";

	for ($i=0; $i<=$string; ++$i) {
		$num = rand() % $count;
		$tmp = substr($char, $num, 1);
		$str .= $tmp;
	}

	return $str;
}

function arrayLowerCase(array $data) {
	$arrayValues = [];
	$arrayKeys = [];

	foreach ($data as $key => $value) {
		array_push($arrayValues, strtolower($value));
		array_push($arrayKeys, $key);
	}

	return array_combine($arrayKeys, $arrayValues);
}

function arrayUpperCase(array $data) {
	$arrayValues = [];
	$arrayKeys = [];

	foreach ($data as $key => $value) {
		array_push($arrayValues, strtoupper($value));
		array_push($arrayKeys, $key);
	}

	return array_combine($arrayKeys, $arrayValues);
}

function randomString($length=16, $first="$", $last="#") {
	$chars = "!ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@%+";
	$randStr = "";
		
	for ($i=0; $i < $length-2; $i++) {
		$randStr .= $chars[random_int(0, strlen($chars)-1)];
	}
	
	return $first.$randStr.$last;
}

?>