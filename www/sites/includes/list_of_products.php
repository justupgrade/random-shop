<section>
<p><strong> <?php echo $category->getName(); ?> </strong> </p>
<?php

	$items = $category->getAllItems();
	
	if($items !== null) {
		foreach($items as $item) {
			echo "<form method='POST'>";
			echo $item->toInputHtml();
			echo "</form>";
		}
	}
	
	if($admin !== null) { //add item form
?>
<fieldset>
	<legend>Add Product</legend>
	<form method='post' action='../actions/add_product.php'>
		<pre>Name: 			<input type='text' name='new_product_name'></pre>
		<pre>Description: 		<input type='text' name='new_product_description'></pre>
		<pre>Price:			<input type='text' name='new_product_price'></pre><br>
		Category:
		<select name='new_product_category'>
			<option value='<?php echo $category->getID();?>'> <?php echo $category->getName(); ?> </option>
		</select> <br> <br>
		<input type='submit' class='input-button' value='Add Product' name='SubmitAddProductBtn'>
	</form>
</fieldset>
<?php } ?>
</section>