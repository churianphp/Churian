<?php

require "config.php";

class Database {
	private static $instance;

	private $charset = "utf8";
	private $database = DBNAME;
	private $username = DBUSERNAME;
	private $password = DBPASS;
	private $type = DBTYPE;
	private $host = DBHOST;
	private $connection;

	public static function getDatabase() {
		if (!self::$instance) self::$instance = new self();
		return self::$instance;
	}

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

	public function getConnection() {
		return $this->connection;
	}
}

?>