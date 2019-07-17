<?php

defined("BASEURL") || die ("Direct Access Denied");

function redirect($destination) {
	header("Location: ".URL.$destination);
	exit;
}

function removeSlashes($str) {
	return get_magic_quotes_gpc() ? stripslashes($str) : $str;
}

function sanitizeString($str) {
	return htmlentities(strip_tags(removeSlashes($str)));
}

function sanitizeHTML($str) {
	return htmlentities(removeSlashes($str));
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

?>