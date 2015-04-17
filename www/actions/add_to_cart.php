<?php
	session_start();
	function __autoload($name) {
		include_once '../classes/'.$name.'.php';
	}
	
	if(!isset($_SESSION['user']) || !isset($_SESSION['cart'])) {
		header('Location: ../sites/home.php');
		die();
	}
	
	$cart = $_SESSION['cart'];
	
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(isset($_POST['selected_item_id'])) {
			require_once '../connection.php';
			DBObject::SetUpConnection($connection);
			
			$item_id = $_POST['selected_item_id'];
			
			$cart->addItem(Item::Load($item_id));
			$_SESSION['cart'] = $cart;
		}
	}
	
	header('Location: ../sites/home.php');
	die();
	
?>