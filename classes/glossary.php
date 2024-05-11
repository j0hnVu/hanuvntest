<?php
require "database/glodb.php";
if (!function_exists('test')) {
function test($input) {
	$input = trim($input,"\0\t\n\x0B\r");
	$input = htmlspecialchars($input);
	return $input;
}
}
class Phr {
	public $phrase, $meaning, $example, $time;
    function setPhrase($phrase) {
    	$this->phrase = test($phrase);
    }
    function setMeaning($meaning) {
    	$this->meaning = test($meaning);
    }
    function setExample($example) {
    	$this->example = test($example);
    }
}
class Glossary {
	function __construct($username) {
		$this->username = $username;
		$this->db = new GloDb($username);
		$this->arr = array();
	}
	function get() {
	    $this->arr = $this->db->selectAll("time");
	}
	function getPhrases() {
		$this->arr = $this->db->selectLim("phrase,`time`",20);
	}
	function getRand() {
		$this->arr = $this->db->selectRand("phrase,meaning",10);
	}
	function add($phr) {
	    return $this->db->insert($phr);
	}
	function update($phr) {
	    return $this->db->update($phr);
	}
	function remove($phr) {
	    return $this->db->delete($phr);
	}
}