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
		if(isset($_POST['SubmitAddCategoryBtn'])) {
			require_once '../connection.php';
			DBObject::SetUpConnection($connection);
			
			$name = $_POST['new_category_name'];
			$parent = $_POST['new_category_parent'];
			
			Category::Create($name, $parent);
		}
	}
	
	header('Location: ../sites/home.php');
	die();

?>