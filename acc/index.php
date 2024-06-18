<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
session_start();
if (!empty($_SESSION["username"])):
require "$root/classes/account.php";
$acc = new Account();
$acc->setUsername($_SESSION["username"]);
$acc->getInfo();
?>
<head>
	<?php require "$root/0/head.php"?>
	<title>HANU TESTS - My account</title>
	<link rel="stylesheet" href="acc.css">
</head>
<?php require "$root/0/nav.php"?>
<main>
	<aside>
		<article>
			<div>
				<h2>My accounts</h2>
				<p>Username: <?=$_SESSION["username"]?></p>
				<p>Full name: <?=$acc->fullname?></p>
				<p style="word-break: break-all;">Email: <?=$acc->email?></p>
				<p>Gender: <?=$acc->gender?></p>
				<p>Date of Birth: <?=$acc->birth?></p>
				<p></p>
			</div>
		</article>
	</aside>
	<div>
		<div></div>
		<div class="loader"></div>
	</div>
	<aside>
	</aside>
</main>
<script src="acc.js"></script>
<?php endif; ?>