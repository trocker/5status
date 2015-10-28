<?php

/* 
*	Login Service - This will take JSON in the form of
*	{
*		'email_id':xxxx,
*		'password':xxxxxxx
*	}
*
*   It returns auth_key
*/

include_once dirname(__FILE__).'/../../lib/wrappers/logger.php';
include_once dirname(__FILE__).'/../../lib/wrappers/db.php';
include_once dirname(__FILE__).'/../../lib/config.php';
include_once dirname(__FILE__).'/../../lib/wrappers/inputvalidation.php'; //This library takes input and puts it in a $input variable

try { 
	$dbconn = new DBConn($dbhost, $dbuser, $dbpassword, $dbname);
} catch (Exception $e){
	echo $e->getMessage();
}
//Check if the password with salt is there in the database
$hashed_password = hash("sha256", $input['password'].$salt);

//If exists, allocate new auth_key and return the auth_key
$query = "SELECT * FROM accounts WHERE email_id = '".$input['email_id']."' AND password_hash = '".$hashed_password."'";
$result = $dbconn->execute($query);
if($result->num_rows > 0){
	$row = $result->fetch_assoc();
    $random = rand(1,9); for($i=0; $i<14; $i++) {$random .= rand(0,9);}
	$response['status'] = "success";
	$response['auth_key'] = $random;
	$response['user_id'] = $row['user_id'];
	$query_update_auth_key = "UPDATE accounts SET auth_key = '".$random."' WHERE email_id = '".$input['email_id']."'";
	$result_update_auth_key = $dbconn->execute($query_update_auth_key);
	$dbconn->close();
} else {
	$response['status'] = "failure";
	$response['message'] = "Wrong credentials. Try again.";
}

$dbconn->close();
echo json_encode($response);


