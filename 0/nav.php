<div id="warn">
	<h3>
		<div style="text-align: center;">For best view, turn your device sideways</div>
		<svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 73">
			<style>
				#Layer_1{padding: 20px 30px 5px 30px;}
				.st0{fill:#004aac;stroke:#004aac;stroke-width:2;stroke-miterlimit:10}
				.st1{fill:#fff}
				.st2,.st3,.st4{fill:#004aac;stroke:#004aac;stroke-width:2;stroke-linecap:round;stroke-miterlimit:10}
				.st3{stroke-dasharray:2.5799,4.6907}
				.st4{stroke-linejoin:round}
			</style>
			<path class="st0" d="M2.1 7v59c0 2.8 2.3 5 5 5H34c2.8 0 5-2.3 5-5V7c0-2.8-2.3-5-5-5H7.2C4.4 2 2.1 4.3 2.1 7z"/>
			<path class="st1" d="M2.1 10H39v51.8H2.1zM20.6 67.4c-.4 0-.7-.1-.9-.3-.3-.2-.4-.5-.4-1 0-.3.1-.6.4-.9.2-.3.5-.4.9-.4s.7.1.9.4c.3.2.4.5.4.9s-.1.7-.4 1c-.3.2-.6.3-.9.3z"/>
			<g>
				<path class="st0" d="M121.6 71H62.7c-2.8 0-5-2.3-5-5V39.1c0-2.8 2.3-5 5-5h58.9c2.8 0 5 2.3 5 5V66c0 2.7-2.2 5-5 5z"/>
				<path class="st1" d="M66.9 34.1h51.8V71H66.9zM61.6 51.6c.2-.3.5-.4 1-.4.4 0 .7.1.9.4.2.3.4.6.4.9 0 .4-.1.7-.4.9-.3.2-.5.4-.9.4s-.7-.1-1-.4c-.2-.3-.3-.6-.3-.9-.1-.3.1-.6.3-.9z"/>
			</g>
			<g>
				<path class="st2" d="M64.5 19.6c-.2-.3-.3-.7-.5-1"/>
				<path class="st3" d="M61.3 14.8c-2.7-3-6.4-5.1-10.5-5.8"/>
				<path class="st2" d="M48.5 8.7h-1.1"/><path class="st4" d="M67.2 22.8L65.9 25l-2.1-1.5"/>
			</g>
		</svg>
	</h3>
	<button onclick="ok()">OK</button>
</div>
<div></div>
<script>
function warn(mess) {
	$("#warn>h3").html(mess);
	$("#warn").css("display", "flex");
	$("#warn+div").css("display", "block");
}
function ok() {
	$("#warn").fadeOut("fast");
	$("#warn+div").fadeOut("fast");
}
function fullscreen() {
	if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {
		if (document.documentElement.requestFullscreen)
			document.documentElement.requestFullscreen();
		else if (document.documentElement.msRequestFullscreen)
			document.documentElement.msRequestFullscreen();
		else if (document.documentElement.mozRequestFullScreen)
			document.documentElement.mozRequestFullScreen();
		else if (document.documentElement.webkitRequestFullscreen)
			document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
	} else {
		if (document.exitFullscreen)
			document.exitFullscreen();
		else if (document.msExitFullscreen)
			document.msExitFullscreen();
		else if (document.mozCancelFullScreen)
			document.mozCancelFullScreen();
		else if (document.webkitExitFullscreen)
			document.webkitExitFullscreen();
	}
}
String.prototype.trimAny = function (chars) {
    var start = 0, 
        end = this.length;
    while(start < end && chars.indexOf(this[start]) >= 0)
        ++start;
    while(end > start && chars.indexOf(this[end - 1]) >= 0)
        --end;
    return (start > 0 || end < this.length) ? this.substring(start, end) : this;
}
</script>
<nav>
	<div>
		<img src="/icon/hanu.png" width="43px" onclick="fullscreen()">
	</div>
	<div>
		<a href="/" title="Home"><img src="/icon/home.svg" height="25px"></a>
		<a href="/dict/" title="Dictionary"><img src="/icon/dict.svg" height="25px"></a>
		<a href="/glossary/" title="Glossary"><img src="/icon/glossary.svg" height="25px"></a>
	</div>
	<div>
			<button id="acc">
				<?php if(empty($_SESSION["username"])): ?>
					<img src="/icon/acc.svg">
					<ul>
						<li><a href="/login">Log in</a></li>
						<li><a href="/signup">Sign up</a></li>
					</ul>
				<?php else: ?>
					<img src="/icon/acc2.svg">
					<ul>
						<li><a href="/acc/">My Account</a></li>
						<li><a href="/article/post">New Post</a></li>
						<li><a href="/login/logout.php">Log out</a></li>
					</ul>
				<?php endif; ?>
			</button>
			<script>
				document.querySelector("#acc").onmouseover = ()=>{document.querySelector("#acc>ul").style.display = "block"};
				document.querySelector("#acc").onmouseout = ()=>{document.querySelector("#acc>ul").style.display = "none"};
			</script>
	</div>
</nav>