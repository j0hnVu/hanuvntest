function csscomment() {
	textarea();
	let height = $("div.comment:first-child").height();
	let margin = (height - $("div.comment>img").height())/2;
	$("div.comment>img").css("margin-top", margin);
	$('div.comment:first-child>button').height(height-16).width(height-16);
	$('[src="/icon/send.svg"]').attr("style","width:100%");
}
function textarea() {
	$("textarea").each(function(){
		this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
		this.removeEventListener("input", OnInput, false);
		this.addEventListener("input", OnInput, false);
	});
}
function OnInput() {
	this.style.height = "auto";
	this.style.height = (this.scrollHeight) + "px";
}
csscomment();
const tools = function() {
	if (document.querySelector('article').getBoundingClientRect().top < 61) {
		document.querySelector('#tools').style.cssText = "position: fixed; top: 75px; left: 20px;"
	} else {
		document.querySelector('#tools').style.cssText = "position: absolute; top: 15px; left: 10px;"
	}
};
tools();
document.querySelector('section').onscroll = tools;

// LIKE, COMMENT
function s() {
	if (+$("#like").text() > 1)
		$("#like+*").text(" likes");
	else
		$("#like+*").text(" like");
	if (+$("#comment").text() > 1)
		$("#comment+*").text(" more comments");
	else
		$("#comment+*").text(" more comment");
}
s();
const addComment = (obj)=>$(".comment:first-child").after(
		$("<div class='comment'></div>").attr("data-time",obj.time)
			.append($('<img src="/icon/acc2.svg">'))
			.append($('<div></div>')
				.append($('<b></b>').html(obj.username))
				.append($('<div style="white-space: pre-wrap;"></div>').html(obj.content))
			)
	);
