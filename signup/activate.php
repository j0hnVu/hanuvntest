<?php if (!empty($_GET["id"])): ?>
	<?php
		$root = realpath($_SERVER["DOCUMENT_ROOT"]);
		require "$root/classes/account.php";
		$acc = new Account();
		$acc->setId($_GET["id"]);
	?>
	<?php if($acc->verify()): ?>
	<head>
		<?php require "$root/0/head.php"?>
		<title>HANU TESTS - Verify</title>
		<style>
			main {
				display: flex;
				flex-direction: column;
				align-items: center;
				margin-top: 10px;
			}
			article {
				display: flex;
				flex-direction: column;
				background-color: white;
				border-radius: var(--radius);
				box-shadow: var(--shadow);
				margin: 10px;
				padding: 15px;
				max-width: calc(100% - 50px);
				font-size: 120%;
			}
			article>img {
				align-self: center;
				margin-bottom: 10px;
			}
		</style>
	</head>
	<?php require "$root/0/nav.php"?>
	<main>
		<article>
			<img src="/icon/hanu.png" height="60px">
			<div>
				Your account has been activated. You can log in now.
			</div>
		</article>
	</main>
	<?php endif; ?>
<?php endif; ?>