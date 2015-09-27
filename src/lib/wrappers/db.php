<?

/**
*	Initiates new DB Connection Object
*
*
*/


class DBConn{

	$dbconn = NULL;
	$dbhost = NULL;
	$dbuser = NULL;
	$dbpassword = NULL;
	$dbname = NULL;

	function __construct($dbhost_init, $dbuser_init, $dbpassword_init, $dbname_init){
		$this->$dbuser = $dbuser_init;
		$this->$dbhost = $dbhost_init;
		$this->$dbpassword = $dbpassword_init;
		$this->$dbname = $dbname_init;

		$this->$dbconn = mysqli_connect($this->$dbhost, $this->$dbuser, $this->$dbpassword, $this->$dbname);
		if($this->$dbconn->connect_error){
			throw new Exception("MYSQL connect error. Cant connect to the database.");
		}
	}

	function execute($query){
		return mysqli_query($this->$dbconn, $query);
	}

	function open(){
		$this->$dbconn = mysqli_connect($this->$dbhost, $this->$dbuser, $this->$dbpassword, $this->$dbname);
		if($this->$dbconn->connect_error){
			throw new Exception("MYSQL connect error. Cant connect to the database.");
		}
	}

	function close(){
		mysqli_close($this->$dbconn);
		$this->$dbconn=NULL;
	}
}