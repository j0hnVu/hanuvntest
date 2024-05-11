function submit() {
	let score = 0;
	$(".choice").each(function(){
		let checked = $(this).find("input:checked").next();
		let ans = $(this).attr("data-ans");
		if (checked.text()==ans) {
			score++;
			checked.css("color","green").css("font-weight","500");
		} else
			checked.css("color","red").css("font-weight","500");
	});
	warn(`Your score: ${score}/${$(".choice").length}`);
}
const shuffle = array => {
	for (let i = array.length-1; i>0; i--) {
		const j = Math.floor(Math.random() * (i+1));
		const temp = array[i];
		array[i] = array[j];
		array[j] = temp;
	}
}
var arr1 = [];
var arr2 = [];
arr.forEach(function(phr){
	if (phr.meaning != null)
		arr1.push(phr);
	else
		arr2.push(phr.phrase);
});
arr1.forEach(function(phr,num){
	let question = $("<div class='question'></div>");
	question.append($("<div></div>").text(`${num+1})`));
	question.append($("<div></div>").text(phr.meaning));
	let choice = $("<div class='choice'></div>").attr("data-ans",phr.phrase);
	let choices = [phr.phrase];
	shuffle(arr2);
	let i = 1;
	arr2.some(function(phrase){
		if (i==4)
			return true;
		else if (phrase != phr.phrase) {
			choices.push(phrase);
			i++;
		}
	});
	shuffle(choices);
	choices.forEach(function(phrase){
		let span = $("<span></span>");
		span.append($('<input type="radio">').attr('name',num).attr("id",`${num+1}${phrase}`));
		span.append($('<label></label>').text(phrase).attr("for",`${num+1}${phrase}`));
		choice.append(span);
	});
	$('[onclick="submit()"]').before(question,choice);
});