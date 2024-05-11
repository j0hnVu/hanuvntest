<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST"):
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
if (!empty($_SESSION["username"])) {
	require "$root/classes/glossary.php";
	$phr = new Phr();
	$phr->setPhrase($_POST["phrase"]);
	$phr->setMeaning($_POST["meaning"]);
	$phr->setExample($_POST["example"]);
	$glossary = new Glossary($_SESSION["username"]);
	if ($glossary->update($phr))
		echo "success";
} else
	echo "success";
endif;
?>