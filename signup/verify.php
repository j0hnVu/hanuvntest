<?php $root = realpath($_SERVER["DOCUMENT_ROOT"]); ?>
<?php session_start(); ?>
<?php if(!empty($_SESSION["signup"])): ?>
	<!--<?php 
	$link = "http://fune.cf/signup/activate.php?id=".rawurlencode($_SESSION["id"]);
	$body = "Dear Client,<br><br>";
	$body .= "Thank you for registering with <a href='http://fune.cf' target='_blank'>FunE</a>.<br><br>";
	$body .= "Please click on the link below to activate your account. If the page does not display, you may copy and paste the link to your browser.<br><br>";
	$body .= "<a href='$link' target='_blank'>$link</a><br><br>";
	$body .= "Best regards<br><a href='http://fune.cf' target='_blank'>FunE</a>";
	$altbody = "Dear Client,\n\n";
	$altbody .= "Thank you for registering with FunE.\n\n";
	$altbody .= "To activate your account, please copy and paste the link below to your browser.\n\n";
	$altbody .= "$link\n\n";
	$altbody .= "Best regards\nfune.cf";
	require "$root/classes/mail/gmail.php";
	$gmail = new Gmail();
	$gmail->addAddress($_SESSION["email"]);
	$gmail->isHTML(true);
	$gmail->Subject = "FunE Activation";
	$gmail->Body = $body;
	$gmail->AltBody = $altbody;
	$gmail = $gmail->send();
	if (!$gmail) {
		$gmail = new Gmailtk();
		$gmail->to = $_SESSION["email"];
		$gmail->subject = "FunE Activation";
		$gmail->body = $body;
		$gmail->alt = $altbody;
		$gmail = $gmail->send();
		if ($gmail != "success") {
			echo $gmail;
	    	require "$root/classes/mail/webmail.php";
	    	$wmail = new Webmail();
	    	$wmail->to = $_SESSION["email"];
    		$wmail->subject = "FunE Activation";
    		$wmail->message = $body;
    		$wmail = $wmail->send();
    	}
	}
	?>-->
	<head>
		<?php require "$root/0/head.php"?>
		<title>HANU TESTS - Verify</title>
		<style>
			main {
				display: flex;
				flex-direction: column;
				align-items: center;
				margin-top: 10px;
			}
			article {
				display: flex;
				flex-direction: column;
				background-color: white;
				border-radius: var(--radius);
				box-shadow: var(--shadow);
				margin: 10px;
				padding: 15px;
				max-width: calc(100% - 50px);
				font-size: 120%;
			}
			article>img {
				align-self: center;
				margin-bottom: 10px;
			}
		</style>
	</head>
	<?php require "$root/0/nav.php"?>
	<main>
		<article>
			<img src="/icon/hanu.png" height="60px">
			<div>
				<?php 
				if($gmail == true || $gmail == "success") 
					echo "We have sent a link to your email. Please click on that link to activate your account. You have to activate your account before logging in.";
				elseif($wmail)
				    echo "We have sent a link to your email. Please click on that link to activate your account. You have to activate your account before logging in.<br>You may have to check your spam mails or the promotions.";
				else
					echo "ERROR. We are sorry about the discomfort.";
				?>
			</div>
		</article>
	</main>
<?php endif; ?>