<?php

class View {
	protected $scripts, $title, $args, $file;

	public function __construct($title, $file, $scripts, $args=[]) {
		$this->scripts = $scripts;
		$this->title = $title;
		$this->args = $args;
		$this->file = $file;
	}

	public function render() {
		require "app/views/beginning.php";
		require "app/views/$this->file";
		require "app/views/ending.php";
	}
}

?>