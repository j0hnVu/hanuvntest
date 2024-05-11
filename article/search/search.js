function hoverOn() {
	$('#search').hover(
		function(){$(this).css('box-shadow','0 1px 5px 1px #dfe1e5')},
		function(){$(this).css('box-shadow','none')}
	);
}
function hoverOff() {
	$('#search').hover( function() {
		$(this).css('box-shadow','0 1px 5px 1px #dfe1e5')
	});
}
hoverOn();
$("#mic").mouseenter( ()=>$("#mic>img").attr("src","/icon/mic2.svg") )
	.mouseleave( ()=>$("#mic>img").attr("src","/icon/mic.svg") );
$("button[title='Search']").mouseenter( ()=>$("button[title='Search']>img").attr("src","/icon/search2.svg") )
	.mouseleave( ()=>$("button[title='Search']>img").attr("src","/icon/search.svg") );
$('#search input').focus( function() {
	$('#search').css('box-shadow', '0 1px 5px 1px #dfe1e5');
	hoverOff()
});
$('#search input').blur( function() {
	$('#search').css('box-shadow', 'none');
	hoverOn()
});
$('#search input').keypress( function(event) {
	let keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13')
		search();
});
const resize = ()=>$("aside").css("height", $("main>div").height());
$(window).resize(resize);
//Voice search
if (typeof window.SpeechRecognition !== 'undefined' || typeof window.webkitSpeechRecognition !== 'undefined' ) {
	const sound = {
		start: new Audio("/icon/start.mp3"),
		end: new Audio("/icon/end.mp3"),
		error: new Audio("/icon/error.mp3")
	};
	var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
	var SpeechGrammarList = window.SpeechGrammarList || window.webkitSpeechGrammarList;
	var grammar = '#JSGF V1.0;'
	var recognition = new SpeechRecognition();
	var speechRecognitionList = new SpeechGrammarList();
	speechRecognitionList.addFromString(grammar, 1);
	recognition.grammars = speechRecognitionList;
	recognition.lang = 'en-US';
	recognition.interimResults = false;
	recognition.onresult = function(event) {
		var lastResult = event.results.length - 1;
		var content = event.results[lastResult][0].transcript;
		content = content.toLowerCase().trim().replace(/\./gm,'');
		$("#search input").val(content);
	};
	recognition.onspeechend = function() {
		recognition.stop();
		sound.end.play();
		ok();
	};
	recognition.onerror = function(event) {
		sound.start.pause();
		if (event.error == "not-allowed")
			warn("Please allow us to access your microphone");
		else if (event.error == "no-speech") {
			sound.error.play();
			ok();
		}
		console.log(event.error);
		console.log(event);
	};
	$("#mic").click(()=>{
		warn("<div style='display:flex;flex-direction:column;align-items:center;'><img src='/icon/voice.svg' class='pulsate' width='30px'><img src='/icon/mic2.svg' width='30px'></div>");
		sound.start.play();
		recognition.start();
		$("#warn>button").off("click").click(function(){
			recognition.stop();
			ok();
			$(this).off("click").click(ok);
		});
	});
} else {
	$("#mic").click(()=>warn("Voice searching is not available on your browser."));
}
//ARTICLES
function append(obj) {
	let article = $("<article></article>").attr("id", obj.id)
		.ready(()=>$("main").off("scroll").scroll(scroll));
	$("main>div>div:first-child").append(article);
	let title = $("<a></a>").attr("href", "/article/?id="+obj.id)
		.html($("<h1></h1>").text(obj.title));
	let preview = "";
	if (obj.preview != null)
		preview = $("<div class='preview'></div>").html(obj.preview);
	let tag = $("<span></span>");
	obj.tag.trimAny(',').split(',').forEach((text)=>tag.append($("<span class='tag'></span>").text(text),' '));
	let link = $("<a></a>").text("See more").attr("href", "/article/?id="+obj.id).attr("class", "seemore");
	let content = $("<div></div>").html(obj.preview2).prepend(tag)
		.append("... ").append(link).css("white-space", "pre-line");
	let div = $("<div></div>").append(preview, content);
	article.append(title, div);
	console.log(obj);
}
$('#search input').val(q);
q = q.split(' ');
var tag = new Set();
var word = new Set();
q.forEach((value)=>{
	if (/#[a-z0-9_]+/i.test(value))
		tag.add(value.toLowerCase().slice(1));
	else
		word.add(value.toLowerCase());
});
function search() {
    let q = encodeURIComponent($('#search>input').val().trim());
    if (q!='')
    	window.location.href = `/article/search/?q=${q}`;
}
function add(id) {
	$.post(
		'load.php',
		{
		    'tag': JSON.stringify([...tag]),
		    'word': JSON.stringify([...word]),
			'id': id
		}, 
		(data) => {
			try {
				let array = JSON.parse(data);
				if (array.length == 5) {
					array.forEach((obj)=>append(obj));
					resize();
				} else if (array.length == 0) {
					$('.loader').remove();
					resize();
				} else {
					array.forEach((obj)=>append(obj));
					$('.loader').remove();
					resize();
				}
			} catch(err) {
				console.log(data);
			}
		}
	)
}
add(0);
const scroll = function() {
	if($("main").scrollTop() + $("main").height() > $("main>div").height()-200) {
		$("main").off("scroll");
		add($("main>div>div>article:last-child").attr("id"));
	}
};
$("main").scroll(scroll);