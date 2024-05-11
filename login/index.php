<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
if ($_SERVER["REQUEST_METHOD"] === "POST")
	if (!empty($_POST["email"])) 
		if (!empty($_POST["password"])) {
			require_once "$root/classes/account.php";
			$acc = new Account();
			$acc->setEmail($_POST["email"]);
			$acc->setPassword($_POST["password"]);
			if ($acc->logIn()) {
				session_start();
				$_SESSION["username"] = $acc->username;
				header("Location: /");
				die();
			}
		}
require_once 'google/vendor/autoload.php';
$client = new Google_Client();
$client->setClientId('648524630853-9ak71jmfkq7en20fm23fsr7evk2t7u5b.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('https://fune.cf/login/');
$client->addScope("email");
$client->addScope("profile");
$gg = true;
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email =  $google_account_info->email;
    require_once "$root/classes/account.php";
	$acc = new Account();
	$acc->setEmail($email);
	if ($acc->logInGoogle()) {
		session_start();
		$_SESSION["username"] = $acc->username;
		header("Location: /");
		die();
	} else
		$gg = false;
}
?>
<head>
	<?php require "$root/0/head.php"?>
	<title>HANU TESTS - Log in</title>
	<link rel="stylesheet" href="login.css">
</head>
<?php require "$root/0/nav.php"?>
<main>
	<form method="post">
		<img src="/icon/hanu.png" height="60px">
		<input type="email" name="email" placeholder="Email" required>
		<input type="password" name="password" placeholder="Password" required>
		<a href="<?= $client->createAuthUrl()?>" id="google">
			<img src="/icon/google.svg">
			<span>Log in with Google</span>
		</a>
		<input type="submit" value="Log in" id="submit">
		<?php if ($_SERVER["REQUEST_METHOD"] === "POST"):?>
			<div>Wrong email or password!</div>
			<script>
				warn("Wrong email or password!");
			</script>
		<?php endif;?>
		<?php if ($gg === false):?>
			<div>Your Google Account hasn't been <a href='/signup/'>signed up</a>!</div>
			<script>
				warn("Your Google Account hasn't been <a href='/signup/'>signed up</a>!");
			</script>
		<?php endif;?>
	</form>
</main>