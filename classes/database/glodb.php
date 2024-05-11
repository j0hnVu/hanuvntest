<?php
class GloDb extends PDO {
	private const host = "localhost";
	private const dbname = "funecfte_glossaries";
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
	    $stmt = $this->prepare("SHOW TABLES WHERE `Tables_in_".self::dbname."` = :table");
		$stmt->bindParam(":table", $table);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$select = $stmt->fetchAll();
		if (count($select) < 1) {
			$db = self::dbname;
			$stmt = $this->prepare("CREATE TABLE IF NOT EXISTS $db.$table (`phrase` VARCHAR(225) NOT NULL , `meaning` TEXT NULL , `example` TEXT NULL , `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`phrase`)) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
			$stmt->execute();
		}
		$this->table = $table;
	}
	//SELECT
	function select($column,$key,$value) {
		$table = $this->table;
		$stmt = $this->prepare("SELECT $column FROM $table WHERE $key = :value");
		$stmt->bindParam(":value", $value);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, "Phr");
		return $stmt->fetchAll();
	}
    //SELECT ALL
	function selectAll($order) {
		$table = $this->table;
		$stmt = $this->prepare("SELECT * FROM $table ORDER BY `$order`");
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, "Phr");
		return $stmt->fetchAll();
	}
	//SELECT LIMIT
	function selectLim($column,$lim) {
		$table = $this->table;
		$stmt = $this->prepare("SELECT $column FROM $table ORDER BY `time` DESC LIMIT :lim");
		$stmt->bindParam(":lim", $lim, PDO::PARAM_INT);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}
	//SELECT RANDOM
	function selectRand($column,$lim) {
		$table = $this->table;
		$stmt = $this->prepare("SELECT $column FROM $table ORDER BY RAND() DESC LIMIT :lim");
		$stmt->bindParam(":lim", $lim, PDO::PARAM_INT);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, "Phr");
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
	//INSERT
	function insert($phr) {
		$table = $this->table;
		$stmt = $this->prepare("INSERT INTO $table VALUES (:phrase,:meaning,:example,CURRENT_TIMESTAMP)");
		$stmt->bindParam(":phrase", $phr->phrase);
		$stmt->bindParam(":meaning", $phr->meaning);
		$stmt->bindParam(":example", $phr->example);
		return $stmt->execute();
	}
	//DELETE
	function delete($phr) {
		$table = $this->table;
	    $stmt = $this->prepare("DELETE FROM $table WHERE phrase = :phrase");
		$stmt->bindParam(":phrase", $phr->phrase);
		return $stmt->execute();
	}
	//UPDATE
	function update($phr) {
		$table = $this->table;
		$stmt = $this->prepare("UPDATE $table SET meaning = :meaning, example = :example WHERE phrase = :phrase");
		$stmt->bindParam(":phrase", $phr->phrase);
		$stmt->bindParam(":meaning", $phr->meaning);
		$stmt->bindParam(":example", $phr->example);
		return $stmt->execute();
	}
}
	//catch(PDOException $exp)
	//	echo "Error: " . $exp->getMessage();
?>