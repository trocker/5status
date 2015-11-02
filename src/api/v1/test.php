<?php

include_once dirname(__FILE__).'/../../lib/wrappers/notifier.php';

$notifierObject = new Notifier();

$to = "nsteja1@gmail.com";
$from = "contact@5status.com";
$subject = "5status Test Mail";
$body = "Hello World!";
print_r($notifierObject->sendEmail($to, $from, $subject, $body));