<?php

abstract class Model {
	protected $now, $db;

	public function __construct() {
		global $VARS, $TEXTS;

		$this->vars = $VARS;
		$this->texts = $TEXTS;
		$this->now = $VARS["datetime"];
		$this->db = new DBQuerier;
	}
}

?>