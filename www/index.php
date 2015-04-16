<?php
	echo "shop: index.php <br>";
	header('Location: ./sites/home.php');
	
	require_once 'connection.php';
	
	function __autoload($name) {
		include_once './classes/' . $name. '.php';
	}
	
	
?>