function moreComment(){
	$.post(
		'morecomment.php',
		{
			'article': article
		},
		(data)=>{
			let array = JSON.parse(data);
			console.log(array);
			$(".comment:first-child~*").remove();
			array.forEach(addComment);
			csscomment();
		}
	);
}
function comment(){
	if (username == null)
		warn("Please <a href='/login' target='_blank' style='color: var(--link-blue)'>Log in</a> to comment.");
	else if ($("div.comment textarea").val().trim()!='')
	$.post(
		'comment.php',
		{
			'article': article,
			'content': $("div.comment textarea").val().trim()
		},
		(data)=>{
			try {
				let obj = JSON.parse(data);
				addComment(obj);
				$("div.comment textarea").val("");
			} catch(err) {
				console.log(err);
				console.log(data);
			}
		}
	);
}
function showLike() {
	$(`[onclick="like()"]>img`).attr("src","/icon/like2.svg");
	$(`[onclick="like()"]`).css("color","var(--dark-blue)");
	$('#like').text( parseInt($('#like').text())+1 );
	s();
}
function hideLike() {
	$(`[onclick="like()"]>img`).attr("src","/icon/like.svg");
	$(`[onclick="like()"]`).css("color","var(--gray)");
	$('#like').text( parseInt($('#like').text())-1 );
	s();
}
function like() {
	if (username == null)
		warn("Please <a href='/login' target='_blank' style='color: var(--link-blue)'>Log in</a> to like.");
	else {
		if ($(`[onclick="like()"]>img`).attr("src")=="/icon/like.svg")
	        $.post(
        		'like.php',
        		{
    	    		'article': article,
    	    		'like': 'add'
        		},
        		(data)=>{
        		    if (data=="success")
        		        showLike();
        		    else
        		        console.log(data);
        		}
        	);
		else if ($(`[onclick="like()"]>img`).attr("src")=="/icon/like2.svg")
	        $.post(
        		'like.php',
        		{
    	    		'article': article,
    	    		'like': 'delete'
        		},
        		(data)=>{
        		    if (data=="success")
        		        hideLike();
        		    else
        		        console.log(data);
        		}
        	);
	}
}
//HIGHLIGHTS
function getSafeRanges(dangerous) {
	var a = dangerous.commonAncestorContainer;
	// Starts -- Work inward from the start, selecting the largest safe range
	var s = new Array(0), rs = new Array(0);
	if (dangerous.startContainer != a)
		for(var i = dangerous.startContainer; i != a; i = i.parentNode)
			s.push(i);

	if (0 < s.length) for(var i = 0; i < s.length; i++) {
		var xs = document.createRange();
		if (i) {
			xs.setStartAfter(s[i-1]);
			xs.setEndAfter(s[i].lastChild);
		}
		else {
			xs.setStart(s[i], dangerous.startOffset);
			xs.setEndAfter(
				(s[i].nodeType == Node.TEXT_NODE)
				? s[i] : s[i].lastChild
			);
		}
		rs.push(xs);
	}

	// Ends -- basically the same code reversed
	var e = new Array(0), re = new Array(0);
	if (dangerous.endContainer != a)
		for(var i = dangerous.endContainer; i != a; i = i.parentNode)
			e.push(i)
	;
	if (0 < e.length) for(var i = 0; i < e.length; i++) {
		var xe = document.createRange();
		if (i) {
			xe.setStartBefore(e[i].firstChild);
			xe.setEndBefore(e[i-1]);
		} else {
			xe.setStartBefore(
				(e[i].nodeType == Node.TEXT_NODE)
				? e[i] : e[i].firstChild
			);
			xe.setEnd(e[i], dangerous.endOffset);
		}
		re.unshift(xe);
	}

	// Middle -- the uncaptured middle
	if ((0 < s.length) && (0 < e.length)) {
		var xm = document.createRange();
		xm.setStartAfter(s[s.length - 1]);
		xm.setEndBefore(e[e.length - 1]);
	} else {
		return [dangerous];
	}

	// Concat
	rs.push(xm);
	response = rs.concat(re);    

	// Send to Console
	return response;
}
function highlightSelection() {
	var userSelection = window.getSelection().getRangeAt(0);
	var safeRanges = getSafeRanges(userSelection);
	for (var i = 0; i < safeRanges.length; i++) {
		highlightRange(safeRanges[i]);
	}
}
function highlightRange(range) {
	var newNode = document.createElement("span");
	newNode.classList.add("highlighted");
	range.surroundContents(newNode);
}
// DICT SELECTION
function getSelectionText() {
    var text = "";
    if (window.getSelection) {
        text = window.getSelection().toString();
    } else if (document.selection && document.selection.type != "Control") {
        text = document.selection.createRange().text;
    }
    return text;
}
document.onselectionchange = function() {
	if (!$('#search input').is(':focus'))
    	$("#search input").val(getSelectionText());
};
//RECENTLY LEARNED
function ago(time) {
	let ago = "";
	time = Date.now() - time;
	time = Math.round(time/1000);
	if (time==1)
		ago = "1 second ago"
	else if (time<60)
		ago = time + " seconds ago";
	else {
		time = Math.round(time/60);
		if (time==1)
			ago = "1 minute ago";
		else if (time<60)
			ago = time + " minutes ago";
		else {
			time = Math.round(time/60);
			if (time==1)
				ago = "1 hour ago";
			else if (time<24)
				ago = time + " hours ago";
			else {
				time = Math.round(time/24);
				if (time==1)
					ago = "yesterday"
				else if (time<30)
					ago = time + " days ago";
				else {
					time = Math.round(time/30);
					if (time==1)
						ago = "last month";
					else if (time<12)
						ago = time + " months ago";
					else {
						time = Math.round(time/12);
						if (time==1)
							ago = "last year";
						else
							ago = time + " years ago"
					}
				}
			}
		}
	}
	return ago;
}
{
let time = $("#info i:last-child").text();
time = new Date(time).getTime();
time = ago(time);
$("#info i:last-child").text(time);
}