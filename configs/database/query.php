<?php

require "connect.php";

class DBQuery {
	private $equatorType = "=";
	private $lastInsertId = "";
	private $executeType = "";
	private $logicalType = "";
	private $bindData = [];
	private $result = "";
	private $table = "";
	private $stmt = "";
	private $db;

	public function __construct() {
		$this->db = Database::getDatabase()->getConnection();
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

	public function where($where=[], $equatorType=null){
		$cond = " WHERE ";

		if ($equatorType !== null) $this->equatorType = $equatorType;
		else $this->equatorType = "=";

		return $this->setData($cond, $where);
	}

	public function cond($condType, $columns=[], $equatorType=null) {
		static $i = 0;

		switch (strtoupper($condType)) {
			case "AND":
			case "OR":
				$type = " ".$condType." ";
				break;
		}

		$this->equatorType = $equatorType === null ? "=" : $equatorType;

		$new_key = array();
		$new_value = array();

		foreach ($columns as $key => $value) {
			array_push($new_key, $key."_____".$i);
			array_push($new_value, $value);
		}

		$data = array_combine($new_key, $new_value);

		++$i;

		return $this->setData(strtoupper($type), $data);
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

			switch (strtolower($type)) {
				case "start":
					$keyword = sprintf("%s", "%".$keyword);
					break;

				case "end":
					$keyword = sprintf("%s", $keyword."%");
					break;

				case "both":
				default:
					$keyword = sprintf("%s", "%".$keyword."%");
					break;
			}

			$this->bindData[$key] = $keyword;
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

	public function nJoin($table) {
		$stmt = " NATURAL JOIN ".sprintf("%s", $table);
		$this->stmt .= $stmt;
		return $this;
	}

	public function join($table, $jointype) {
		$stmt = " ".strtoupper($jointype)." ";
		$stmt .= $this->commaPrefix($table);
		$this->stmt .= $stmt;
		return $this;
	}

	public function on($cond1, $cond2) {
		$stmt = " ON ";
		$stmt .= sprintf("%s", $cond1)."=".sprintf("%s", $cond2);
		$this->stmt .= $stmt;
		return $this;
	}

	public function orderBy($order, $orderType="") {
		$stmt = " ORDER BY ";

		switch (strtoupper($orderType)) {
			case "DESC":
				$stmt .= sprintf("%s", $order)." $orderType";
				break;

			case "ASC":
			default:
				$stmt .= sprintf("%s", $order)." ASC";
				break;
		}

		$this->stmt .= $stmt;
		return $this;
	}

	public function limit($min, $max="") {
		if ($max !== "") $this->stmt .= " LIMIT ".intval((int) $min).", ".intval((int) $max);
		else $this->stmt .= " LIMIT ".intval($min);
		return $this;
	}

	public function saveInto($type, $table, $data) {
		$this->table = sprintf("%s", $table);
		$this->executeType = strtoupper($type);
		$this->stmt = "";

		if ($this->executeType === "INSERT") {
			foreach ($data as $key => $value) {
				$key = preg_replace("/^:/", "", $key);
				$this->insertColumns[] = $key;
			}
		}

		return $this->setData("", $data);
	}

	public function delete($table) {
		$this->executeType = "DELETE";
		$stmt = "DELETE FROM $table";
		$this->stmt = $stmt;
		return $this;
	}

	public function fetch($fetchType=false, $arrayType=false) {
		$returnData = [];
		$dataArray = [];

		$fetch = $fetchType == true ? "fetchAll": "fetch";

		try {
			$this->result = $this->db->prepare($this->stmt);
			unset($this->stmt);

			if (isset($this->bindData)) {
				$dataArray = $this->bindData;
				unset($this->bindData);
			}

			foreach ($dataArray as $key => $value) {
				$this->bind($key, $value);
			}

			$this->result->execute();

			if ($arrayType == true) {
				while ($row = $this->result->$fetch(PDO::FETCH_NUM)) {
					array_push($returnData, $row);
				}
			} else {
				while ($row = $this->result->$fetch()) {
					array_push($returnData, $row);
				}
			}

			$result = $returnData;

			unset($returnData);
			unset($this->result);

			return empty($result) ? false : $result;
		} catch (PDOException $bug) {
			die("Error: ".$bug->getMessage());
		}
	}

	public function execute() {
		$data = $this->commaPrefix(array_keys($this->bindData));
		$dataArray = [];

		switch ($this->executeType) {
			case "INSERT":
				$this->result = $this->db->prepare("INSERT INTO ".$this->table." (".$this->commaPreFix($this->insertColumns).") VALUES($data)");
				unset($this->insertColumns);
				break;

			case "UPDATE":
				$this->result = $this->db->prepare("UPDATE ".$this->table." SET ".$this->stmt."");
				break;

			case "DELETE":
				$this->result = $this->db->prepare($this->stmt);
				break;
		}

		unset($this->stmt);

		if ($this->bindData) {
			$dataArray = $this->bindData;
			unset($this->bindData);
		}

		foreach ($dataArray as $key => $value) {
			$this->bind($key, $value);
		}

		$this->result->execute();

		unset($this->result);

		if ($this->executeType == "INSERT") $this->lastInsertId = $this->db->lastInsertId();
	}

	public function getLastInsertId() {
		if ($this->lastInsertId) return (int) $this->lastInsertId;
	}

	public function t_begin() {
		return $this->db->beginTransaction();
	}

	public function t_commit() {
		return $this->db->commit();
	}

	public function t_rollback() {
		return $this->db->rollBack();
	}

	public function viewQuery() {
		echo $this->stmt;
	}

	private function setData($cond, $data) {
		foreach ($data as $key => $value) {
			$key1 = preg_match("/(_____\d+)$/", $key) ? preg_replace("/(_____\d+)$/", "", $key) : sprintf("%s", $key);
			$key2 = explode(".", $key);
			$key2 = isset($key2[1]) ? $key2[1] : $key2[0];
			$var = sprintf("%s", $value);

			$this->bindData[$key2] = $var;
			$this->stmt .= $cond.$key1."$this->equatorType:".$key2.",";
			$this->equatorType = "=";
		}

		$this->stmt = rtrim($this->stmt, ",");
		return $this;
	}

	private function bind($placeholder, $value) {
		return $this->result->bindValue($placeholder, sprintf("%s", $value), PDO::PARAM_STR);
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