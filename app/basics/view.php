<?php

class View {
	public function __construct($title, $markupFile, $scripts, $args=[]) {
		$this->scripts = $scripts;
		$this->title = $title;

		require "app/views/header.php";
		require "app/views/$markupFile";
		require "app/views/footer.php";
	}
}

?>