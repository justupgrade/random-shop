<section class='default-style' id='login-form'>
	<form action='../actions/login.php' method='post'>
		<p><strong>Login</strong></p>
		<div class='form-feedback' id='login-form-feedback'></div>
		<div class='login-input'>
			<div>Email</div>
			<input type='text' name='email' id='emailID' placeholder='email@host.com' required>
			<div class='field-info' id='login-info'></div>
		</div>
		<div class='login-input'>
			<div>Password</div>
			<input type='password' name='password' id='passwordID' placeholder='password' required>
			<div class='field-info' id='password-info'></div>
		</div>
		<input class='blue-blue-style' type='submit' name='SubmitLoginBtn' id='loginFormBtn' value='Login'>
	</form>
</section>