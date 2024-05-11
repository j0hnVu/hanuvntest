const tx = document.getElementsByTagName("textarea");
for (let i = 0; i < tx.length; i++) {
	tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "px;overflow-y:hidden;");
	tx[i].addEventListener("input", OnInput, false);
}
function OnInput() {
	this.style.height = "auto";
	this.style.height = (this.scrollHeight) + "px";
}
function submit() {
	var score = 0;
	for (let i = 0; i < tx.length; i++) {
		let ans = tx[i].getAttribute("data-ans").trim().toLowerCase();
		let input = tx[i].value.trim().toLowerCase();
		if (input == ans) {
			tx[i].style.borderBottom = "solid 2px green";
			score++;
		} else
			tx[i].style.borderBottom = "solid 2px red";
	}
	warn("Your score: "+score+"/"+tx.length);
}