<?php

class UserModel extends Model {
	protected const TABLE = "user";

	public function addPerson($name, $email, $password) {
		try {
			$this->db->saveInto("INSERT", self::TABLE, [
				":password" => $password,
				":email" => $email,
				":name" => $name
			])->execute();
		} catch (PDOException $bug) {
			die($bug->getMessage());
		}
	}

	public function getAll($tracker, $autoLoad) {
		$limits = $autoLoad === 0 ? [$tracker, 10] : [0, $autoLoad];

		$data = $this->db->select(["user.name,user.email"])->from(self::TABLE)
			->where(["admin"=>0])->limit($limits[0], $limits[1])
			->fetch();

		if ($data !== false) {
			return [
				"count" => $this->numberOfUsers(),
				"data" => $data
			];
		}

		return $data;
	}

	protected function get($column, $value) {
		$data = $this->db->select()->from(self::TABLE)
			->where([$column=>$value])
			->fetch();

		return is_array($data) ? $data[0] : false;
	}
	
	public function getByEmail($email) {
		return $this->get("email", $email);
	}

	public function getById($id) {
		return $this->get("id", $id);
	}

	public function numberOfUsers() {
		return $this->db->selectCount("id")
			->from(self::TABLE)->where(["admin"=>0])
			->fetch(false, true)[0][0];
	}
}

?>