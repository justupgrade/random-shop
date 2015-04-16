<?php
	$db_host = "localhost";
	$db_user = "justupgrade";
	$db_pass = "test";
	$db_name = "random_shop";
	
	$connection = new mysqli($db_host,$db_user,$db_pass,$db_name);
	if($connection->connect_error) die("CONNECTION ERROR! " . $connection->connect_error);
?>