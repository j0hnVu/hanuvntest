<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
session_start();
if (!empty($_SESSION["username"])):
?>
<head>
	<?php require "$root/0/head.php"?>
	<title>HANU TESTS - New Post</title>
	<link rel="stylesheet" href="post.css">
	<script src="/0/quill.min.js"></script>
	<link href="/0/quill.snow.css" rel="stylesheet">
</head>
<?php require "$root/0/nav.php"?>
<main>
	<section>
		<div>
		<article style="margin:0 10px;background-color: var(--light-green);">
			<div id="toolbar">
				<span class="ql-formats">
					<select class="ql-size"></select>
				</span>
				<span class="ql-formats">
					<button class="ql-bold"></button>
					<button class="ql-italic"></button>
					<button class="ql-underline"></button>
					<button class="ql-strike"></button>
				</span>
				<span class="ql-formats">
					<select class="ql-color"></select>
				</span>
				<span class="ql-formats">
					<button class="ql-script" value="sub"></button>
					<button class="ql-script" value="super"></button>
				</span>
				<span class="ql-formats">
					<select class="ql-align"></select>
					<button class="ql-indent" value="+1"></button>
					<button class="ql-indent" value="-1"></button>
				</span>
				<span class="ql-formats">
					<button class="ql-link"></button>
					<button class="ql-image"></button>
					<button class="ql-video"></button>
				</span>
			</div>
		</article>
		</div>
		<article>
			<h1>
				<textarea rows="1" placeholder="TITLE" required></textarea>
			</h1>
			<div id="editor"></div>
		</article>
		<article style="padding: 10px 15px; flex-direction: row;">
			<span style="margin-right: 10px;">Tags: </span>
			<textarea rows="1" placeholder='#science #AlbertEinstein #energy' required></textarea>
		</article>
		<div>
			<button onclick="post()">Submit</button>
		</div>
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
	var quill = new Quill('#editor', {
		modules: {
			toolbar: '#toolbar',
			history: {
      			delay: 500,
      			maxStack: 200,
      			userOnly: false
    		}
		},
		theme: 'snow',
		placeholder: 'Compose your post...',
		formats: [
			"size",
			"bold",	"italic", "underline", "strike",
			"color",
			"script",
			"align", "indent",
			"link", "image", "video"
		]
	});
</script>
<script src="post.js"></script>
<?php endif; ?>