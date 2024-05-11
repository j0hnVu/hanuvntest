<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
session_start(); 
if(!empty($_SESSION["username"])):
require "$root/classes/glossary.php";
$glossary = new Glossary($_SESSION["username"]);
$glossary->getRand();
$arr = $glossary->arr;
?>
<head>
	<?php require "$root/0/head.php"?>
	<title>HANU TESTS - Practice</title>
	<link rel="stylesheet" href="fill.css">
</head>
<body>
	<?php require "$root/0/nav.php"?>
	<main>
		<article>
			<h1>Fill in the blank</h1>
			<?php $i=1; foreach($arr as $o): ?>
			  	<div>
			  		<div><?= $i.")" ?></div>
			  		<div><?= $o->meaning ?></div>
			  	</div>
			  	<textarea data-ans='<?= $o->phrase ?>' spellcheck="false" rows="1"></textarea>
			  	<?php $i++?>
			<?php endforeach; ?>
			<button onclick="submit()">Submit</button>
		</article>
	</main>
</body>
<script src="fill.js"></script>
<?php endif; ?>