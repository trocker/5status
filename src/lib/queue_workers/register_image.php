<?php



/*
* Queue Worker of type - Register Image -> Take the base64 encoded image and make it into different sizes and upload to S3
*/

include_once dirname(__FILE__).'/../wrappers/FileUpload.php';
include_once dirname(__FILE__).'/../wrappers/queue.php';
include_once dirname(__FILE__).'/../config.php';
include_once dirname(__FILE__).'/../generate_thumbnail_image.php';

define('TEMP_WORKSPACE','temp/');

//Make an object of type QueueWorker - tell the type of worker this is
$queueworker = new QueueWorker($queue_host, $queue_port, "register_picture");


//TODO: Make workers multithreaded
function run($job){
	$workload = $job->workload();

	//functionality start
	list($picture_blob, $picture_name) = unserialize($workload);


	file_put_contents(TEMP_WORKSPACE.$picture_name, $picture_blob);
	generate_image_thumbnail(TEMP_WORKSPACE.$picture_name, TEMP_WORKSPACE.$picture_name."_thumbnail");


	//upload the file
	$filestorage = new FileStorage();
	$thumbnail_upload_url = $filestorage->upload(TEMP_WORKSPACE.$picture_name."_thumbnail", "5status-images", $picture_name.".jpg");


	//delete all temp files
	unlink(TEMP_WORKSPACE.$picture_name);
	unlink(TEMP_WORKSPACE.$picture_name."_thumbnail");
	
	echo $thumbnail_upload_url;
	return $thumbnail_upload_url;
}


while($queueworker->dequeue());

//TODO: Log when the the worker is shutting down here