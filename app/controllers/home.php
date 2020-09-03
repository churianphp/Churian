<?php

class HomeController extends Controller {
	public function __construct() {
		parent::__construct();
		$this->userModel = $this->getModel("user");
	}

	public function index() {
		$this->renderView("Home", "home/index.php", [
			"home.js"
		]);
	}
}

return new HomeController();

?>