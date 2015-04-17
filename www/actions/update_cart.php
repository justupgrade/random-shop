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
		require_once '../connection.php';
		DBObject::SetUpConnection($connection);
		
		$item_id = $_POST['in_cart_item_id'];
		$item = Item::Load($item_id);
		
		if(isset($_POST['AddMoreItemsSubmit'])) {//add more
			$cart->addItem($item);
			$_SESSION['cart'] = $cart;
		}elseif(isset($_POST['DecreaseItem'])) { //decrease
			$cart->removeItem($item);
			$_SESSION['cart'] = $cart;
		}elseif(isset($_POST['RemoveItem'])) { //remove totaly
			$cart->removeTotaly($item);
			$_SESSION['cart'] = $cart;
		}
	}
	
	header('Location: ../sites/home.php?cart=true');
	die();
	
?>