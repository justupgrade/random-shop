<?php
	session_start();
	function __autoload($name) {
		include_once '../classes/'.$name.'.php';
	}
	
	if(!isset($_SESSION['admin'])) {
		header('Location: ../sites/home.php');
		die();
	}
	
	$admin = $_SESSION['admin'];
	
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		if($_FILES['filename']['error'] == 0) {
			require_once '../connection.php';
			DBObject::SetUpConnection($connection);
			$file = $_FILES['filename']['tmp_name'];
			$name = $_FILES['filename']['name'];
			$id = $_POST['item_id'];
			
			$item = Item::Load($id);
			$picture = Picture::Upload($name, $file, $item);
			
			if($picture !== null) {
				echo json_encode(array("status"=>"success", "name"=>$name));
			} else {
				echo json_encode(array("status"=>"error", "msg"=>"picture Error"));
			}
			die();
		} else {
			echo json_encode(array("status"=>"error", "msg"=>"file Error"));
			die();
		}
	} 
	
	//header('Location: ../sites/home.php');
	die();

?>