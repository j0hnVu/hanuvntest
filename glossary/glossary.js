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
textarea()
$('article>h1').click( function() {
	$(this).next().slideToggle(700);
});
const add = (e) => {
	let have = [];
	$("td:first-child").each( function(){
		have.push( $(this).text().trim() );
	});
	let arr = $(e.delegateTarget).parent().prevAll();
	let phrase = arr.filter(".phrase").children().val().trim();
	let meaning = arr.filter(".meaning").children().val().trim();
	let example = arr.filter(".example").children().val().trim();
	if (phrase == "") {
		warn("Please type in the phrase");
		return false;
	}
	if (have.includes(phrase)) {
		warn("You have this phrase in your glossary already");
		return false;
	}
	$.post(
		'add.php',
		{
			'phrase': phrase,
			'meaning': meaning,
			'example' : example
		}, 
		(data) => {
			if (data == "success") {
				let before = "<tr>";
				before += "<td class='phrase'>" + phrase + "</td>";
				before += "<td class='meaning'>" + meaning + "</td>";
				before += "<td class='example'>" + example + "</td>";
				before += '<td><button title="edit" class="edit"><img src="icon/pen.svg" height="20px"></button> <button title="remove" class="remove"><img src="icon/remove.svg" height="20px"></button></td></tr>';
				$('table tr:last').before(before);
				arr.children().val("").attr("style","");
				$(".edit").off('click').click(edit);
				$(".add").off('click').click(add);
				$(".remove").off('click').click(remove);
			} else
				warn(data);
		}
	);
};
$(".add").click(add);

const remove = (e)=>{
	let tr = $(e.delegateTarget).parent().parent();
	let phrase = $(e.delegateTarget).parent().prevAll().filter(".phrase").text();
	if (phrase != "")
	$.post(
		'remove.php',
		{
			'phrase': phrase
		}, 
		(data) => {
			if (data == "success")
				tr.remove();
			else
				warn(data);
		}
	);
};
$(".remove").click(remove);

const add2 = (e)=>{
	let arr = $(e.delegateTarget).parent().prevAll();
	let phrase = arr.filter(".phrase").text().trim();
	let meaning = arr.filter(".meaning").children().val().trim();
	let example = arr.filter(".example").children().val().trim();
	$.post(
		'edit.php',
		{
			'phrase': phrase,
			'meaning': meaning,
			'example' : example
		}, 
		(data) => {
			if (data == "success") {
				arr.filter(".meaning").html(meaning);
				arr.filter(".example").html(example);
				let button = '<button title="edit" class="edit"><img src="icon/pen.svg" height="20px"></button> ';
				button += '<button title="remove" class="remove"><img src="icon/remove.svg" height="20px"></button>';
				$(e.delegateTarget).parent().html(button);
				$(".edit").off('click').click(edit);
				$(".add").off('click').click(add);
				$(".remove").off('click').click(remove);
			} else
				warn(data);
		}
	);
};
const edit = (e)=>{
	let arr = $(e.delegateTarget).parent().prevAll();
	let meaning = arr.filter(".meaning").text().trim();
	meaning = `<textarea class="meaning" spellcheck="false" rows="1">${meaning}</textarea>`;
	arr.filter(".meaning").html(meaning);
	let example = arr.filter(".example").text().trim();
	example = `<textarea class="example" spellcheck="false" rows="1">${example}</textarea>`;
	arr.filter(".example").html(example);
	textarea();
	let button = '<button title="OK" class="add2"><img src="icon/add.svg" height="20px"></button>';
	$(e.delegateTarget).parent().html(button);
	$(".add2").off("click").click(add2);
}
$(".edit").click(edit);