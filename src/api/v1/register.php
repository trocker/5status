<?php

/* 
*	Register Service - Register a user
*
*	{
*		'email_id':xxxx,
*		'password':xxxxxxx,
*		<optional> 'picture':'http://xxxx.xxx/xxxx.jpg',
*		'name':'First Last',
		'picture':<base64_of_image>
*	}
*
*/


include_once dirname(__FILE__).'/../../lib/wrappers/logger.php';
include_once dirname(__FILE__).'/../../lib/wrappers/db.php';
include_once dirname(__FILE__).'/../../lib/config.php';
include_once dirname(__FILE__).'/../../lib/wrappers/inputvalidation.php'; //This library takes input and puts it in a $input variable
include_once dirname(__FILE__).'/../../lib/wrappers/queue.php';

$dbconn = new DBConn($dbhost, $dbuser, $dbpassword, $dbname);
//Check if the password with salt is there in the database
$hashed_password = hash("sha256", $input['password'].$salt);


//Check if the user_id exists in the database
$query = "SELECT * FROM accounts WHERE email_id = '".$input['email_id']."'";
$result = $dbconn->execute($query);
if($result->num_rows > 0){
	// User ID already exists
	$response['status'] = "failure";
	$response['message'] = "Email already registered";
} else {
	//Initiate a queu object
	$queue = new QueueClient($queue_host, $queue_port);
	$query_insert = "SELECT MAX(user_id) as max_user_id FROM accounts";
	$result_insert = $dbconn->execute($query_insert);
	$row = $result_insert->fetch_row();
	$incremented_user_id = intval($row[0])+1;
	//Check if picture is set or not
	if(!isset($input['picture'])){ $input['picture'] = $default_image; }
	else { 
		//Send the picture blob to get a link in return

		$input['picture'] = $queue->enqueue("register_picture", base64_decode($input['picture']), 1);
	}

	//Inset query now
	$query_insert = "INSERT INTO accounts (user_id, email_id, password_hash, auth_key, creation_date, modified_date, account_status, name, picture) VALUES (".$incremented_user_id.", '".$input['email_id']."', '".$hashed_password."', 'DEFAULT_AUTH', '".time()."', '".time()."', 'JOINED', '".$input['name']."',  '".$input['picture']."')";
	$result_insert = $dbconn->execute($query_insert);

	/* 
	* TODO: Change the status of the card_sharers table by the joined_comments. Also, edit and change the default user_id field which is NULL before the registraton.
	*/

	//Form successful response
	$response['status'] = "success";
	$response['messages'] = "Email registered successfully. Don't forget your password! Not yet.";
}


$dbconn->close();
echo json_encode($response);

