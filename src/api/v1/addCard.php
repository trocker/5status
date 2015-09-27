<?php

/**
* Accepts a card title from the user and places it in the databases [PHPDocs specific comments]
*
* The file takes a JSON of the following format:
*	{
*		'user_id':xxxx,
*		'auth_key':xxxxxxx,
*		'card_title':'Call up the plumber'
*	}
*
*/



/**
*	Include dbwrapper, authentication_wrapper, logger
*/

include_once '../../lib/logger.php';
include_once '../../lib/auth.php';
include_once '../../lib/config.php';
include_once '../../lib/inputvalidation.php'; //This library takes input and puts it in a $input variable


/**
*  TODO - Sanitize the input
*/


/**
*	Do the DB query
*/

$authObject = new Authentication($input['user_id'], $input['auth_key'], $dbhost, $dbuser, $dbpassword, $dbname);

if($authObject->isAuthenticated()){
	/**
	 * 	Continue assuming user is Authenticated 
	 */
	$dbconn = new DBConn($dbhost, $dbuser, $dbpassword, $dbname);
	$query = "INSERT INTO cards ('card_title', 'owner_id', 'creation_date', 'modified_date', 'card_status') VALUES ('".$input['card_title']."', '".$input['user_id']."', '".time()."', '".time()."', 'TO-DO')";
	$result = $dbconn->execute($query);
	$dbconn->close();

	$response['status'] = 'success';
	$response['message'] = 'Card added successfully for $user_id';	
} else{
	$response['status'] = 'failure';
	$response['message'] = 'User could not be authenticated';
}

echo json_encode($response);