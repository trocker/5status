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
	$query = "INSERT INTO cards (card_title, owner_id, creation_date, modified_date, card_status) VALUES ('".$input['card_title']."', '".$input['user_id']."', '".time()."', '".time()."', 'TO-DO')";
	$result = $dbconn->execute($query);
	$present_card_id = $dbconn->last_id(); 

	//Add the first comment, saying user added the card.
	$dbconn->execute("INSERT INTO comments (comment, card_id, user_id, creation_date, type) VALUES ('created the card.', ".$present_card_id.", ".$input['user_id'].", ".time().", 'AUTO')");


	//get this card's ID and add this user to card_sharers
	$dbconn->execute("INSERT INTO card_sharers (card_id, user_id, priority, creation_date) VALUES ('".$present_card_id."', '".$input['user_id']."', 1, '".time()."')");
	$dbconn->close();

	$user_id = $input['user_id'];
	$response['status'] = 'success';
	$response['message'] = "Card added successfully for $user_id with card_id $present_card_id";	
} else{
	$response['status'] = 'failure';
	$response['message'] = 'User could not be authenticated';
}

echo json_encode($response);