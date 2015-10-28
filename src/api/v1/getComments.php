<?php

/**
* Get comments for a card
*
* The file takes a JSON of the following format:
*	{
*		'user_id':xxxx,
*		'auth_key':xxxxxxx,
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


/**
*	Do the DB query
*/

$authObject = new Authentication($input['user_id'], $input['auth_key'], $dbhost, $dbuser, $dbpassword, $dbname);

if($authObject->isAuthenticated()){
	/**
	 * 	Continue assuming user is Authenticated 
	 */
	$dbconn = new DBConn($dbhost, $dbuser, $dbpassword, $dbname);
	//Make query to get all comments on a card
	$query = "SELECT * FROM comments WHERE card_id = '".$input['card_id']."'";
	$result = $dbconn->execute($query);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()) {
			//Push it to the comments output
			$response['comments'][] = array("id" => $row['id'], "comment" => $row['comment'], "creation_date" => $row['creation_date']);
		}
	}

	$dbconn->close();

	$user_id = $input['user_id'];
	$response['status'] = 'success';
} else{
	$response['status'] = 'failure';
	$response['message'] = 'User could not be authenticated';
}

echo json_encode($response);