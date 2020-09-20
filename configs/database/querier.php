<?php

require "manager.php";

class DBQuerier {
	private $connection;
	private $equatorSymbol = "=";
	private $lastInsertId = "";
	private $logicalType = "";
	private $operation = "";
	private $bindings = [];
	private $table = "";
	private $stmt = "";
	private $res;

	public function __construct() {
		$this->connection = DBManager::getInstance()->getConnection();
	}

	public function select($columns=[]) {
		$stmt = "SELECT ";

		if (empty($columns)) {
			$stmt .= "*";
		} else {
			$columns = $this->commaPrefix($columns);
			$stmt .= sprintf("%s", $columns);
		}

		$this->stmt = $stmt;
		return $this;
	}

	public function selectCount($column) {
		$stmt = "SELECT COUNT(".$column.")";
		$this->stmt = $stmt;
		return $this;
	}

	public function from($table) {
		$stmt = " FROM ";
		$this->stmt .= $stmt.sprintf("%s", $table);
		return $this;
	}

	public function in($column, $values=[]) {
		$stmt = " WHERE $column IN (";
		$values = $this->commaStringPrefix($values);
		$this->stmt .= $stmt.sprintf("%s", $values).")";
		return $this;
	}

	public function where($columns=[], $equatorSymbol="="){
		$condition = " WHERE ";

		$this->equatorSymbol = $equatorSymbol;

		return $this->setData($condition, $columns);
	}

	protected function condition($condition, $columns=[], $equatorSymbol) {
		static $i = 0;

		$this->equatorSymbol = $equatorSymbol;

		$newValues = array();
		$newKeys = array();

		foreach ($columns as $key => $value) {
			array_push($newKeys, $key."_____".$i);
			array_push($newValues, $value);
		}

		$data = array_combine($newKeys, $newValues);
		++$i;

		return $this->setData(" $condition ", $data);
	}

	public function and($columns=[], $equatorSymbol="=") {
		return $this->condition("AND", $columns, $equatorSymbol);
	}

	public function or($columns=[], $equatorSymbol="=") {
		return $this->condition("OR", $columns, $equatorSymbol);
	}

	public function like($column, $param, $type="") {
		switch ($this->logicalType) {
			case "OR":
			case "AND":
				$stmt = sprintf("%s", $column)." LIKE ";
				break;

			default:
				$stmt = " WHERE ".sprintf("%s", $column)." LIKE ";
				break;
		}

		foreach ($param as $key => $keyword) {
			$key = sprintf("%s", $key);

			switch ($type) {
				case "START":
					$keyword = sprintf("%s", "%".$keyword);
					break;

				case "BOTH":
					$keyword = sprintf("%s", "%".$keyword."%");
					break;

				case "END":
					$keyword = sprintf("%s", $keyword."%");
					break;
			}

			$this->bindings[$key] = $keyword;
			$this->stmt .= $stmt." :$key";
		}

		return $this;
	}

	public function logicalOpt($type) {
		switch (strtoupper($type)) {
			case "OR":
				$stmt = " OR ";
				$this->logicalType = "OR";
				break;

			case "AND":
				$stmt = " AND ";
				$this->logicalType = "AND";
				break;
		}

		$this->stmt .= $stmt;
		return $this;
	}

	public function naturalJoin($table) {
		$stmt = " NATURAL JOIN ".sprintf("%s", $table);
		$this->stmt .= $stmt;
		return $this;
	}

	public function join($tables, $joinStyle="LEFT JOIN") {
		$stmt = " ".strtoupper($joinStyle)." ";
		$stmt .= $this->commaPrefix($tables);
		$this->stmt .= $stmt;
		return $this;
	}

	public function on($part1, $part2) {
		$stmt = " ON ";
		$stmt .= sprintf("%s", $part1)."=".sprintf("%s", $part2);
		$this->stmt .= $stmt;
		return $this;
	}

	public function orderBy($order, $descending=false) {
		$stmt = " ORDER BY ";

		if ($descending === true) {
			$stmt .= sprintf("%s", $order)." DESC";
		} else {
			$stmt .= sprintf("%s", $order)." ASC";
		}

		$this->stmt .= $stmt;

		return $this;
	}

