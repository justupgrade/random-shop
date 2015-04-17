<br style='clear: left'>
<section>
<p><strong> Item Details: </strong></p>
<?php 
	$item = Item::Load($selectedItem);
	
	
	
	if($user !== null) {
		echo $item->detailsToHtml();
		echo "<form method='post' action='../actions/add_to_cart.php'>";
		echo $item->addButtonHtml();
		echo "</form>";
	} elseif($admin !== null) {
		echo "<form method='post' action='../actions/update_product.php'>";
		echo $item->getAdminDetails();
		echo $item->getAdminOptions();
	} else {
		echo $item->detailsToHtml();
	}
	
?>
</section>