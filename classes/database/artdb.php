<?php
class ArtDb extends PDO {
	private const host = "localhost";
	private const dbname = "funecfte_articles";
	private const username = "funecfte_db";
	private const password = "170788";
	private const tbs = ["article","comment","like","report","topic","sum","tag"];
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
		if (!in_array($table,self::tbs)) {
        	throw new PDOException("Invalid table");
        	return false;
    	}
		$this->table = $table;
	}
	//SELECT
	function select($column,$key,$value,$class) {
		$table = $this->table;
		$stmt = $this->prepare("SELECT $column FROM $table WHERE $key = :value");
		$stmt->bindParam(":value", $value);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, $class);
		return $stmt->fetchAll();
	}
	//SEARCH
	function search($id, $lim, $tag, $word) {
	    $prepare = "SELECT id, title, tag, preview, `like`, `comment`, `preview2` FROM `sum` WHERE ";
	    foreach ($tag as $value)
	    	$prepare .= "LOWER(tag) LIKE '%,{$value},%' AND ";
	    foreach ($word as $value)
	    	$prepare .= "(LOWER(title) LIKE '%{$value}%' OR LOWER(content) LIKE '%{$value}%') AND ";
	    $prepare .= "id < $id ORDER BY id DESC LIMIT $lim";
	    $stmt = $this->prepare($prepare);
	    $stmt->execute();
	    $stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}
	//SEARCH START
	function searchS($lim, $tag, $word) {
	    $prepare = "SELECT id, title, tag, preview, `like`, `comment`, `preview2` FROM `sum` WHERE ";
	    foreach ($tag as $value)
	    	$prepare .= "LOWER(tag) LIKE '%,{$value},%' AND ";
	    foreach ($word as $value)
	    	$prepare .= "(LOWER(title) LIKE '%{$value}%' OR LOWER(content) LIKE '%{$value}%') AND ";
	    $prepare = substr($prepare, 0, strlen($prepare)-4);
	    $prepare .= "ORDER BY id DESC LIMIT $lim";
	    $stmt = $this->prepare($prepare);
	    $stmt->execute();
	    $stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}
	//SELECT LIMIT
	function selectLim($column,$id,$lim) {
		$table = $this->table;
		$stmt = $this->prepare("SELECT $column FROM $table WHERE id < :id ORDER BY id DESC LIMIT :lim");
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt->bindParam(":lim", $lim, PDO::PARAM_INT);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}
	//SELECT LIMIT START
	function selectLimS($column,$lim) {
		$table = $this->table;
		$stmt = $this->prepare("SELECT $column FROM $table ORDER BY id DESC LIMIT :lim");
		$stmt->bindParam(":lim", $lim, PDO::PARAM_INT);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}
	//SELECT LIMIT
	function selectLim2($column,$username,$id,$lim) {
		$table = $this->table;
		$stmt = $this->prepare("SELECT $column FROM $table WHERE username = :username AND id < :id ORDER BY id DESC LIMIT :lim");
		$stmt->bindParam(":username", $username);
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt->bindParam(":lim", $lim, PDO::PARAM_INT);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}
	//SELECT LIMIT START
	function selectLimS2($column,$username,$lim) {
		$table = $this->table;
		$stmt = $this->prepare("SELECT $column FROM $table WHERE username = :username ORDER BY id DESC LIMIT :lim");
		$stmt->bindParam(":username", $username);
		$stmt->bindParam(":lim", $lim, PDO::PARAM_INT);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}
	//SELECT ALL
	function selectAll($class) {
		$table = $this->table;
		$stmt = $this->prepare("SELECT * FROM $table");
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, $class);
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
	function checkLike($obj) {
		$stmt = $this->prepare("SELECT username FROM `like` WHERE article = :article AND username = :username");
		$stmt->bindParam(":username", $obj->username);
		$stmt->bindParam(":article", $obj->article);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$select = $stmt->fetchAll();
		if (count($select) > 0)
			return true;
		else
			return false;
	}
	//INSERT
	function insert($obj) {
		if ($this->table === "article") {
			$stmt = $this->prepare("INSERT INTO article VALUES (NULL, :title, :username, CURRENT_TIMESTAMP, :tag, :preview, :preview2, :content)");
			$stmt->bindParam(":title", $obj->title);
			$stmt->bindParam(":username", $obj->username);
			$stmt->bindParam(":tag", $obj->tag);
			$stmt->bindParam(":preview", $obj->preview);
			$stmt->bindParam(":preview2", $obj->preview2);
			$stmt->bindParam(":content", $obj->content);
			return $stmt->execute();
		}
		if ($this->table === "like") {
			$stmt = $this->prepare("INSERT INTO `like` VALUES (:username, :article)");
			$stmt->bindParam(":username", $obj->username);
			$stmt->bindParam(":article", $obj->article);
			return $stmt->execute();
		}
		if ($this->table === "comment" || $this->table === "report") {
		    $stmt = $this->prepare("INSERT INTO {$this->table} VALUES (NULL, :username, :article, CURRENT_TIMESTAMP, :content)");
		    $stmt->bindParam(":username", $obj->username);
			$stmt->bindParam(":article", $obj->article);
			$stmt->bindParam(":content", $obj->content);
			return $stmt->execute();
		}
		if ($this->table === "topic") {
		    $prepare = "INSERT IGNORE INTO `topic` VALUES ";
		    foreach ($obj as $key=>$value)
		        $prepare .= "(:$key),";
            $prepare = rtrim($prepare,",");
			$stmt = $this->prepare($prepare);
			foreach ($obj as $key=>$value)
		        $stmt->bindValue(":$key", $value);
			return $stmt->execute();
		}
	}
	//DELETE
	function delete($obj) {
		if ($this->table === "article") {
			$stmt = $this->prepare("DELETE FROM article WHERE id = :id");
			$stmt->bindParam(":id", $obj->id, PDO::PARAM_INT);
			return $stmt->execute();
		}
		if ($this->table === "like") {
			$stmt = $this->prepare("DELETE FROM `like` WHERE article = :article AND username = :username");
			$stmt->bindParam(":username", $obj->username);
			$stmt->bindParam(":article", $obj->article);
			return $stmt->execute();
		}
		if ($this->table === "comment" || $this->table === "report") {
		    $stmt = $this->prepare("DELETE FROM {$this->table} WHERE id = :id");
		    $stmt->bindParam(":id", $obj->id, PDO::PARAM_INT);
			return $stmt->execute();
		}
	}
	//UPDATE
	function update($obj) {
		if ($this->table === "article") {
			$stmt = $this->prepare("UPDATE article SET title = :title, username = :username, time = :time, tag = :tag, content = :content WHERE id = :id");
			$stmt->bindParam(":title", $obj->title);
			$stmt->bindParam(":username", $obj->username);
			$stmt->bindParam(":time", $obj->time);
			$stmt->bindParam(":tag", $obj->tag);
			$stmt->bindParam(":content", $obj->content);
			$stmt->bindParam(":id", $obj->id);
			$stmt->execute();
		}
		if ($this->table === "comment" || $this->table === "report") {
		    $stmt = $this->prepare("UPDATE :table SET username = :username, article = :article, time = :time, content = :content WHERE id = :id");
		    $stmt->bindParam(":table", $obj->table);
		    $stmt->bindParam(":username", $obj->username);
			$stmt->bindParam(":article", $obj->article);
			$stmt->bindParam(":time", $obj->time);
			$stmt->bindParam(":content", $obj->content);
			$stmt->bindParam(":id", $obj->id);
			$stmt->execute();
		}
	}
}
	//catch(PDOException $exp)
	//	echo "Error: " . $exp->getMessage();
?>