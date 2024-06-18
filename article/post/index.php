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
	<section style="display: flex; flex-direction: column; justify-content: center">
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
</main>
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