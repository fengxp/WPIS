<?php
	$id = isset($_GET['id']) ? $_GET['id'] : '';

	$filename  = dirname(__FILE__).'/../log/'.$id.'.txt';

	// infinite loop until the data file is not modified
	$lastmodif    = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;
	$currentmodif = filemtime($filename);

	while ($currentmodif <= $lastmodif) // check if the data file has been modified
	{
	  usleep(10000); // sleep 10ms to unload the CPU
	  clearstatcache();
	  $currentmodif = filemtime($filename);
	}

	// return a json array
	$response = array();
	$response['msg']       = file_get_contents($filename);
	$response['timestamp'] = $currentmodif;
	$response['lastmodif'] = $lastmodif;
	$result = json_encode($response);

	$callback = $_GET['callback'];
	echo $callback."($result)"; 
	flush();

?>