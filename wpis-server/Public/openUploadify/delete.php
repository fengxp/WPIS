<?php

$data=(file_get_contents('php://input'));
$data=json_decode($data,true);
//echo $data['name'];
$file = "uploads/" . $data['name'];

if(!unlink ($file)){
	echo "false";
}else
	echo "true";
?>