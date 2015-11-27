<?php


/**
* Queue wrapper - Classes QueueClient QueueWorker 
*/

class QueueClient {
	
	private $gmclient= NULL;

	function __construct($queue_host, $queue_port) {
		$this->gmclient = new GearmanClient();
		$this->gmclient->addServer($queue_host, $queue_port);
	}

	function enqueue($job_type, $workload, $priority) {
		//TODO: depending upon $priority number do high, low or normal
		$this->gmclient->doBackground($job_type, $workload);
	}

	function enqueueSync($job_type, $workload, $priority) {
		return $this->gmclient->do($job_type, $workload);
	}
}


class QueueWorker {
	
	private $gmworker= NULL;
	private $worker_type = NULL;


	function __construct($queue_host, $queue_port, $worker_type) {
		$this->gmworker = new GearmanWorker();
		$this->gmworker->addServer($queue_host, $queue_port);
		$this->gmworker->worker_type = $worker_type;
		//Call when the work_run_time function when appropriate
		$this->gmworker->addFunction($worker_type, 'run');

	}

	function dequeue() {
		if($this->gmworker->work()){
			if ($this->gmworker->returnCode() != GEARMAN_SUCCESS) {
				//TODO: put logger here
			    return false;
			  }
			 return true;
			 
		}

	}
}

