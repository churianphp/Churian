<?php 

class Encrypt {
	private function __construct() {

	}

	private function __clone() {

	}

	public static function hash($var) {
		$salt1 = "!@#)0$$^%@NXJAS_+_(*HANM<>s4$77)(jhjjjjlh%%%***jd*++(*^T+12&54/*sRGA^&";
		$salt2 = "@#$^&(BXVDA54/++-*||sjU^^^&8$$^@Jdjdjd88888(++)&NQZ!#@#$???XWTJX";
		return hasher($salt1.$var.$salt2);
	}

	public static function ip() {
		return hasher($_SERVER["HTTP_USER_AGENT"].$_SERVER["REMOTE_ADDR"]);
	}

	public static function pass($str) {
		return password_hash($str, PASSWORD_DEFAULT);
	}

	public static function verifyPass($str, $hash) {
		# Force The Return Value To Be TRUE Or FALSE
		return password_verify($str, $hash) ? true : false;
	}
}

?>