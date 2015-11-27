<?php

/**
* Invite person to a card. 
* 1. Put it in card_sharers with the default user_id already defined in the database of NULL 
* 2. Put the user in accounts with account_status is INVITED
* 3. Send an email using the Notification service
* 4. Put the user in CARD_SHARERS with the joined_comments as NOT_JOINED_<email>
* The file takes a JSON of the following format:
*	{
*		'user_id':xxxx,
*		'auth_key':xxxxxxx,
*		'email_invited': <someone@example.com>,
*		'card_id':1
*	}
*
*/


/**
*	Include dbwrapper, authentication_wrapper, logger
*/

include_once dirname(__FILE__).'/../../lib/wrappers/logger.php';
include_once dirname(__FILE__).'/../../lib/wrappers/auth.php';
include_once dirname(__FILE__).'/../../lib/config.php';
include_once dirname(__FILE__).'/../../lib/wrappers/inputvalidation.php'; //This library takes input and puts it in a $input variable
include_once dirname(__FILE__).'/../../lib/wrappers/notifier.php';

/**
*	Do the DB query
*/

$authObject = new Authentication($input['user_id'], $input['auth_key'], $dbhost, $dbuser, $dbpassword, $dbname);

if($authObject->isAuthenticated()){
	$dbconn = new DBConn($dbhost, $dbuser, $dbpassword, $dbname);
	//check if the added user exists in the database and has joined
	$result = $dbconn->execute("SELECT * FROM accounts WHERE email_id='".$input['email_invited']."' AND account_status='JOINED'");
	$result_card_already_shared = $dbconn->execute("SELECT * FROM card_sharers WHERE joined_comments='NOT_JOINED_".$input['email_invited']."' AND card_id='".$input['card_id']."'");
	if($result->num_rows > 0){
		$result = $result->fetch_assoc();
		//add user to card_sharers
		$dbconn->execute("INSERT INTO card_sharers (card_id, user_id, priority, creation_date) VALUES ('".$input['card_id']."', '".$result['user_id']."', 1, '".time()."')");
		
	} else if($result_card_already_shared->num_rows > 0){
		//TODO: Refactor the email sending
		//if the user hasn't joined
		$result = $dbconn->execute("SELECT name FROM accounts WHERE user_id = '".$input['user_id']."'");
		//Get the name of the logged in user
		$result = $result->fetch_assoc();
		$name = $result['name'];

		//send him an email notification
		$notifier = new Notifier();
		$to = $input['email_invited'];
		$from = "no-reply@5status.com";
		$subject = $name." shared a task with you.";
		$body ="Hello!<br>Hope you're having a nice day today. <br><br>$name wants to share a task with you on 5status. The tasks will appear on your dashboard after you sign up at http://5status.com/register.php . <br><br>Hope you like 5status and the workflow! <br><br>- Team 5Status";
		$notifier->sendEmail($to, $from, $subject, $body);
	} else {
		//if the user hasn't joined
		$result = $dbconn->execute("SELECT name FROM accounts WHERE user_id = '".$input['user_id']."'");
		//Get the name of the logged in user
		$result = $result->fetch_assoc();
		$name = $result['name'];

		//send him an email notification
		$notifier = new Notifier();
		$to = $input['email_invited'];
		$from = "no-reply@5status.com";
		$subject = $name." shared a task with you.";
		$body ="Hello!<br>Hope you're having a nice day today. <br><br>$name wants to share a task with you on 5status. The tasks will appear on your dashboard after you sign up at http://5status.com/register.php . <br><br>Hope you like 5status and the workflow! <br><br>- Team 5Status";
		$notifier->sendEmail($to, $from, $subject, $body);
		//add him to card sharers with JOINED comments as NOT_JOINED_<email>
		$dbconn->execute("INSERT INTO card_sharers (card_id, user_id, joined_comments, priority, creation_date) VALUES ('".$input['card_id']."', 404, 'NOT_JOINED_".$input['email_invited']."', 1, '".time()."')");
	}
	
	$response['status'] = 'success';
	$response['message'] = "User has been added to the card.";	
} else{
	$response['status'] = 'failure';
	$response['message'] = 'User could not be authenticated';
}

echo json_encode($response);