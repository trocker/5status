<?php
require_once('./db.php');
require_once('./functions.php'); 

class User{
	
	protected static $table_name="accounts";
	public $id;
	public $user_id;
	public $password;
	public $email_id;
	
	public static function authenticate($user_id="", $password="") {
    global $database;
    $user_id = $database->escape_value($user_id);
	
	//password_check($password, );
	
	$password_hash = password_encrypt($this->password); 
    $password_hash = $database->escape_value($password_hash);
	
	$sql  = "SELECT * FROM accounts ";
    $sql .= "WHERE user_id = '{$user_id}' ";
    $sql .= "AND password_hash = '{$password_hash}' ";
    $sql .= "LIMIT 1";
    $result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
 

	// Common Database Methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
	public static function find_by_id($id=0) {
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
  
	public static function find_by_sql($sql="") {
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while ($row = $database->fetch_array($result_set)) {
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}

	private static function instantiate($record) {
		
		$object = new self;
		
		$object->id 		= $record['id'];
		$object->user_id 	= $record['user_id'];
		$object->password 	= $record['password'];
		$object->email_id 	= $record['email_id'];
		
		return $object;
	}

	public function save() {
	  // A new record won't have an id yet.
	  return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $database;
		$password_hash = password_encrypt($this->password); 

	    $sql = "INSERT INTO ".self::$table_name." (";
	    $sql .= "user_id, password_hash, email_id";
	    $sql .= ") VALUES ('";
		$sql .= $database->escape_value($this->user_id) ."', '";
		$sql .= $database->escape_value($password_hash) ."', '";
		$sql .= $database->escape_value($this->email_id) ."')";
		
		if($database->query($sql)) {
			$this->id = $database->insert_id();
			return true;
		} else {
			return false;
	  }
	}

	public function update() {
		
		global $database;
	  
		$password_hash = password_encrypt($this->password); 

		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= "user_id='". $database->escape_value($this->user_id) ."', ";
		$sql .= "password_hash='". $database->escape_value($password_hash) ."', ";
		$sql .= "email_id='". $database->escape_value($this->email_id) ."' ";
		$sql .= "WHERE id=". $database->escape_value($this->id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	public function delete() {
	  
	  global $database;
	
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE id=". $database->escape_value($this->id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

}

?>