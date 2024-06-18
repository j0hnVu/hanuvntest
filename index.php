<?php $root = realpath($_SERVER["DOCUMENT_ROOT"]);?>
<?php session_start(); ?>
<head>
	<?php require "$root/0/head.php"?>
	<title>HANU TESTS</title>
	<link rel="stylesheet" href="index.css">
</head>
<?php require "$root/0/nav.php"?>
<main>
	<div>
		<div>
		    <article>
		        <div id="search">
					<button title="Search" onclick="search()">
					    <img src="/icon/search.svg" height="20" width="20">
				    </button>
				    <input type="text" placeholder="Search something :3">
				    <button id="mic" title="Voice search">
					    <img src="/icon/mic.svg" height="20" width="20">
				    </button>
			    </div>
		    </article>
		</div>
		<div class="loader"></div>
	</div>
</main>
<script src="index.js"></script>