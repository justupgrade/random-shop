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
		if(isset($_POST['SubmitUpdateItem'])) {
			require_once '../connection.php';
			DBObject::SetUpConnection($connection);
				
			$item_id = $_POST['updating_item_id'];
			$item = Item::Load($item_id);
			$item->setName($_POST['new_name']);
			$item->setDescription($_POST['new_description']);
			$item->setPrice($_POST['new_price']);
			$item->setAmount(1);
			
			echo Item::Update($item) ? "successfully updated1" : "failure";
		}
	}
	
	header('Location: ../sites/home.php');
	die();

?>