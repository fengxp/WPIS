<?php
	error_reporting(0);
	$filename  = dirname(__FILE__).'/event/event.log';

	// infinite loop until the data file is not modified
	$lastmodif = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;
	if(!$lastmodif){
		echo "lastmodif is null\r\n";
	}
	$currentmodif = @filemtime($filename);
	//printf("lastmodif[%d] currentmodif[%d]", $lastmodif, $currentmodif);
	
	while ($currentmodif <= $lastmodif) // check if the data file has been modified
	{
	  @usleep(100000); // sleep 100ms to unload the CPU
	  @clearstatcache();
	  $currentmodif = @filemtime($filename);
	}

	// return a json array
	$response = array();
	$response['msg']       = file_get_contents($filename);
	$response['currentmodif'] = $currentmodif;
	$response['lastmodif'] = $lastmodif;
	$result = json_encode($response);

	$callback = $_GET['callback'];
	echo $callback."($result)"; 
	flush();

?>
