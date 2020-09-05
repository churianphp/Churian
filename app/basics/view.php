<?php

class View {
	public function __construct($title, $markupFile, $scripts, $args=[]) {
		$this->scripts = $scripts;
		$this->title = $title;
		$this->args = $args;

		require "app/views/beginning.php";
		require "app/views/$markupFile";
		require "app/views/ending.php";
	}
}

?>