<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST"):
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require "$root/classes/glossary.php";
$phr = new Phr();
$phr->setPhrase($_POST["phrase"]);
$glossary = new Glossary($_SESSION["username"]);
	$glossary->remove($phr);
	echo "success";
endif;
?>