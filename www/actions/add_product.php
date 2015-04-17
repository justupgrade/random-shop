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
		if(isset($_POST['SubmitAddProductBtn'])) {
			require_once '../connection.php';
			DBObject::SetUpConnection($connection);
			
			$name = $_POST['new_product_name'];
			$price = $_POST['new_product_price'];
			$description = $_POST['new_product_description'];
			$category = $_POST['new_product_category'];
				
			Item::Create($name, $price, $description, 1, $category);
		}
	}
	
	header('Location: ../sites/home.php');
	die();

?>