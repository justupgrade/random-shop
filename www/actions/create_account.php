<?php
	session_start();
	function __autoload($name) {
		include_once '../classes/'.$name.'.php';
	}

	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(isset($_POST['SubmitCreateAccountBtn']) && isset($_POST['email']) && isset($_POST['pass1']) && isset($_POST['pass2'])){
			require_once '../connection.php';
				
			$email = $connection->real_escape_string($_POST['email']);
			$pass1 = $connection->real_escape_string($_POST['pass1']);
			$pass2 = $connection->real_escape_string($_POST['pass2']);
				
			DBObject::SetUpConnection($connection);
			
			$validator = new InputValidator();
			if(!$validator->checkEmail($email)) {
				//error 
				header('Location: ../sites/home.php');
				die();
			} 
			
			if(!$validator->checkPasswords($pass1, $pass2)) {
				//error
				header('Location: ../sites/home.php');
				die();
			}
			
			$user = User::Create('', $email, $pass1);
			$_SESSION['user'] = $user;
		}
	}
	
	header('Location: ../sites/home.php');
	die();
?>