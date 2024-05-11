<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['username']) && $_POST['article']!='' && $_POST['like']!=''):
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require "$root/classes/article.php";
$article = new Article();
$article->setId($_POST['article']);
$like = new Like();
$like->setUsername($_SESSION['username']);
if ( $_POST['like']=='add' ){
	if ($article->addLike($like))
		echo "success";
} elseif ( $_POST['like']=='delete' ) {
	if ($article->deleteLike($like))
		echo "success";
}
endif;
?>