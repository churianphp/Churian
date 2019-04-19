<?php

class Home extends Controller {
	public function __construct() {
		parent::__construct();
		$this->view->js = [
			"home"
		];
	}

	public function index() {
		$this->view->render("home/index.php");
	}
}

?>