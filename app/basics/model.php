<?php

abstract class Model {
	protected $vars, $texts, $date, $db;

	public function __construct() {
		$this->db = new DBQuerier();
		
		global $VARS, $TEXTS;
		$this->texts = $TEXTS;
		$this->date = $VARS["datetime"];
		$this->vars = $VARS;
	}
}

?>