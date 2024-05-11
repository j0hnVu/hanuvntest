<?php 
if (!empty($_GET["id"])):
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
session_start();
require "$root/classes/article.php";
$article = new Article();
$article->setId($_GET['id']);
$article = $article->getArt();
?>
<head>
	<?php require "$root/0/head.php"?>
	<title>HANU TESTS</title>
	<link rel="stylesheet" href="article.css">
	<link rel="stylesheet" href="/0/quill.snow.css">
</head>
<?php require "$root/0/nav.php"?>
<main>
	<section>
		<article>
			<div id="tools">
				<button onclick="highlightSelection()"><img src="/icon/highlight-green.svg"></button>
			</div>
			<h1>
				<?= $article->title; ?>
			</h1>
			<div style="margin: 10px 15px;">
				<div class="ql-editor"><?= $article->content; ?></div>
				<div id="info">
					<div>
						<span id="like"><?= $article->like; ?></span>
						<span></span>
					</div>
					<div>
						Posted by <?= $article->username; ?><br>
						<i><?= $article->time; ?></i>
					</div>
				</div>
				<div>
					<button onclick="like()">
						<img src="/icon/like.svg" style="margin:5px 10px 5px 0; height:20px;"> Like
					</button>
					<button onclick="$('div.comment textarea').trigger('focus');">
						<img src="/icon/comment.svg" style="margin:5px 10px 5px 0; height:20px;"> Comment
					</button>
				</div>
				<div>
					<div class="comment">
						<img src="/icon/acc2.svg">
						<div>
							<textarea spellcheck="false" rows="1" placeholder="Write a comment..."></textarea>
						</div>
						<button onclick="comment()">
							<img src="/icon/send.svg" style="width:0">
						</button>
					</div>
					<?php if(!empty($article->commentUser)): ?>
					<div class="comment">
						<img src="/icon/acc2.svg">
						<div>
							<b><?= $article->commentUser; ?></b>
							<div style="white-space: pre-wrap;"><?= $article->commentContent; ?></div>
						</div>
					</div>
					<span onclick="moreComment()">
						<?php 
							$comment = $article->comment - 1;
						    if ($comment > 0)
						        echo"<i>View</i> <i id='comment'>".$comment."</i><i></i>";
						?>
						<i></i>
					</span>
					<?php endif; ?>
				</div>
			</div>
		</article>
	</section>
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
	</section>
</main>
<script src="/dict/dict.js"></script>
<script>
	var username = null;
	var glossary = null;
$( () => {
	<?php if (!empty($_SESSION['username'])): ?>
	article = <?= $article->id ?>;
	username = 	'<?= $_SESSION['username'] ?>';
	var glossary = 
	<?php
		require "$root/classes/glossary.php";
		$glossary = new Glossary($_SESSION["username"]);
		$glossary->getPhrases();
		echo json_encode($glossary->arr);
	?>;
	function yellow() {
		let div = $('.ql-editor');
		var content = div.html();
		glossary.forEach( (obj)=>{
			var time = new Date(obj.time).getTime();
			var length = obj.phrase.length;
			let reg = new RegExp(`[^a-zA-Z>-]${obj.phrase}[^a-zA-Z<-]`, "i");
			while (content.search(reg) != -1) {
				let i = content.search(reg);
				content = content.substring(0,i+length+1) + `</span>` + content.substring(i+length+1);
				content = content.substring(0,i+1) + `<span class='learned' data-time='${time}'>` + content.substring(i+1);
			};
		});
		div.html(content);
		$(".learned").click(function() {
			$('#word').val(this.textContent);
			$('#searchButton').trigger('click');
			$('#search input').trigger('blur');
		});
		$(".learned").mouseenter(function(){
			let title = "Learned " + ago($(this).attr("data-time"));
			$(this).attr("title",title);
		})
	}
	<?php 
		$like = new Like();
		$like->setUsername($_SESSION['username']);
		$like = $article->checkLike($like);
		if ($like)
			echo '$(`[onclick="like()"]>img`).attr("src","/icon/like2.svg");
				$(`[onclick="like()"]`).css("color","var(--dark-blue)");';
	?>
	showData = function(data) {
		let obj = JSON.parse(data);
		console.log(obj);
		let oxf = new Oxf(obj);
		if (oxf.process()) {
			let img = new Img(obj);
			img.process();
			let av = new Av(obj);
			av.process();
			//History
			if (localStorage.dictHistory != '')
				localStorage.dictHistory += '#';
			localStorage.dictHistory += word;
			$('#history>div').prepend('<p class="goto">' + word + '</p>');
			var have = false;
			if (glossary != null)
				glossary.forEach((obj)=>{
					if (obj.phrase.toLowerCase() == word.toLowerCase())
						have = true;
				});
			if (!have)
			$.post(
				'/glossary/add.php',
				{
					'phrase': word,
					'meaning': meaning.trim(),
					'example' : example.trim()
				}, 
				(data) => {
					if (data != "success") {
						warn("You already have this phrase in your glossary. Don't you remember it?");
						console.log(data);
					} else {
						if (glossary != null) {
							let now = new Date();
							let time = `${now.getFullYear()}-${now.getMonth()+1}-${now.getDate()} `;
							time += `${now.getHours()}:${now.getMinutes()}:${now.getSeconds()}`;
							glossary.push({
								'phrase': word,
								'time': time
							});
							yellow();
						}
					}
				}
			);
		} else {
			$('#images').html("").hide();
		}
		//Show
		$('#dict>div').hide();
		$('#dict>main').fadeIn();
		addEvents();
	}
	if (glossary != null) yellow();
	<?php endif; ?>
});
</script>
<script src="article.js"></script>
<?php endif; ?>