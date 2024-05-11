<?php
class AccDb extends PDO {
	private const host = "localhost";
	private const dbname = "funecfte_accounts";
	private const username = "funecfte_db";
	private const password = "170788";
	private $table;
	//CONNECT TO DATABASE
	function __construct($table = "") {
		parent::__construct("mysql:host=".self::host."; dbname=".self::dbname."; charset=UTF8", self::username, self::password);
		$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if ($table != "")
			$this->setTable($table);
	}
	//SET TABLE
	function setTable($table) {
		if ($table=="verified" || $table=="unverified")
			$this->table = $table;
		else 
			throw new PDOException("Invalid table");
	}
	//SELECT
	function select($column,$key,$value) {
		$table = $this->table;
		$stmt = $this->prepare("SELECT $column FROM $table WHERE $key = :value");
		$stmt->bindParam(":value", $value);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_OBJ);
		return $stmt->fetchAll();
	}
	//CHECK
	function check($key,$value) {
		$select = $this->select($key,$key,$value);
		if (count($select) > 0)
			return true;
		else
			return false;
	}
	//CHECK BOTH TABLE
	function checkBoth($key,$value) {
		$prepare = "SELECT $key FROM unverified WHERE $key = :key UNION";
		$prepare .= " SELECT $key FROM verified WHERE $key = :key";
		$stmt = $this->prepare($prepare);
		$stmt->bindParam(":key", $value);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$select = $stmt->fetchAll();
		if (count($select) > 0)
			return true;
		else
			return false;
	}
	//INSERT
	function insert($account) {
		if ($this->table === "unverified") {
			$stmt = $this->prepare("INSERT INTO unverified VALUES (:username,:email,:password,:fullname,:gender,:birth,:id)");
			$stmt->bindParam(":username", $account->username);
			$stmt->bindParam(":email", $account->email);
			$stmt->bindParam(":password", $account->password);
			$stmt->bindParam(":fullname", $account->fullname);
			$stmt->bindParam(":gender", $account->gender);
			$stmt->bindParam(":birth", $account->birth);
			$stmt->bindParam(":id", $account->id);
			$stmt->execute();
		}
		if ($this->table === "verified") {
			$stmt = $this->prepare("INSERT INTO verified SELECT username,email,password,fullname,gender,birth FROM unverified WHERE id = :id");
			$stmt->bindParam(":id", $account->id);
			if ($stmt->execute()) {
				$stmt = $this->prepare("DELETE FROM unverified WHERE id = :id");
				$stmt->bindParam(":id", $account->id);
				$stmt->execute();
			}
		}
	}
	//UPDATE
	function update($account,$array) {
		if ($this->table !== "verified")
			throw new PDOException("Invalid table");
		else {
			$set = "";
			foreach ($array as $property)
				$set .= "$property = :$property,";
			$set = chop($set,",");
			$stmt = $this->prepare("UPDATE verified SET $set WHERE username = :username");
			$stmt->bindParam(":username",$account->$username);
			foreach ($array as $property)
				$stmt->bindParam(":$property",$account->$property);
			$stmt->execute();
		}
	}
}
	//catch(PDOException $exp)
	//	echo "Error: " . $exp->getMessage();
?>