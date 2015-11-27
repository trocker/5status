<?php

include_once dirname(__FILE__).'/../../lib/wrappers/queue.php';
include_once dirname(__FILE__).'/../../lib/config.php';


$queueclient = new QueueClient($queue_host, $queue_port);


$queueclient->enqueue("reverse", serialize("hello world!"), 1);


function run($job){
	$workload = $job->workload();
	echo strrev(unserialize($workload));
	return strrev(unserialize($workload));
}

$queueworker = new QueueWorker($queue_host, $queue_port, "reverse");

$queueworker->dequeue();

