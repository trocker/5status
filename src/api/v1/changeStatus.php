<?php

/**
* Changes the status of the task and logs this in the comments. Only the card sharers can change the status.
*
* The file takes a JSON of the following format:
*	{
*		'user_id':xxxx,
*		'auth_key':xxxxxxx,
*		'card_id':<card_id>,
*		'card_status':<card_status>
*	}
*
*/

include_once dirname(__FILE__).'/../../lib/wrappers/logger.php';
include_once dirname(__FILE__).'/../../lib/wrappers/auth.php';
include_once dirname(__FILE__).'/../../lib/config.php';
include_once dirname(__FILE__).'/../../lib/wrappers/inputvalidation.php'; //This library takes input and puts it in a $input variable


/**
*	Do the DB query
*/

$authObject = new Authentication($input['user_id'], $input['auth_key'], $dbhost, $dbuser, $dbpassword, $dbname);

if($authObject->isAuthenticated()){
	/**
	 * 	Continue assuming user is Authenticated 
	 */
	$dbconn = new DBConn($dbhost, $dbuser, $dbpassword, $dbname);
	$query = "UPDATE cards SET card_status = '".$input['card_status']."' WHERE id = ".$input['card_id']."";
	$result = $dbconn->execute($query);

	//Add a comment saying who updated the card -> and type
	$dbconn->execute("INSERT INTO comments (comment, card_id, user_id, creation_date, type) VALUES ('changed the status to ".strtoupper($input['card_status']).".', ".$input['card_id'].", ".$input['user_id'].", ".time().", 'AUTO')");

	//TODO: Ask the user who is it queued on or waiting on

	$dbconn->close();

	$user_id = $input['user_id'];
	$response['status'] = 'success';
	$response['message'] = "Card updated successfully for $user_id";	
} else{
	$response['status'] = 'failure';
	$response['message'] = 'User could not be authenticated';
}

echo json_encode($response);