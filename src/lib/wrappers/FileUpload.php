<?php

/*
*	Library to do S3 Upload a file
*/

include_once dirname(__FILE__).'/../S3.php';
include_once dirname(__FILE__).'/../config.php';

class FileStorage {

	//Take the key from the config file
	private $awsAccessKey = NULL;
	private $awsSecretKey = NULL;
	private $s3 = NULL;

	function __construct() {
		$this->awsAccessKey = $GLOBALS['awsAccessKey'];
		$this->awsSecretKey = $GLOBALS['awsSecretKey'];
		$this->s3 = new S3($GLOBALS['awsAccessKey'], $GLOBALS['awsSecretKey']);
	}


	function upload($local_file_path, $bucket_name, $upload_name, $metaHeaders = array(), $request_headers = array()){
		$this->s3->putObject($this->s3->inputFile($local_file_path, false), $bucket_name, $upload_name, S3::ACL_PUBLIC_READ, $metaHeaders, $request_headers);
		return "https://s3-us-west-2.amazonaws.com/".$bucket_name."/".$upload_name."";
	}


	//TODO: an advanced upload with setting content_type
	function upload_advanced(){

	}
	//Function to upload the file, takes parameters - local_file_location, file_container, bucket, metadata. Return S3 uploaded URL.

	function download($bucket_name, $upload_name, $file_save_path){
		return $this->s3->getObject($bucket_name, $upload_name, $file_save_path);
	}
}


/* use src/api/v1/test.php to write a test script and run it with php */