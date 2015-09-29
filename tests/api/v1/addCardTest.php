<?php

//Check the database from 

include_once dirname(__FILE__).'../src/lib/wrappers/db.php';
$dbconn = new DBConn($dbhost, $dbuser, $dbpassword, $dbname);
$query = "SELECT * FROM cards ORDER BY id DESC LIMIT 0,1";
$result = $dbconn->execute($query);
while ($row = $result->fetch_row()) {
	print_r($row);
}