<?php
class Oxf {
	function __construct($id,$key) {
		$this->id = $id;
		$this->key = $key;
	}
	function txt() {
		return ['app_id:'.$this->id,'app_key:'.$this->key];
	}
}
class Img {
	function __construct($key) {
		$this->key = $key;
	}
	function txt() {
		return ['x-rapidapi-host:bing-image-search1.p.rapidapi.com','x-rapidapi-key:'.$this->key];
	}
}
function choose($arr) {
	$d = date("d")-1;
	return $arr[$d]->txt();
}
$oxfArr = [
new Oxf("a9d808eb","d2ff2af0ba42f80f19992ba57922e804"),
new Oxf("42c9783b","68eb3826dedc6365869f1de429ae040e"),
new Oxf("0ed00040","ce233d3f70a1e8062b3731d181235426"),
new Oxf("28265a7c","41ac9e8c7b2bd9bffe2de8c26e64bf8b"),
new Oxf("ab33a118","76e8ab2927ad5f18c246c35670e3c31c"),
new Oxf("1098c8cc","0b30e8975abb8676be8bdac8ded732bf"),
new Oxf("b3ea594d","b2b9a4d0ee4a8389dcf3e99251fdb968"),
new Oxf("6da1d836","4b778b130bc00413196cc1c83f3b2770"),
new Oxf("dead74f2","44d198795e7f6d557aaad413f2660768"),
new Oxf("636da645","006e10d59bf7c31be8d17e3ca6ce8943"),
new Oxf("b1a497dc","eb78e511784388069c9ee5a4d9ded812"),
new Oxf("435cc570","7c57ea68a4215bbc1d685f9691ca90d7"),
new Oxf("e76e6421","a6c83e28f6899d19c855fca0a6af1cbf"),
new Oxf("43d15ec3","a19bbceebf7122865352ae6d9ab59bd6"),
new Oxf("b8bff1a6","34ae58447b22e1e37bf2d3bc120e4e06"),
new Oxf("01036234","4bf7762525e590bdf0e2fc9c23a8b51e"),
new Oxf("6ed24d15","b1f58ed87eef7daaae29a92b97a78ac7"),
new Oxf("2a992b0c","06eb517e4a3f89ffebade160e0775ecf"),
new Oxf("a1a54dce","b9e0cf5363c32f6e951482505bc51d36"),
new Oxf("c925cd03","8105727c8a44b8661476f2ed9071e47b"),
new Oxf("899bee56","cdb9dff48703a963c49f5105100b5b83"),
new Oxf("e38c2e60","ca7bf134f1d2bb34b314c65ab3a36669"),
new Oxf("ee85fd97","bcd44ef5de6c95c56a01ad136834efd7"),
new Oxf("ca69a971","61d639c288e0e19156bf1b966e23cc52"),
new Oxf("5c2fc406","d7507dbcc016a1fc17a5c9f940e53bcd"),
new Oxf("7b6633de","039a3c478cb6e05427b145d10450f8b9"),
new Oxf("15cdaf54","0268ad2816713c18900bc7169e6b6437"),
new Oxf("b90b751b","b5c30856221724ce52e5bf6c105ba828"),
new Oxf("eb8b4afc","10ed88f05711f1cbaed14887f3f1034c"),
new Oxf("878b9cbb","99407ae7994ed64ab2bad9849e39d360"),
new Oxf("7742ebde","6deade657446b92d283b7d61b6be8663")
];
$imgArr = [
new Img("61f736ab09msh02255ad9b42d462p1c06b6jsnd83bad7f6c18"),
new Img("1e45e8ce92msh50936335969d607p1980f8jsn2540135ba05b"),
new Img("e3004b7a94msh8d21a18ca75a8d3p1d3670jsnab202f9a9dc4"),
new Img("0cab9e1bfdmsh110673f3a9d5df5p122869jsnb4b704c4d80f"),
new Img("25619eee5dmshf5645b581e999f5p1bfd0fjsn0f166c35730a"),
new Img("76ebf01e6emsh20398f37a5c485dp1a400fjsn8bdd242f8e26"),
new Img("8868c15c3bmsh730567d0b0f0664p16611cjsn0058ae8c2687"),
new Img("ebc92733a6mshe3b3a6ea35635c6p13c617jsnc413916f3a08"),
new Img("ef1d85b8cbmshfbb5d487a850b61p17b478jsn79768cd4d4d2"),
new Img("977d2ee208msh3f0555224502bb7p13f781jsnd4452ce4a29d"),
new Img("586f6e45c6msh3928daab3d1d042p1f3f6ajsn4f413ae22289"),
new Img("9769527b89mshb9f631e58675efcp1da832jsnd6cebc2aa952"),
new Img("34252c8a69mshc88a6afbe81d07cp1ccbdcjsn7e64272b7002"),
new Img("45842cd71bmsh9875f798ec2d94bp14c290jsn09a05f0fe90a"),
new Img("04dc8f5ceemsh764d6b454d4682bp159e67jsna8cc2fd7bfd9"),
new Img("a0a5028608mshf279d2a17fcbd43p167966jsnaadafdb0ff30"),
new Img("81044b7b60msh066bc0bf55da3eap1cbc49jsn87c89186a0cd"),
new Img("6d9c4249dfmshff02871bebf6ddap18cf1fjsn9572cf36755a"),
new Img("f1a152435cmsh30446a9b287c324p14fb34jsnd5a6397a0354"),
new Img("a402573ademsh10c68ccd2f82536p1c3ef1jsneba47b626cd3"),
new Img("d0d95e797cmshe33d276ce8f7c09p1ceb77jsnbd61b54f2dec"),
new Img("18379f8ab0mshf81d3d22b0061fcp1d93b4jsn09cbf8169bbb"),
new Img("f042136962msh211b947f5745435p1414fcjsn2a1a70721823"),
new Img("b3c2503108mshcdb8a10da652beap18cfa1jsnbfa32003e417"),
new Img("3acd7903bemshd2f6d8190fd560cp1739fbjsn347af49fa8d0"),
new Img("46ae9b0167msh2ab5451396f367cp1cc7e4jsn2dc7fecf4c84"),
new Img("5619b89b02mshf1eca0fb57656e1p1e05ebjsndd51e3dfd27d"),
new Img("2c3a6d25damshac9d141aaff2ca3p1e7f54jsnc52f842528af"),
new Img("29a4edf7a4mshdbcd7fa318943dcp100926jsn08714f248906"),
new Img("d09b227dc9msh025d5c8be3f2eccp14f9e3jsna2972b922159"),
new Img("ba5a10d04dmshc0cad94fb0e3763p1bddb2jsn036145a18c6d")
];
function get($url,$headers) {
	$curl = curl_init();
	curl_setopt_array($curl, [
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => $headers,
	]);
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) 
		return "{\"cURL Error\":\"$err\"}";
	else 
		return $response;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$dict = choose($oxfArr);
	$img = choose($imgArr);
	$word = rawurlencode(str_replace('?','',htmlspecialchars(trim($_POST['word']))));
	$lang = rawurlencode(str_replace('?','',htmlspecialchars(trim($_POST['lang']))));
	if ($word != '') {
		$url = "https://od-api.oxforddictionaries.com/api/v2/entries/{$lang}/{$word}";
		$dictRe = get($url,$dict);
		if (strpos($dictRe,"No entry found") === false) {
			$url = "https://bing-image-search1.p.rapidapi.com/images/search?q={$word}&mkt=en-US&safeSearch=strict&count=4";
			$imgRe = get($url,$img);
			$imgRe = json_decode($imgRe);
			$imgRe = json_encode($imgRe->value);
			$url = "https://api.tracau.vn/WBBcwnwQpV89/s/{$word}/en";
			$avRe = get($url,[]);
			if (strpos($avRe,'<article') !== false) {
				$avRe = '"'.strstr($avRe,"<article");
				$avRe = strstr($avRe, "/article>", true).'/article>"';
				echo "{\"oxf\":{$dictRe}, \"img\":{$imgRe}, \"av\":{$avRe}}";
			} else echo "{\"oxf\":{$dictRe}, \"img\":{$imgRe}}";
		} else {
			$url = "https://od-api.oxforddictionaries.com/api/v2/search/thesaurus/en?q={$word}";
			$result = get($url,$dict);
			$result = "{\"oxf\":{$result}}";
			echo $result;
		}
	}
};
?>