<?php

abstract class Model {
	protected $vars, $texts, $date, $db;

	public function __construct() {
		global $VARS, $TEXTS;

		$this->db = new DBQuerier();
		$this->date = $VARS["datetime"];
		$this->texts = $TEXTS;
		$this->vars = $VARS;
	}
}

?>