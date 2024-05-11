<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
session_start(); 
if(!empty($_SESSION["username"])):
require "$root/classes/glossary.php";
$glossary = new GloDb($_SESSION["username"]);
$stmt = $glossary->prepare("(SELECT phrase, meaning FROM {$_SESSION['username']} ORDER BY RAND() LIMIT 10) UNION (SELECT phrase, NULL AS meaning FROM {$_SESSION['username']} ORDER BY RAND() LIMIT 20)");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$arr = $stmt->fetchAll();
?>
<head>
	<?php require "$root/0/head.php"?>
	<title>HANU TESTS - Practice</title>
	<link rel="stylesheet" href="choice.css">
</head>
<body>
	<?php require "$root/0/nav.php"?>
	<main>
		<article>
			<h1>Multiple choices</h1>
			<button onclick="submit()">Submit</button>
		</article>
	</main>
</body>
<script>
	var arr = <?= json_encode($arr) ?>;
</script>
<script src="choice.js"></script>
<?php endif; ?>