<?php

/**
* Retreive all the cards for a user.
*
* The file takes a JSON of the following format:
* {
*   'user_id':xxxx,
*   'auth_key':xxxxxxx
* }
*
*/

include_once dirname(__FILE__).'/../../lib/wrappers/logger.php';
include_once dirname(__FILE__).'/../../lib/wrappers/db.php';
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
	$query = "SELECT * FROM cards WHERE owner_id='".$input['user_id']."' ORDER BY creation_date DESC";
	$result = $dbconn->execute($query);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			//get the latest comment
			$result_comment = $dbconn->execute("SELECT * FROM comments INNER JOIN accounts WHERE card_id='".$row['id']."'  AND accounts.user_id = comments.user_id ORDER BY comments.creation_date DESC");				
			
			if(! $result_comment->num_rows){
				$result_comment_latest = array("created_on" => $row['creation_date'], "comment" => "created the card.", "user_id" => $row['owner_id']);
			} else {
				$result_comment_latest = $result_comment->fetch_assoc();
			}
			//form a response
			$response['cards'][] = array("card_title" => $row['card_title'], "card_id" => $row['id'], "created_on" => $row['creation_date'], "owner_id" => $row['owner_id'], "status" => $row['card_status'],"number_of_comments"=>$result_comment->num_rows , "comments" => array(array("created_on" => $result_comment_latest['creation_date'], "comment" => $result_comment_latest['comment'], "user_id" => $result_comment_latest['user_id'],  "user_id" => $result_comment_latest['picture'])));
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