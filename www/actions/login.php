<?php
	session_start();
	function __autoload($name) {
		include_once '../classes/'.$name.'.php';
	}
	
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(isset($_POST['SubmitLoginBtn']) && isset($_POST['email']) && isset($_POST['password'])){
			require_once '../connection.php';
			
			$email = $connection->real_escape_string($_POST['email']);
			$password = $connection->real_escape_string($_POST['password']);
			
			DBObject::SetUpConnection($connection);
			
			$user = User::Authenticate($email, $password);
			
			if($user) $_SESSION['user'] = $user;
		}
	}
		
	header('Location: ../sites/home.php');
	die();
	
?>