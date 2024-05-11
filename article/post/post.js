$("textarea").each(function(){
	this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
	this.removeEventListener("input", OnInput, false);
	this.addEventListener("input", OnInput, false);
});
function OnInput() {
	this.style.height = "auto";
	this.style.height = (this.scrollHeight) + "px";
}
function post() {
	var title = $('[placeholder="TITLE"]').val().trim();
	var content = $('#editor .ql-editor').html().trim();
	var tag = $('[placeholder="#science #AlbertEinstein #energy"]').val();
	var tagArr = Array.from(tag.matchAll(/#[a-z0-9_]+/gi), m => m[0]);
	tag = ',';
	tagArr.forEach((val)=>tag+=val.slice(1)+",");
	var preview2 = $('#editor .ql-editor').text().substr(0,400).trim();
	if (title!="" && tag!="" && preview2!="") {
		var preview = $('#editor iframe, #editor img')[0];
		var length = 0;
		if (preview != null) {
			preview = preview.outerHTML;
			length = preview.length;
			preview = content.indexOf(preview);
		};
		console.log(content.substr(preview,length));
		$.post(
			'/article/post/post.php',
			{
			    'title': title,
				'content': content,
				'tag': tag,
				'preview': preview,
				'preview2': preview2,
				'length': length
			}, 
			(data) => {
				if (data=="success")
					window.location.href = '/';
				else {
					console.log(data);
					warn("ERROR!!!");
				}
			}
		);
	} else 
		warn("Please fill in all the blanks");
}