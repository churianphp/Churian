<?php

abstract class Controller {
	public function __construct() {
		global $VARS, $TEXTS;
		
		$this->texts = $TEXTS;
		$this->vars = $VARS;
	}

	protected function renderView($title, $markupFile, $scripts, $args=[]) {
		$this->view = new View($title, $markupFile, $scripts, $args);
	}

	protected function getModel($model) {
		return (require "app/models/$model.php");
	}
}

?>