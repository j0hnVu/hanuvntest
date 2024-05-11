<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require "$root/classes/article.php";
$db = new ArtDb("sum");
$id = $_POST['id'];
$tag = json_decode($_POST['tag']);
$word = json_decode($_POST['word']);
if ($id != 0)
	$array = $db->search($id, 5, $tag, $word);
else
	$array = $db->searchS(5, $tag, $word);
echo json_encode($array);
endif;
?>