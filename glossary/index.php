<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
session_start(); 
if(!empty($_SESSION["username"])):
require "$root/classes/glossary.php";
$glossary = new Glossary($_SESSION["username"]);
$glossary->get();
?>
<head>
	<?php require "$root/0/head.php"?>
	<title>HANU TESTS - Glossary</title>
	<link rel="stylesheet" href="glossary.css">
</head>
<body>
	<?php require "$root/0/nav.php"?>
	<main>
		<article>
			<h1>Glossary Tests</h1>
			<div style="display: none;">
				<section>
					<a href="/practice/fill">Fill in the blank</a>
					<a href="/practice/choice">Multiple choices</a>
					<a href="/practice/connect">Connect phrase - meaning</a>
				</section>
			</div>
		</article>
		<table>
			<tr>
				<th>Phrase</th>
				<th>Meaning</th>
				<th>Note</th>
				<th>Action</th>
			</tr>
			<?php foreach($glossary->arr as $o): ?>
			<tr>
			  	<td class="phrase"><?= $o->phrase ?></td>
			  	<td class="meaning"><?= $o->meaning ?></td>
			  	<td class="example"><?= $o->example ?></td>
			  	<td>
			  		<button title="edit" class="edit"><img src="icon/pen.svg" height="20px"></button>
			  		<button title="remove" class="remove"><img src="icon/remove.svg" height="20px"></button>
			  	</td>
			</tr>
			<?php endforeach; ?>
			<tr>
			  	<td class="phrase"><textarea spellcheck="false" rows="1" required></textarea></td>
			  	<td class="meaning"><textarea spellcheck="false" rows="1"></textarea></td>
			  	<td class="example"><textarea spellcheck="false" rows="1"></textarea></td>
			  	<td>
			  		<button title="add" class="add"><img src="icon/add.svg" height="20px"></button>
			  	</td>
			</tr>
		</table>
	</main>
	<script>
		$("nav>div:nth-child(2)>a:nth-child(3)>img").attr("src","/icon/glossary2.svg")
		.css("position","relative").css("top","1.5px")
		.after("<div></div>");
	</script>
</body>
<script src="glossary.js"></script>

<?php else: ?>
	<head>
	<?php require "$root/0/head.php"?>
	<title>HANU TESTS - Glossary</title>
	<link rel="stylesheet" href="glossary.css">
</head>
<body>
	<?php require "$root/0/nav.php"?>
	<main>
	    <article>
			<h1>Glossary Tests</h1>
			<div style="display: none;">
				<section>
					<a href="">Fill in the blank</a>
					<a href="">Connect phrase - meaning</a>
					<a href="">Multiple choices</a>
				</section>
			</div>
		</article>
				<table>
  					<tr>
    					<th>Phrase</th>
    					<th>Meaning</th>
    					<th>Note</th>
    					<th>Action</th>
  					</tr>
  					<tr>
					  	<td><textarea class="phrase" spellcheck="false" rows="1" required></textarea></td>
					  	<td><textarea class="meaning" spellcheck="false" rows="1"></textarea></td>
					  	<td><textarea class="example" spellcheck="false" rows="1"></textarea></td>
					  	<td>
					  		<button title="add" class="add"><img src="icon/add.svg" height="20px"></button>
					  	</td>
					</tr>
				</table>
	</main>
	<script>
		$("nav>div:nth-child(2)>a:nth-child(3)>img").attr("src","/icon/glossary2.svg")
		.css("position","relative").css("top","1.5px")
		.after("<div></div>");
		warn("Please <a href='/login' style='color: var(--link-blue)'>Log in</a> to use the glossary.");
		$('article>h1').click( function() {
	        $(this).next().slideToggle(700);
        });
	</script>
</body>
<?php endif; ?>
