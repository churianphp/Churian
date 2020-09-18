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

function randomString($length=16, $first="$", $last="#", $string="") {
	$chars = "!ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@%+";
		
	for ($i=0; $i < $length-2; $i++) {
		$string .= $chars[random_int(0, strlen($chars)-1)];
	}
	
	return $first.$string.$last;
}

function allIsSet(...$keys) {
	foreach ($keys as $key) {
		if (!isset($_POST[$key])) return false;
	}

	return true;
}

?>