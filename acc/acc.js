const resize = ()=>$("aside").css("height", $("main>div").height());
$(window).resize(resize);
function append(obj) {
	let article = $("<article></article>").attr("id", obj.id)
		.ready(()=>$("main").off("scroll").scroll(scroll));
	$("main>div>div:first-child").append(article);
	let title = $("<h1></h1>").text(obj.title);
	let preview = "";
	if (obj.preview != null)
		preview = $("<div class='preview'></div>").html(obj.preview);
	let link = $("<a></a>").text("See more").attr("href", "/article/?id="+obj.id);
	let content = $("<div></div>").html(obj.preview2).append("...").append(link).css("white-space", "pre-line");
	let div = $("<div></div>").append(preview, content);
	article.append(title, div);
	console.log(obj);
}
function add(id) {
	$.post(
		'load.php',
		{
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