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
	$selectedCategory = null;
	$selectedItem = null;
	$showCart = null;
	$showConfirm = null;
	
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
	
	if(isset($_SESSION['category_id'])) $selectedCategory = $_SESSION['category_id'];
	else $selectedCategory = 1; //'uncategorized'
	
	if($_SERVER['REQUEST_METHOD'] === "POST") {
		if(isset($_POST['ShowLoginForm'])) $showLoginForm = true;
		elseif(isset($_POST['SubmitLogoutBtn'])) {
			$admin = null;
			$user = null;
			$cart = null; //save to cookie?
			session_destroy();
		}
		elseif(isset($_POST['SubmitChangeCategory'])) {
			$selectedCategory = $_POST['category_id'];
			$_SESSION['category_id'] = $selectedCategory;
		}
		elseif(isset($_POST['SubmitCreateAccountBtn'])) {
			$showCreateAccountForm = true;
		}elseif(isset($_POST['SubmitInputItem'])) {
			$selectedItem = $_POST['item_id'];
		}elseif(isset($_POST['ConfirmOrder']) && $user && !$admin) {
			$showConfirm = true;
		}
	} elseif($_SERVER['REQUEST_METHOD'] === 'GET'){
		if(isset($_GET['cart']) && $_GET['cart'] && $user && !$admin){
			$showCart = true;
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
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
				<!-- LIST OF CATEGORIES -->
<?php include_once './includes/category_list.php'; ?>
				</div>
				
				<div id='col2'>
				<div> Main Page </div>
<?php 
	if(isset($showConfirm) && $showConfirm) include_once './includes/confirm.php';
	else if(isset($showCart) && $showCart) include_once './includes/cart.php';
	else if(isset($showLoginForm) && $showLoginForm) include_once './includes/loginform.php';
	else if(isset($showCreateAccountForm) && $showCreateAccountForm) include_once './includes/create_account_form.php';
	
	//show products of currently selected category:
	else if(isset($selectedItem) && $selectedItem) include_once './includes/product_details.php';
	else if(isset($selectedCategory) && $selectedCategory) include_once './includes/list_of_products.php';
	
?>
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