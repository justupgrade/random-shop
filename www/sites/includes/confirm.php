<?php
//confirm..
	if($user && $cart) {
?>
<form action='../actions/finalize_order.php' method='post'>
	<strong>Total Cost:</strong><?php echo $cart->getTotalCost(); ?><br>
	
	<pre>Postal: <input type='text' name='postal' value='<?php $user->getPostal(); ?>' required></pre>
	<pre>Street: <input type='text' name='street' value='<?php $user->getStreet(); ?>' required></pre>
	<pre>City:   <input type='text' name='city' value='<?php $user->getCity(); ?>' required></pre>
	<input type='submit' class='input-button' value='Confirm'>
</form>
<?php
	}
?>