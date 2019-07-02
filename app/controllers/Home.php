<?php

class Home extends Controller {
	public function __construct() {
		parent::__construct();
		$this->view->scripts = [
			"home.js"
		];
	}

	public function index() {
		$this->view->render("home/index.php");
	}
}

?>