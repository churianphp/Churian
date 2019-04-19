<?php

class View {
	public function __construct() {
	}

	public function render($pageMarkup, $data=[]) {
		require "app/views/header.php";
		require "app/views/$pageMarkup";
		require "app/views/footer.php";
	}
}

?>