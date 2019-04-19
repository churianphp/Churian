<?php

class Model {
	protected $now;
	protected $db;

	public function __construct() {
		global $CONF;
		$this->now = $CONF["datetime"];
		$this->db = new DBQuery;
	}

	public function load($model) {
		require "app/models/$model.php";
		$classname = ucfirst($model)."Model";
		return new $classname;
	}
}

?>