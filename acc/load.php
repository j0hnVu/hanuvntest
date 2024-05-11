<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['username'])):
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require "$root/classes/article.php";
$db = new ArtDb("sum");
$id = $_POST['id'];
if ($id != 0)
	$array = $db->selectLim2("id, title, preview, `like`, `comment`, `preview2`", $_SESSION['username'], $id, 5);
else
	$array = $db->selectLimS2("id, title, preview, `like`, `comment`, `preview2`", $_SESSION['username'], 5);
echo json_encode($array);
endif;
?>