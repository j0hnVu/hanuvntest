<?php
require "database/artdb.php";
function test($input) {
	$input = trim($input,"\0\t\n\x0B\r");
	$input = htmlspecialchars($input);
	return $input;
}
class Comment {
	public $id, $username, $article, $time, $content;
	function setId($id) {
		$this->id = test($id);
	}
	function setUsername($username) {
		$this->username = test($username);
	}
	function setArticle($article) {
		$this->article = test($article);
	}
	function setTime($time) {
		$this->time = test($time);
	}
	function setContent($content) {
		$this->content = test($content);
	}
	function setNow() {
		date_default_timezone_set("Asia/Ho_Chi_Minh");
		$this->time = date("Y-m-d H:i:s");
	}
}
class Report extends Comment {}
class Like {
	public $username, $article;
	function setUsername($username) {
		$this->username = test($username);
	}
	function setArticle($article) {
		$this->article = test($article);
	}
}
class Article {
	public $id, $title, $username, $time, $tag, $preview, $preview2, $content;
	public $like, $comment, $report, $commentUser, $commentContent;
	private $articleDb, $likeDb, $commentDb, $reportDb, $topicDb;
	function __construct() {
	    $this->articleDb = new ArtDb("article");
		$this->likeDb = new ArtDb("like");
		$this->commentDb = new ArtDb("comment");
		$this->reportDb = new ArtDb("report");
		$this->topicDb = new ArtDb("topic");
	}
	function isSet($array) {
		foreach ($array as $property) {
			if ($this->$property == null || $this->$property == "") {
				throw new Exception("Not enough Information");
				return false;
			}
		}
		return true;
	}
	function setId($id) {
		$this->id = test($id);
	}
	function setTitle($title) {
		$this->title = test($title);
	}
	function setUsername($username) {
		$this->username = test($username);
	}
	function setTime($time) {
		$this->time = test($time);
	}
	function setTag($tag) {
		$tag = test($tag);
		$this->tag = $tag;
	}
	function setPreview($preview) {
		$this->preview = $preview;
	}
	function setPreview2($preview2) {
		$this->preview2 = $preview2;
	}
	function setContent($content) {
		$this->content = $content;
	}
	function addArt() {
	    $property = ["username","title","content","tag","preview2"];
	    if ($this->isSet($property)) {
	        $arr = explode(",",strtolower(trim($this->tag,",")));
	        return ($this->articleDb->insert($this) && $this->topicDb->insert($arr));
	    }
	}
	function addComment($comment) {
		$property = array("id");
		if ($this->isSet($property)) {
			$comment->setArticle($this->id);
			return $this->commentDb->insert($comment);
		}
	}
	function addReport($report) {
		$this->reportDb->insert($report);
	}
	function addLike($like) {
		$like->article = $this->id;
		return $this->likeDb->insert($like);
	}
	function deleteLike($like) {
		$like->article = $this->id;
		return $this->likeDb->delete($like);
	}
	function checkLike($like) {
		$like->article = $this->id;
		return $this->likeDb->checkLike($like);
	}
	function getArt() {
	    $property = array("id");
		if($this->isSet($property)) {
	        $this->articleDb = new ArtDb("sum");
	        $arr = $this->articleDb->select("*", "id", $this->id, "Article");
	        if(count($arr)==1) {
	        	return $arr[0];
	        } else
	        	echo "<script>window.onload=()=>warn('The article doesn\'t exist or has been deleted')</script>";
		}
	}
	function getComment() {
	    $property = array("id");
		if($this->isSet($property))
		    return $this->commentDb->select("id,username,time,content", "article", $this->id, "Comment");
	}
}