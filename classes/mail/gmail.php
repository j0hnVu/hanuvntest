<?php
include "PHPMailer.php";
include "Exception.php";
include "SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Gmail extends PHPMailer {
	function __construct() {
		parent::__construct(true);
		$this->isSMTP();
		$this->Debugoutput = "error_log";
		$this->SMTPDebug = 2;
		$this->SMTPAuth = true;
		$this->Mailer = 'smtp';
		$this->Host = 'smtp.gmail.com';
		$this->Port= 587;
		$this->Username = "mail.fune.cf@gmail.com";
		$this->Password = "02010603";
		$this->From = "mail.fune.cf@gmail.com";
		$this->FromName = "FunE";
		$this->addReplyTo("mail.fune.cf@gmail.com", "FunE");
	}
	function send() {
		try {
			return parent::send();
		} catch (Exception $e) {
			echo "Mailer Error: ", $this->ErrorInfo;
		}
	}
}
class Gmailtk {
	public $to, $subject, $body, $alt;
	function send() {
		$curl = curl_init();
		$to = urlencode($this->to);
		$subject = urlencode($this->subject);
		$body = urlencode($this->body);
		$alt = urlencode($this->alt);
		$url = "https://homeworknam.000webhostapp.com/classes/mail/gmail.php?to={$to}&subject={$subject}&body={$body}&alt={$alt}";
		echo $url;
		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
		]);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) 
			return "{\"cURL Error\":\"$err\"}";
		else 
			return $response;
	}
}
	/*
	$mail = new Gmail();
	$mail->addAddress("recipient@domain.com");
	$mail->addAttachment("img.jpg");
	$mail->isHTML(false);
	$mail->Subject = "subject";
	$mail->Body = "body";
	$mail->AltBody = "altBody";
	$mail->send();
	$mail = null;
	*/
?>