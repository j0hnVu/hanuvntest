$( () => {
    var meaning = "";
    var example = "";
	//Event Processor
	function hoverOn() {
		$('#search>div').hover(
			function(){$(this).css('box-shadow','0px 0px 13px -5px #284664')},
			function(){$(this).css('box-shadow','0px 0px 10px -5px #284664')}
		);
	}
	function hoverOff() {
		$('#search>div').hover( function() {
			$(this).css('box-shadow','0px 0px 13px -5px #284664')
		});
	}
	hoverOn();
	$("#mic").mouseenter( ()=>$("#mic>img").attr("src","/icon/mic2.svg") )
	.mouseleave( ()=>$("#mic>img").attr("src","/icon/mic.svg") );
	$('input').focus( function() {
		$('#search>div').css('box-shadow', '0px 0px 13px -5px #284664');
		hoverOff()
	});
	$('input').blur( function() {
		$('#search>div').css('box-shadow', '0px 0px 10px -5px #284664');
		hoverOn()
	});
	$('input').keypress( function(event) {
		let keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13') {
			$('#searchButton').trigger('click');
			$('input').trigger('blur')
		}
	});
	var lang = 'en-gb';
	$('#lang').click( function() {
		if (lang == 'en-gb') {
			$('#en-gb').css('display','none');
			$('#en-us').css('display','block');
			lang = 'en-us'
		} else {
			$('#en-us').css('display','none');
			$('#en-gb').css('display','block');
			lang = 'en-gb'
		}
	});
	function addEvents() {
		$("button.pronun").click( function(){
			$(this).children('audio')[0].play()
		});
		$('button.syn').click( function() {
			$(this).next().slideToggle(700);
		});
		$('.goto').off('click').click( function() {
			$('input').val($(this).text());
			$('#searchButton').trigger('click');
			$('input').trigger('blur')
		});
		$('h2').off('click').click( function() {
			$(this).next().slideToggle(700);
		});
	}
	//Voice search
	if (typeof window.SpeechRecognition !== 'undefined' || typeof window.webkitSpeechRecognition !== 'undefined' ) {
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
	};
	recognition.onerror = function(event) {
    	console.log(event.error);
    	console.log(event);
	};
	$("#mic").click(()=>{
		warn("<div style='display:flex;flex-direction:column;align-items:center;'><img src='/icon/voice.svg' class='pulsate' width='30px'><img src='/icon/mic2.svg' width='30px'></div>");
		$("#warn>button").off("click").click(function(){
		    recognition.stop();
		    ok();
		    $(this).off("click").click(ok);
		});
		recognition.start();
	});
	} else {
		$("#mic").click(()=>warn("Voice searching is not available on your browser."));
	}
	//History
	if (!localStorage.hasOwnProperty('dictHistory'))
		localStorage.dictHistory = '';
	else if (localStorage.dictHistory != '') {
		let array = localStorage.dictHistory.split("#");
		for (let x in array)
			$('#history>div').prepend('<p class="goto">' + array[x] + '</p>');
	}
	addEvents();
	//Data Processor
	class Oxf {
		constructor(obj) {
			this.obj = obj;
			this.left = "";
			this.phrases = new Set();
			this.phrasalVerbs = new Set();
		}
		add() {
			$('#left').html(this.left);
			if (this.phrasalVerbs.size > 0) {
				let data = '<h2>Phrasal verbs</h2><div>';
				for (let x of this.phrasalVerbs)
					data += x;
				data += '<p class="end"></p></div>';
				$('#phrasalVerbs').html(data).show();
			} else $('#phrasalVerbs').html('').hide();
			if (this.phrases.size > 0) {
				let data = '<h2>Phrases</h2><div>';
				for (let x of this.phrases)
					data += x;
				data += '<p class="end"></p></div>';
				$('#phrases').html(data).show();
			} else $('#phrases').html('').hide();
		}
		process() {
			let re = this.obj.oxf.results;
			if (this.obj.oxf.metadata.operation != 'retrieve') {
				this.left = '<article><h2>Did you mean</h2><div>';
				for (let x in re)
					this.left += '<p class="goto">' + re[x].word + '</p>';
				this.left += '<p class="end"></p></div></article>';
				this.add();
				return false;
			}
			for (let x in re) {
				let entry = re[x].lexicalEntries;
				for (let x in entry) {
					this.left += '<article><h2>' + entry[x].text + ' <span class="category"> ';
					this.left += entry[x].lexicalCategory.text.toLowerCase() + '</span></h2><div>';
					meaning += '['+entry[x].lexicalCategory.text.toLowerCase()+'] ';
					if (entry[x].entries[0].hasOwnProperty('pronunciations'))
						this.addPronun(entry[x].entries[0].pronunciations);
					this.addSense(entry[x].entries[0].senses);
					this.left += '<p class="end"></p></div></article>';
					if (entry[x].hasOwnProperty('phrasalVerbs'))
						this.addPhrasalVerbs(entry[x].phrasalVerbs);
					if (entry[x].hasOwnProperty('phrases'))
						this.addPhrases(entry[x].phrases);
				}
			}
			this.add();
			return true;
		}
		addPronun(pronun) {
			for (let x in pronun) {
				if (pronun[x].hasOwnProperty('audioFile')) {
					let file = pronun[x].audioFile;
					let ipa = pronun[x].phoneticSpelling;
					this.left += '<p class="pronun"><button class="pronun"><img src="/icon/listen.svg" height="15" width="15"></img><audio src="' + file +'" type="audio/mpeg"></audio></button>&nbsp;/'+ipa+'/</p>'
				}
			}
		}
		addSense(sense) {
			var numDef = 1;
			for (let x in sense) {
				if (sense[x].hasOwnProperty('definitions')) {
					this.left += '<h3>' + numDef + '. ' + sense[x].definitions[0] + '</h3>';
					numDef += 1;
					meaning += sense[x].definitions[0] + "\n";
				}
				if (sense[x].hasOwnProperty('crossReferenceMarkers')) {
					this.left += '<h3>' + numDef + '. ' + sense[x].crossReferenceMarkers[0] + '</h3>';
					numDef += 1
				}
				if (sense[x].hasOwnProperty('notes')) {
					let notes = sense[x].notes;
					for (let x in notes) 
						this.left += '<p class="notes">[' + notes[x].text + ']</p>';
				}
				if (sense[x].hasOwnProperty('crossReferences')) {
					this.left += '<p class="goto">' + sense[x].crossReferences[0].text + '</p>';
				}
				if (sense[x].hasOwnProperty('examples')) {
					let eg = sense[x].examples;
					for (let x in eg) 
						this.left += '<p class="eg">' + eg[x].text + '</p>';
				}
				if (sense[x].hasOwnProperty('synonyms')) {
					let sy = sense[x].synonyms;
					this.left += '<button class="syn">Synonyms</button><div style="display:none;">';
					for (let x in sy) 
						this.left += '<p class="goto syn">' + sy[x].text + '</p>';
					this.left += '</div>';
				}
			}
		}
		addPhrasalVerbs(ph) {
			for (let x in ph)
				this.phrasalVerbs.add('<p class="goto">'+ph[x].text+'</p>');
		}
		addPhrases(ph) {
			for (let x in ph)
				this.phrases.add('<p class="goto">'+ph[x].text+'</p>');
		}
	}
	class Av {
		constructor(obj) {
			this.obj = obj;
			this.av = "<article><h2>Từ điển Anh-Việt</h2><div style='display:none;'>";
		}
		process() {
			if (this.obj.hasOwnProperty('av')) {
				this.av += this.obj.av.replace(/\&quot;/g, "").replace(/&nbsp;/g, "");
				this.av += '<p style="text-align:center;margin:10px;font-style:italic;color:var(--gray);">Powered by https://tracau.vn</p>';
				$('#left').append(this.av);
				$('#tl:first').prevAll().remove();
				$('.dict--title').remove();
				while ($('#I_C').length > 0)
					$('#I_C').remove();
				$("tr").not("#tl").not("#mn").not("#mh").not("#mh_n").remove();
			}
		}
	}

	class Img {
		constructor(obj) {
			this.obj = obj;
			this.img = "<h2>Images</h2><div>";
		}
		process() {
			let val = this.obj.img.value;
			for (let x in val)
				this.img += '<a href="'+val[x].hostPageUrl+'" target="_blank"><img src="'+val[x].contentUrl+'" title="'+val[x].name+'"></a>';
			this.img += '</div>';
			$('#images').html(this.img).show();
		}
	}

	var showData = function(data) {
		let obj = JSON.parse(data);
		console.log(obj);
		//Process
		let oxf = new Oxf(obj);
		if (oxf.process()) {
			let img = new Img(obj);
			img.process();
			let av = new Av(obj);
			av.process();
			//History
			if (localStorage.dictHistory != '')
				localStorage.dictHistory += '#';
			localStorage.dictHistory += $('#word').val().trim();
			$('#history>div').prepend('<p class="goto">' + $('#word').val().trim() + '</p>');
		} else {
			$('#images').html("").hide();
		}
		//Show
		$('#dict>div').hide();
		$('#dict>main').fadeIn();
		addEvents();
		$.post(
	    	'/glossary/add.php',
	    	{
	    		'phrase': $('#word').val().trim(),
	    		'meaning': meaning.trim(),
	    		'example' : example.trim()
	    	}, 
	    	(data) => {
	    		if (data != "success") {
	    		    warn("You already have this phrase in your glossary. Don't you remember it?");
	    		    console.log(data);
		    	}
	    	}
	    );
	}
	$('#searchButton').on('click', () => {
		let word = $('#word').val().trim();
		if (word != "") {
			$('#dict>main').hide();
			$('#dict>div').fadeIn();
			meaning = "";
			example = "";
			$.post(
				'post.php',
				{
					'word': word,
					'lang': lang
				}, 
				showData
			);
		};
	});
});
