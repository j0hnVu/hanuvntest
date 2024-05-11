<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require "$root/classes/article.php";
$db = new ArtDb("sum");
$id = $_POST['id'];
if ($id != 0)
	$array = $db->selectLim("id, title, tag, preview, `like`, `comment`, `preview2`", $id, 5);
else
	$array = $db->selectLimS("id, title, tag, preview, `like`, `comment`, `preview2`", 5);
echo json_encode($array);
endif;
?>