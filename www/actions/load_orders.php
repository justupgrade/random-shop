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
		if(isset($_POST['status'])) {
			require_once '../connection.php';
			DBObject::SetUpConnection($connection);
			
			$status = $_POST['status'];
			$limit = $_POST['limit'];
			
			$orders = Order::GetAllOrdersByStatus($status, $limit);
			
			echo json_encode(array('status'=>'success', 'orders'=>$orders));
			die();
		}
	}
	
	header('Location: ../sites/home.php');
	die();

?>