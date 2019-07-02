<?php

abstract class Controller {
	public function __construct() {
		global $VARS, $TEXTS;
		
		$this->model = new Model;
		$this->view = new View;
		$this->texts = $TEXTS;
		$this->vars = $VARS;
	}
}

?>