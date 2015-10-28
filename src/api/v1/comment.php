<?php

/**
* Make comments on a card
*
* The file takes a JSON of the following format:
* {
*   'user_id':xxxx,
*   'auth_key':xxxxxxx,
*   'comment':'Changing the job back to queued',
*   'id':<card_id>
* }
*
*/


/**
* Include dbwrapper, authentication_wrapper, logger
*/

include_once dirname(__FILE__).'/../../lib/wrappers/logger.php';
include_once dirname(__FILE__).'/../../lib/wrappers/auth.php';
include_once dirname(__FILE__).'/../../lib/config.php';
include_once dirname(__FILE__).'/../../lib/wrappers/inputvalidation.php'; //This library takes input and puts it in a $input variable

/**
* Do the DB query
*/

$authObject = new Authentication($input['user_id'], $input['auth_key'], $dbhost, $dbuser, $dbpassword, $dbname);

if($authObject->isAuthenticated()){
  /**
   *  Continue assuming user is Authenticated 
   */
  $dbconn = new DBConn($dbhost, $dbuser, $dbpassword, $dbname);
  $query = "INSERT INTO comments (comment, card_id, creation_date) VALUES ('".$input['comment']."', ".$input['id'].", time())";
  $result = $dbconn->execute($query);
  $dbconn->close();

  $user_id = $input['user_id'];
  $response['status'] = 'success';
  $response['message'] = "Comment added successfully";
} else{
  $response['status'] = 'failure';
  $response['message'] = 'User could not be authenticated';
}

echo json_encode($response);