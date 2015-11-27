<?php

/*
	Notifier - A library to send notifications to an end point.
	Currently, implementing:
	- Email notifcations

*/

/*********************************************** Test Script for notifier 

include_once dirname(__FILE__).'/../../lib/wrappers/notifier.php';

$notifierObject = new Notifier();

$to = "nsteja1@gmail.com";
$from = "contact@5status.com";
$subject = "5status Test Mail";
$body = "Hello World!";
print_r($notifierObject->sendEmail($to, $from, $subject, $body));

*************************************************/

/* Include the required libraries
*/
require_once dirname(__FILE__).'/../mandrill-api-php/src/Mandrill.php';
include_once dirname(__FILE__).'/../config.php';

class Notifier {

	private $mandrill = NULL;
	
	function __construct(){
		$this->mandrill = new Mandrill($GLOBALS['mandrill_key']);
	}

	// An email sending wrapper
	function sendEmail($to, $from, $subject, $body){
		$message = new stdClass();
		$message->html = $body;
		$message->text = $body;
		$message->subject = $subject;
		$message->from_email = $from;
		$message->from_name  = "5Status";
		$message->to = array(array("email" => $to));
		$message->track_opens = false;
		$response = $this->mandrill->messages->send($message);
		return $response;
	}

}




?>