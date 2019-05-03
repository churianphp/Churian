<?php

class View {
	public function __construct() {
	}

	public function render($markupFile) {
		require "app/views/header.php";
		require "app/views/$markupFile";
		require "app/views/footer.php";
	}
}

?>