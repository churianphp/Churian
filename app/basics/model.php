<?php

class Model {
	protected $now, $db;

	public function __construct() {
		global $VARS, $TEXTS;

		$this->vars = $VARS;
		$this->texts = $TEXTS;
		$this->now = $VARS["datetime"];
		$this->db = new DBQuery;
	}

	public function load($model) {
		require "app/models/$model.php";
		$classname = ucfirst($model)."Model";
		return new $classname;
	}
}

?>