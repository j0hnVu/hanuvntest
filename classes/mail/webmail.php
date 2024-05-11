<?php
class Webmail {
	public $to, $subject, $message, $header;
	function __construct() {
		$this->header = array(
			'MIME-Version' => '1.0',
			'Content-type' => 'text/html; charset=iso-8859-1',
    		'From' => 'FunE <mail@fune.cf>',
    		'Reply-To' => 'FunE <mail.fune.cf@gmail.com>',
    		'X-Mailer' => 'PHP/' . phpversion()
		);
	}
	function send() {
		return mail(
    		$this->to,
    		$this->subject,
    		$this->message,
    		$this->header,
		);
	}
}
	/*
	$mail = new Webmail();
	$mail->to = "luongkhang448@gmail.com";
	$mail->subject = "subject";
	$mail->message = "mess";
	$mail->send();
	$mail = null;
	*/
	
?>