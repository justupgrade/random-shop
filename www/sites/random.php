<?php 
	function __autoload($name) {
		include_once '../classes/' . $name . '.php';
	}
	
	require_once '../connection.php';
	DBObject::SetUpConnection($connection);
	
	session_start();
	
	$admin = null;
	$user = null;
	$cart = null;
	
	if(isset($_SESSION['admin'])) {
		$admin = $_SESSION['admin'];
	}
	
	if(isset($_SESSION['user'])){
		
		$user = $_SESSION['user'];
		if(isset($_SESSION['cart'])) $cart = $_SESSION['cart'];
		else{
			$cart = new Cart();
			$_SESSION['cart'] = $cart;
		}
	}
?>	
	
<!DOCTYPE html>
<html>
<head>
	<title>Random</title>
	<style>@import url('../styles/home.css');</style>
</head>
<body>
	<section id='page-title-cont' class='default-style'>
<?php 
	if($user !== null) echo "Hello, " . $user->getEmail() . "<br>" ;
	if($admin !== null) echo "Hello Admin! (" .$admin->getEmail() . ")<br>";
?>
		Random Shop
	</section>
	<nav>
		<a href='home.php'><div class='nav-style orange-white-style'>Home</div></a>
		<a href='account.php'><div class='nav-style orange-white-style'>Account</div></a>
		<a href='contact.php'><div class='nav-style orange-white-style'>Contact</div></a>
		<a href='about.php'><div class='nav-style orange-white-style'>About</div></a>
		<a href='random.php'><div class='nav-style orange-white-style'>Random</div></a>
	</nav>
	<div id='cont3'>
		<div id='cont2'>
			<div id='cont1'>
				<div id='col1'>
				<!-- LIST OF SOMETHING -->
					list
				</div>
				
				<div id='col2'>
				<div> Main Page </div>
			</div>
				<div id='col3'>	
					<div>
<?php 
	if($user === null && $admin === null){
		include_once './includes/loginbutton.php'; 
		include_once './includes/create_account_btn.php';
	}
	else{
		include_once './includes/logoutbutton.php';
		if($admin === null) include_once './includes/small_cart.php';
	}
?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<footer id='footer' class='default-style'>
		<div id='left-footer'>random-shop.com</div>
		<div id='right-footer'>created by justupgrade</div>
	</footer>
</body>
</html>