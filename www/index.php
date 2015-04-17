<?php
	echo "shop: index.php <br>";
	header('Location: ./sites/home.php');

	function __autoload($name) {
		include_once './classes/' . $name. '.php';
	}
	
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		//type ok? if($_FILES['filename']['type'] === 'image/png') ...
		$file = $_FILES['filename']['tmp_name'];
		$name = $_FILES['filename']['name'];
		require_once 'connection.php';
		DBObject::SetUpConnection($connection);
		$item = Item::Load(1);
	}
?>
TESTED UPLOAD -> OFF
<form method='POST' enctype='multipart/form-data'>
	 <input type="file" name="filename" id="fileID"><br> 
	 <input type="submit" value="Upload File" id="uploadBtn"> 
</form>