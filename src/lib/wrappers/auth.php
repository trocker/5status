<?php

/**
*	Takes a user and authentication key and returns the validity
*
*
*/


/**
*	Includer DB Wrapper and Configs
*
*/
include_once 'db.php';
include_once 'logger.php';
include_once '../config.php';

class Authentication {
	
	$user=NULL;
	$auth_key=NULL;
	$dbconn=NULL;
	$logger = new Logger();



	function __construct($user_init, $auth_key_init, $dbhost_init,
	$dbuser_init, $dbpassword_init, $dbname_init){ 
		$this->$user = $user_init;
		$this->$auth_key = $auth_key_init;


		try {
			$this->$dbconn = new DBConn($dbhost_init, $dbuser_init, $dbpassword_init, $dbname_init);
		} catch (Exception $e){
			$this->$logger->log('CRITICAL', 'Authentication Exception DBConn: '.$e->getMessage());
			throw new Exception("Authentication Exception");
		}
	}

	function isAuthenticated(){
		$query = "SELECT * FROM accounts WHERE user_id = $user AND auth_key = $auth_key";
		$result = $this->$dbconn->execute($query);
		if($result->num_rows > 0){
			return true;
		} else {
			return false;
		}
		$this->$dbconn->close();
	}
}