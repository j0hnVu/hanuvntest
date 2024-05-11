<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require "$root/classes/article.php";
$article = new Article();
$article->setId($_POST['article']);
echo json_encode($article->getComment());
endif;
?>