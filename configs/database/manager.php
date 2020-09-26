<?php

require "config.php";

class DBManager {
	private static $instance;

	private $charset = "utf8";
	private $password = DBPASS;
	private $username = DBUSER;
	private $database = DBNAME;
	private $type = DBTYPE;
	private $host = DBHOST;
	private $connection;

	private function __construct() {
		try {
			$this->connection = new PDO($this->type.":host=".$this->host.";dbname=".$this->database.";charset=".$this->charset, $this->username, $this->password);
			$this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $bug) {
			die("Error: ".$bug->getMessage());
		}
	}

	private function __clone() {

	}

	public static function getInstance() {
		if (!self::$instance) self::$instance = new self();
		return self::$instance;
	}

	public function getConnection() {
		return $this->connection;
	}
}

?>