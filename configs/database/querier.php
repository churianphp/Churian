<?php

require "manager.php";

class DBQuerier {
	protected $insertValues;
	protected $connection;
	protected $insertKeys;
	protected $operation;
	protected $table;
	protected $query;
	protected $res;

	public function __construct() {
		$this->connection = DBManager::getInstance()->getConnection();
	}

	protected function joinWithCommas($values) {
		return implode(", ", $values);
	}

	public function select($columns) {
		$this->query = "SELECT $columns";
		return $this;
	}

	public function from($table) {
		$this->query .= " FROM $table";
		return $this;
	}

	public function having($condition) {
		$this->query .= " HAVING $condition";
		return $this;
	}

	public function where($condition) {
		$this->query .= " WHERE $condition";
		return $this;
	}

	public function and($condition) {
		$this->query .= " AND $condition";
		return $this;
	}

	public function or($condition) {
		$this->query .= " OR $condition";
		return $this;
	}

	public function join($tables, $joinStyle="INNER") {
		$this->query .= " $joinStyle JOIN $tables";
		return $this;
	}

	public function on($condition) {
		$this->query .= " ON $condition";
		return $this;
	}

	public function orderBy($order) {
		$this->query .= " ORDER BY $order";
		return $this;
	}

	public function groupBy($grouping) {
		$this->query .= " GROUP BY $grouping";
		return $this;
	}

	public function limit($min, $max=null) {
		if (isset($max)) $this->query .= " LIMIT $min, $max";
		else $this->query .= " LIMIT $min";
		return $this;
	}

	protected function saveInto($table, $data, $operation) {
		$this->operation = $operation;
		$this->table = $table;
		$this->query = "";

		switch ($this->operation) {
			case "INSERT":
				$keys = array_map(function($key){return preg_replace("/^:/", "", $key);}, array_keys($data));
				$values = array_map(function($value){return "'$value'";}, array_values($data));
				$this->insertValues = $this->joinWithCommas($values);
				$this->insertKeys = $this->joinWithCommas($keys);
				break;

			case "UPDATE":
				foreach ($data as $key => $value) $this->query .= "$key = '$value', ";
				$this->query = rtrim($this->query, ", ");
				break;
		}

		return $this;
	}

	public function create($table, $data) {
		return $this->saveInto($table, $data, "INSERT");
	}

	public function update($table, $data) {
		return $this->saveInto($table, $data, "UPDATE");
	}

	public function delete($table) {
		$this->query = "DELETE FROM $table";
		$this->operation = "DELETE";
		return $this;
	}

	public function fetch($num=false) {
		try {
			$this->res = $this->connection->prepare($this->query);
			$this->res->execute();

			unset($this->query);

			$rows = $this->res->fetchAll($num ? PDO::FETCH_NUM : null);
			$data = $rows;

			unset($this->res);
			unset($rows);

			if (!empty($data)) return $data;
		} catch (PDOException $bug) {
			die ($bug->getMessage());
		}
	}

	public function execute() {
		switch ($this->operation) {
			case "INSERT":
				$this->res = $this->connection->prepare("INSERT INTO $this->table ($this->insertKeys) VALUES($this->insertValues)");
				break;

			case "UPDATE":
				$this->res = $this->connection->prepare("UPDATE $this->table SET $this->query");
				break;

			case "DELETE":
				$this->res = $this->connection->prepare($this->query);
				break;
		}

		$this->res->execute();

		unset($this->insertValues);
		unset($this->insertKeys);

		unset($this->query);
		unset($this->res);

		return $this->connection->lastInsertId();
	}

	public function beginTransaction() {
		return $this->connection->beginTransaction();
	}

	public function commitTransaction() {
		return $this->connection->commit();
	}

	public function rollBackChanges() {
		return $this->connection->rollBack();
	}
}

?>