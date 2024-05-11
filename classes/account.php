<?php
require "database/accdb.php";
function encode($str) {
	if ($str == "")
		throw new Exception("Cannot encode NULL");
	$algo = array("adler32","crc32","crc32b","fnv132","fnv1a32","joaat");
	$num = ord($str) % 6;
	$algo = $algo[$num];
	$code = hash($algo, $str);
	return strrev($code);
}
function test($input) {
	$input = trim($input,"\0\t\n\x0B\r");
	$input = htmlspecialchars($input);
	return $input;
}
class Account {
	public $username, $email, $password;
	public $fullname, $gender, $birth;
	public $id;
	function isSet($array) {
		foreach ($array as $property) {
			if ($this->$property == null) {
				throw new Exception("Not enough Information");
				return false;
			}
		}
		return true;
	}
	function setEmail($input) {
		$input = test($input);
		$this->email = $input;
	}
	function setPassword($input) {
		$this->password = encode($input);
	}
	function setUsername($input) {
		$input = test($input);
		if (!preg_match("/^[a-zA-Z0-9_]*$/",$input))
			throw new Exception("Invalid Username");
		else
			$this->username = $input;
	}
	function setFullname($input) {
		$input = test($input);
		if (strlen($input) < 1)
			throw new Exception("Invalid Full Name");
		elseif (strlen($input) > 225)
			throw new Exception("Invalid Full Name");
		else
			$this->fullname = $input;
	}
	function setGender($input) {
		$input = test($input);
		if ($input !== "male" && $input !== "female")
			throw new Exception("Invalid Gender");
		else
			$this->gender = $input;
	}
	function setBirth($input) {
		$input = test($input);
		if (!preg_match("/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/",$input))
			throw new Exception("Invalid Birth Date");
		else {
			$ar = explode("-",$input);
			$check = checkdate($ar[1], $ar[2], $ar[0]);
			if (!$check)
				throw new Exception("Invalid Birth Date");
			else
				$this->birth = $input;
		}
	}
	function setId($input) {
		$input = test($input);
		if (strlen($input) < 1)
			throw new Exception("Invalid Id");
		else
			$this->id = $input;
	}
	function checkEmail() {
		$properties = array("email");
		if ($this->isSet($properties)) {
			$db = new AccDb();
			return $db->checkBoth("email", $this->email);
		}
	}
	function checkUsername() {
		$properties = array("username");
		if ($this->isSet($properties)) {
			$db = new AccDb();
			return $db->checkBoth("username", $this->username);
		}
	}
	function signUp() {
		$this->setId(uniqid(bin2hex(random_bytes(8))));
		$properties = array("username","email","password","fullname","gender","birth","id");
		if ($this->isSet($properties)) {
			$db = new AccDb("unverified");
			$db->insert($this);
		}
	}
	function verify() {
		$properties = array("id");
		if ($this->isSet($properties)) {
			$db = new AccDb("unverified");
			$arr = $db->select("*", "id", $this->id);
			if (count($arr)<1)
				return false;
			$acc = $arr[0];
			$db = new AccDb("verified");
			$db->insert($acc);
			return true;
		}
	}
	function logIn() {
		$properties = array("email","password");
		if ($this->isSet($properties)) {
			$db = new AccDb("verified");
			$arr = $db->select("password, username", "email", $this->email);
			if (count($arr)>0)
				$obj = $arr[0];
			if (isset($obj->password))
				if ($obj->password == $this->password) {
					$this->username = $obj->username;
					return true;
				}
			return false;
		}
	}
	function logInGoogle() {
		$properties = array("email");
		if ($this->isSet($properties)) {
			$db = new AccDb("verified");
			$arr = $db->select("username", "email", $this->email);
			if (count($arr)>0) {
				$obj = $arr[0];
				$this->username = $obj->username;
				return true;
			} else
				return false;
		}
	}
	function getInfo() {
		$properties = array("username");
		if ($this->isSet($properties)) {
			$db = new AccDb("verified");
			$obj = $db->select("*", "username", $this->username)[0];
			$this->email = $obj->email;
			$this->password = $obj->password;
			$this->fullname = $obj->fullname;
			$this->gender = $obj->gender;
			$this->birth = $obj->birth;
		}
	}
	function changeFullname() {
		$properties = array("username","fullname");
		if ($this->isSet($properties)) {
			$db = new AccDb("verified");
			$array = array("fullname");
			$obj = $db->update($this, $array);
		}
	}
	function changeGender() {
		$properties = array("username","gender");
		if ($this->isSet($properties)) {
			$db = new AccDb("verified");
			$array = array("gender");
			$obj = $db->update($this, $array);
		}
	}
	function changeBirth() {
		$properties = array("username","birth");
		if ($this->isSet($properties)) {
			$db = new AccDb("verified");
			$array = array("birth");
			$obj = $db->update($this, $array);
		}
	}
	function changePassword() {
		$properties = array("username","password");
		if ($this->isSet($properties)) {
			$db = new AccDb("verified");
			$array = array("password");
			$obj = $db->update($this, $array);
		}
	}
	function changeEmail() {
		$properties = array("username","email");
		if ($this->isSet($properties)) {
			$db = new AccDb("verified");
			$array = array("email");
			$obj = $db->update($this, $array);
		}
	}
}