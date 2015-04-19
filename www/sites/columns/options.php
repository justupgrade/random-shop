<div>
	<fieldset>
		<legend>Options</legend>
		<div class='margin-top-spacing'>
<?php 
	if($user === null && $admin === null){
		include_once './includes/loginbutton.php'; 
		include_once './includes/create_account_btn.php';
	}
	else{
		include_once './includes/logoutbutton.php';
	}			
?>		</div>	
	</fieldset>
<?php if($admin === null && $user !== null) include_once './includes/small_cart.php';?>
</div>
