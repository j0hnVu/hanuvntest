<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
if ($_SERVER["REQUEST_METHOD"] === "POST")
	if (!empty($_POST["email"])) 
	if (!empty($_POST["password"]))
	if (($_POST["password"]) === $_POST["password2"]) 
	if (!empty($_POST["username"]))
	if (!empty($_POST["fullname"]))
	if (!empty($_POST["gender"]))
	if (!empty($_POST["birth"])) {
		require "$root/classes/account.php";
		$acc = new Account();
		$acc->setEmail($_POST["email"]);
		$acc->setPassword($_POST["password"]);
		$acc->setUsername($_POST["username"]);
		$acc->setFullname($_POST["fullname"]);
		$acc->setGender($_POST["gender"]);
		$acc->setBirth($_POST["birth"]);
		if (!$acc->checkEmail() && !$acc->checkUsername()) {
			$acc->signUp();
			session_start();
			$_SESSION["signup"] = "TRUE";
			$_SESSION["email"] = $acc->email;
			$_SESSION["id"] = $acc->id;
			header("Location: verify.php");
			die();
		}
	}
?>
<head>
	<?php require "$root/0/head.php"?>
	<title>HANU TESTS - Sign up</title>
	<link rel="stylesheet" href="signup.css">
</head>
<?php require "$root/0/nav.php"?>
<main>
	<form method="post" onsubmit="return validatePassword() && confirmPassword() && validateUsername()">
		<img src="/icon/hanu.png" height="60px">
		<input type="email" name="email" placeholder="Email" required>
		<span id="validateresult"></span>
		<input type="password" id="password" name="password" placeholder="Password" required onchange="validatePassword()">
		<span id="confirmresult"></span>
		<input type="password" id="password2" name="password2" placeholder="Confirm Password" required onchange="confirmPassword()">
		<span id="usernameresult"></span>
		<input type="text" id="username" name="username" placeholder="Username" required onchange="validateUsername()">
		<input type="text" name="fullname" placeholder="Full name" required>
		<label>Gender</label>
		<div id="gender">
			<span>
				<input type="radio" id="male" name="gender" value="male" required>
				<label for="male">Male</label>
			</span>
			<span>
				<input type="radio" id="female" name="gender" value="female" required>
				<label for="female">Female</label>
			</span>
		</div>
		<label for="birth">Date of birth</label>
		<input type="date" name="birth" required>
		<input type="submit" value="Sign up" id="submit">
	</form>
</main>
<script>
	function validatePassword(){
		let pass = document.getElementById("password").value;
		if (pass.length <= 5) {
			document.getElementById("validateresult").innerHTML = "Password must have more than 5 characters!";
			return false;
		} else {
			document.getElementById("validateresult").innerHTML = "";
			return true;
		}
	}
	function confirmPassword(){
		let pass1 = document.getElementById("password").value;
		let pass2 = document.getElementById("password2").value;
		if (pass1 != pass2) {
			document.getElementById("confirmresult").innerHTML = "Not matching!";
			return false;
		} else {
			document.getElementById("confirmresult").innerHTML = "";
			return true;
		}
	}
	function validateUsername(){
		let name = document.getElementById("username").value;
		let regx = /^[a-z0-9_]*$/;
		if (!regx.test(name)) {
			document.getElementById("usernameresult").innerHTML = 'Usernames can only contain lowercase letters, numbers and "_"';
			return false;
		} else {
			document.getElementById("usernameresult").innerHTML = "";
			return true;
		}
	}
</script>