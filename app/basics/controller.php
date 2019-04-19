<?php

abstract class Controller {
	public function __construct() {
		$this->model = new Model;
		$this->view = new View;
	}
}

?>