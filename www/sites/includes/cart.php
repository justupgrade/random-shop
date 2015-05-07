<?php
	/*
	 * list of items
	 * change amount
	 * remove
	 * total price
	 * order
	 */
	
	echo "<strong>Cart</strong><br>";
	$items = $cart->getAllItems();
	
	foreach($items as $item) {
		echo "<form method='post' action='../actions/update_cart.php'>";
		echo $item->cartHtml();
		echo "</form>";
	}
	
	if($cart->getNumberOfProducts() > 0 )echo $cart->getfinalizeForm();
?>