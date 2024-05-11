<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['username']) && $_POST['content']!=''):
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require "$root/classes/article.php";
$article = new Article();
$article->setId($_POST['article']);
$comment = new Comment();
$comment->setUsername($_SESSION['username']);
$comment->setContent($_POST['content']);
if ($article->addComment($comment))
	echo json_encode($comment);
endif;
?>