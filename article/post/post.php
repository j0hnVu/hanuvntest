<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['username']) && $_POST['content']!='' && $_POST['title']!='' && $_POST['tag']!=''):
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require "$root/classes/article.php";
$article = new Article();
$article->setUsername($_SESSION['username']);
$article->setTitle($_POST['title']);
$article->setContent($_POST['content']);
$article->setTag($_POST['tag']);
$article->setPreview2($_POST['preview2']);
if ($_POST['length']!="0") {
	$preview = iconv_substr($_POST['content'],$_POST['preview'],$_POST['length']);
	$article->setPreview($preview);
} else $article->setPreview(null);
if ($article->addArt())
	echo "success";
endif;
?>