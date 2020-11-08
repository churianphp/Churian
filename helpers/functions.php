<?php

defined("BASEURL") || die ("Direct Access Denied");

function redirect($destination) {
	header("Location: ".URL.$destination);
	exit;
}

function harmlessString($str) {
	return htmlentities(strip_tags($str));
}

function harmlessHTML($str) {
	return htmlentities($str);
}

function removeSpaces($str) {
	return trim(preg_replace("/\s\s+/", "", $str));
}

function randomString($length=8, $string="") {
	$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		
	for ($i=0; $i < $length; $i++) {
		$string .= $chars[random_int(0, 61)];
	}
	
	return $string;
}

function allIsSet(...$keys) {
	foreach ($keys as $key) {
		if (!isset($_POST[$key])) return false;
	}

	return true;
}

function dump($data) {
	file_put_contents("debug.txt", $data, FILE_APPEND|LOCK_EX);
	file_put_contents("debug.txt", "\n\n", FILE_APPEND);
}

?>