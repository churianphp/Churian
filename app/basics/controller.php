<?php

abstract class Controller {
	protected $vars, $texts, $view;

	public function __construct() {
		global $VARS, $TEXTS;
		$this->texts = $TEXTS;
		$this->vars = $VARS;
	}

	protected function renderView($title, $markupFile, $scripts, $args=[]) {
		$this->view = new View($title, $markupFile, $scripts, $args);
		$this->view->render();
	}
}

?>