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
	$user = $_SESSION['user'];
	
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		require_once '../connection.php';
		DBObject::SetUpConnection($connection);
		
		//validate address!!!
		$user->setPostal($_POST['postal']);
		$user->setStreet($_POST['street']);
		$user->setCity($_POST['city']);
		
		//null cart after successfull order creation!
		if(Order::Create($user->getID(), $cart->getItemIndexes())) {
			$cart = null;
			$_SESSION['cart'] = null;
		}
	}
	
	header('Location: ../sites/home.php');
	die();
	
?>
