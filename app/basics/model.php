<?php

abstract class Model {
	protected $vars, $texts, $date, $db;

	public function __construct() {
		global $VARS, $TEXTS;

		$this->vars = $VARS;
		$this->texts = $TEXTS;
		$this->date = $VARS["datetime"];
		$this->db = new DBQuerier();
	}
}

?>