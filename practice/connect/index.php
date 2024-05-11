<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
session_start(); 
if(!empty($_SESSION["username"])):
require "$root/classes/glossary.php";
$glossary = new Glossary($_SESSION["username"]);
$glossary->getRand(10);
$arr = $glossary->arr;
?>
<head>
	<?php require "$root/0/head.php"?>
	<title>HANU TESTS - Practice</title>
	<link rel="stylesheet" href="connect.css">
</head>
<body>
	<?php require "$root/0/nav.php"?>
	<main>
		<div>
		<article>
			<div>
		    <?php $i=1; foreach($arr as $o): ?>
		        <span class="phrase"><?= $o->phrase ?></span>
		    <?php endforeach; shuffle($arr) ?>
			</div>
		</article>
		</div>
		<article>
			<?php $i=1; foreach($arr as $o): ?>
			  	<div class="question">
			  		<div><?= $i.")" ?></div>
			  		<div><?= $o->meaning ?></div>
			  	</div>
			  	<span class="blank" data-ans="<?= $o->phrase?>"></span>
			  	<?php $i++?>
			<?php endforeach; ?>
			<button onclick="submit()">Submit</button>
		</article>
	</main>
</body>
<script src="connect.js"></script>
<?php endif; ?>