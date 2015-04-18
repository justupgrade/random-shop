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
	
	$success = false;
	
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(isset($_POST['SubmitUpdateCategoryBtn'])) {
			require_once '../connection.php';
			DBObject::SetUpConnection($connection);
			
			$id = $_POST['updated_category_id'];
			$category = Category::Load($id);
			
			$name = $_POST['updated_category_name'];
			$parent = $_POST['update_category_parent'];
			
			$category->setName($name);
			$category->setParentID($parent);
			
			$success = Category::Update($category);
		}
	}
	
	header('Location: ../sites/home.php?success='.$success);
	die();

?>