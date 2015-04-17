<section class='default-style' id='create-account-form'>
	<form method='post' action='../actions/create_account.php'>
		<p><strong> Create Account</strong> </p>
		<div class='login-input'>
			<div>Email</div>
			<input type='text' name='email' id='create-email' placeholder='email@host.com'>
			<div class='field-info' id='create-account-email-info'></div>
		</div>
		<div class='login-input'>
			<div>Password</div>
			<input type='password' name='pass1' id='create-passwordID' placeholder='password' required>
			<div class='field-info' id='create-account-password-info'></div>
		</div>
		<div class='login-input'>
			<div>Password</div>
			<input type='password' name='pass2' id='repeat-passwordID' placeholder='password' required>
			<div class='field-info' id='repeat-password-info'></div>
		</div>
		<input class='green-green-style' type='submit' name='SubmitCreateAccountBtn' id='createFormBtn' value='Create Account'>
	</form>
</section>