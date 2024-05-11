var blank, phrase;
function connect() {
    if (phrase!=null && blank!=null) {
        blank.text(phrase.text());
        blank.attr("class", "blank filled");
        phrase.remove();
        blank.off("click").click(function(){
            $("article:first-child>div").append(
                $("<span class='phrase'></span>")
                    .text($(this).text())
                    .click(phraseClick)
            );
            $(this).text("")
                .attr("class", "blank")
                .off("click")
                .each(blankClick);
        });
        var next = blank.nextAll().filter(".blank").not(".filled").first();
        phrase = blank = null;
        if (next.length == 1)
            next.each(blankClick);
    }
}
function phraseClick() {
    phrase = $(this);
    $(".phrase").attr("style","");
    phrase.css("background-color","var(--blue)");
    phrase.css("box-shadow","var(--shadow)");
    phrase.off("click").click(function(){
        phrase = null;
        $(this).attr("style","");
        $(this).off("click").click(phraseClick);
    });
    connect();
}
function blankClick() {
    blank = $(this);
    $(".blank").not(".filled").attr("style","");
    blank.css("background-color","var(--light-blue)");
    blank.off("click").click(function(){
        blank = null;
        $(this).attr("style","");
        $(this).off("click").click(blankClick);
    });
    connect();
}
$(".phrase").click(phraseClick);
$(".blank").click(blankClick);
$(".blank").first().trigger("click");
function submit() {
    let score = 0;
    $(".blank").each(function(){
        if ($(this).text().trim()==$(this).attr("data-ans")) {
            score++;
            $(this).css("background-color","var(--green)");
        } else 
            $(this).css("background-color","var(--red)");
    });
    warn(`Your score: ${score}/${$(".blank").length}`);
}