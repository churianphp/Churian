<?php

class HomeController extends Controller {
	protected $userModel;

	public function __construct() {
		$this->userModel = new UserModel();
		parent::__construct();
	}

	public function index() {
		$this->renderView("Home", "home/index.php", [
			"home.js",
		]);
	}
}

return new HomeController();

?>