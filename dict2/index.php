<?php $root = realpath($_SERVER["DOCUMENT_ROOT"]);?>
<?php session_start(); ?>
<head>
	<?php require "$root/0/head.php"?>
	<title>HANU TESTS - Dictionary</title>
	<link rel="stylesheet" href="dict.css">
</head>
<body>
	<?php require "$root/0/nav.php"?>
	<section id="dict">
		<article id="search">
			<h1>ENGLISH DICTIONARY</h1>
			<div>
				<button id="lang">
					<img src="/icon/us.png" id="en-us" height="20" width="40" style="display: none;" title="American English">
					<img src="/icon/uk.png" id="en-gb" height="20" width="40" title="British English">
				</button>
				<input type="text" id="word">
				<button id="mic" title="Voice search">
					<img src="/icon/mic.svg" height="20" width="20">
				</button>
				<button id="searchButton" title="Search">
					<img src="/icon/search.svg" height="20" width="20">
				</button>
			</div>
		</article>
		<div style="display: none;">
			<div style="display: flex; justify-content: center; align-items: center; height: calc(100% - 200px);">
				<div class="loader"></div>
			</div>
		</div>
		<main>
			<div id="left">
				<article>
					<h2>Welcome</h2>
					<div>
						<h3>Give it a go</h3>
						<p class="end"></p>
					</div>
				</article>
			</div>
			<div id="right">
				<article id="images">
					<h2>Images</h2>
					<div>					
						<a href="https://en.wikipedia.org/wiki/United_Kingdom" target="_blank">
							<img src="/icon/uk.png" title="United Kingdom">
						</a>
						<a href="https://en.wikipedia.org/wiki/United_States" target="_blank">
							<img src="/icon/us.png" title="United States">
						</a>
					</div>
				</article>
				<article id="phrasalVerbs">
					<h2>Phrasal verbs</h2>
					<div>
						<p class="end"></p>
						</div>
				</article>
				<article id="phrases">
					<h2>Phrases</h2>
					<div>
						<p class="end"></p>
					</div>
				</article>
				<article id="history">
					<h2>History</h2>
					<div style="display:none;">
						<p class="end"></p>
					</div>
				</article>
			</div>
		</main>
		<script src="dict.js"></script>
	</section>
</body>
<script>
	$("nav>div:nth-child(2)>a:nth-child(2)>img").attr("src","/icon/dict2.svg")
		.css("position","relative").css("top","1.5px")
		.after("<div></div>");
</script>