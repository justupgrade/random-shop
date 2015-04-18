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
		if(isset($_POST['SubmitRemoveCategoryBtn'])) {
			require_once '../connection.php';
			DBObject::SetUpConnection($connection);
			
			$id = $_POST['remove_category_id'];
			
			Category::Delete(Category::Load($id));
			$_SESSION['category_id'] = 1; //change category to 'uncategorized'
		}
	}
	
	header('Location: ../sites/home.php');
	die();

?>