	public function limit($min, $max=null) {
		if ($max !== null) $this->stmt .= " LIMIT $min, $max";
		else $this->stmt .= " LIMIT $min";
		return $this;
	}

	protected function saveInto($table, $data, $operation) {
		$this->operation = strtoupper($operation);
		$this->table = sprintf("%s", $table);
		$this->stmt = "";

		if ($this->operation === "INSERT") {
			foreach ($data as $key => $value) {
				$key = preg_replace("/^:/", "", $key);
				$this->insertColumns[] = $key;
			}
		}

		return $this->setData("", $data);
	}

	public function create($table, $data) {
		return $this->saveInto($table, $data, "INSERT");
	}

	public function update($table, $data) {
		return $this->saveInto($table, $data, "UPDATE");
	}

	public function delete($table) {
		$this->operation = "DELETE";
		$stmt = "DELETE FROM $table";
		$this->stmt = $stmt;
		return $this;
	}

	public function fetch($fetchAll=false, $normalArray=false) {
		$returnData = [];
		$dataArray = [];

		$fetchMethod = $fetchAll ? "fetchAll": "fetch";

		try {
			$this->res = $this->connection->prepare($this->stmt);
			unset($this->stmt);

			if (isset($this->bindings)) {
				$dataArray = $this->bindings;
				unset($this->bindings);
			}

			foreach ($dataArray as $key => $value) {
				$this->bind($key, $value);
			}

			$this->res->execute();

			if ($normalArray) {
				while ($row = $this->res->$fetchMethod(PDO::FETCH_NUM)) {
					array_push($returnData, $row);
				}
			} else {
				while ($row = $this->res->$fetchMethod()) {
					array_push($returnData, $row);
				}
			}

			$result = $returnData;

			unset($this->res);
			unset($returnData);

			return empty($result) ? false : $result;
		} catch (PDOException $bug) {
			die ("Error: ".$bug->getMessage());
		}
	}

	public function execute() {
		$data = $this->commaPrefix(array_keys($this->bindings));
		$dataArray = [];

		switch ($this->operation) {
			case "INSERT":
				$this->res = $this->connection->prepare("INSERT INTO ".$this->table." (".$this->commaPreFix($this->insertColumns).") VALUES($data)");
				unset($this->insertColumns);
				break;

			case "UPDATE":
				$this->res = $this->connection->prepare("UPDATE ".$this->table." SET ".$this->stmt."");
				break;

			case "DELETE":
				$this->res = $this->connection->prepare($this->stmt);
				break;
		}

		unset($this->stmt);

		if ($this->bindings) {
			$dataArray = $this->bindings;
			unset($this->bindings);
		}

		foreach ($dataArray as $key => $value) {
			$this->bind($key, $value);
		}

		$this->res->execute();
		
		if ($this->operation == "INSERT") $this->lastInsertId = $this->connection->lastInsertId();

		unset($this->res);
	}

	public function getLastInsertId() {
		if ($this->lastInsertId) return (int) $this->lastInsertId;
	}

	public function beginTransaction() {
		return $this->connection->beginTransaction();
	}

	public function rollBackTransaction() {
		return $this->connection->rollBack();
	}

	public function commitTransaction() {
		return $this->connection->commit();
	}

	public function viewQuery() {
		echo $this->stmt;
	}

	private function setData($condition, $data) {
		foreach ($data as $key => $value) {
			$key1 = preg_match("/(_____\d+)$/", $key) ? preg_replace("/(_____\d+)$/", "", $key) : sprintf("%s", $key);
			$key2 = explode(".", $key);
			$key2 = isset($key2[1]) ? $key2[1] : $key2[0];
			$var = sprintf("%s", $value);

			$this->bindings[$key2] = $var;
			$this->stmt .= $condition.$key1."$this->equatorSymbol:".$key2.",";
			$this->equatorSymbol = "=";
		}

		$this->stmt = rtrim($this->stmt, ",");
		return $this;
	}

	private function bind($placeholder, $value) {
		return $this->res->bindValue($placeholder, sprintf("%s", $value), PDO::PARAM_STR);
	}

	private function commaPrefix($values) {
		$params = implode(",", $values);
		return $params;
	}

	private function commaStringPrefix($values) {
		$values = implode("','", $values);
		$values = "'".$values."'";
		return $values;
	}
}

?>