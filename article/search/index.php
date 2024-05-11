<?php $root = realpath($_SERVER["DOCUMENT_ROOT"]);?>
<?php session_start(); 
if (!empty($_GET["q"])):
?>
<head>
	<?php require "$root/0/head.php"?>
	<title>HANU TESTS</title>
	<link rel="stylesheet" href="/index.css">
</head>
<?php require "$root/0/nav.php"?>
<main>
	<aside>
		<article>
			<div>
				<h2>Developers</h2>
				<h3>Lương Thái Khang</h3>
				Tel: 0904 410 262<br>
				Facebook: <a href="https://www.facebook.com/taekang04" target="_blank">Tae Kang</a>
				<h3>Vũ Hoàng Anh</h3>
				Tel: 0826 167 122<br>
				Facebook: <a href="https://www.facebook.com/hoanganh.owo" target="_blank">Hoang Anh Vu</a>
				<h2 style="margin: 15px 0 5px 0">Contact us</h2>
				<b>Email:</b> mail.fune.cf@gmail.com<br>
				<i>If you have any questions or contribution to our project, we can be contacted by phone, email or facebook.</i>
				<hr>
				<p style="text-align: center;">Copyright © 2021 <b>FunE</b></p>
			</div>
		</article>
	</aside>
	<div>
		<div>
		    <article>
		        <div id="search">
					<button title="Search" onclick="search()">
					    <img src="/icon/search.svg" height="20" width="20">
				    </button>
				    <input type="text" placeholder="#cook chocolate">
				    <button id="mic" title="Voice search">
					    <img src="/icon/mic.svg" height="20" width="20">
				    </button>
			    </div>
		    </article>
		</div>
		<div class="loader"></div>
	</div>
	<aside>
		<article>
			<div>
				<h2>VN Quickstart guide</h2>
				<p><img src="/icon/home.svg" width="25px"> : Trang chủ</p>
				<p><img src="/icon/dict.svg" width="25px"> : Từ điển</p>
				<p><img src="/icon/glossary.svg" width="25px"> : Bảng từ vựng của bạn</p>
				<p><img src="/icon/acc.svg" width="25px"> : Tài khoản</p>
				<iframe src="https://www.youtube.com/embed/73uyypx4eDI" style="border-radius: 5px; width: 100%; aspect-ratio: 16/9;" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				<p></p>
			</div>
		</article>
	</aside>
</main>
<script>
var q = '<?= $_GET["q"] ?>';
</script>
<script src="search.js"></script>
<?php endif; ?>