<section>
<fieldset>
<legend><?php echo $category->getName(); ?> </legend>
<div class='margin-top-spacing'>
<?php

	$items = $category->getAllItems();
	
	if($items !== null) {
		foreach($items as $item) {
			echo "<form method='POST' action='home.php'>";
			echo $item->toInputHtml();
			echo "</form>";
		}
	}
?>
</div>
</fieldset>
<?php if($admin !== null) { //add item form ?>
<fieldset style='margin-top: 10px'>
	<legend>Add Product</legend>
	<div class='margin-top-spacing'>
	<form method='post' action='../actions/add_product.php'>
		<pre>Name: 			<input type='text' name='new_product_name'></pre>
		<pre>Description: 		<input type='text' name='new_product_description'></pre>
		<pre>Price:			<input type='text' name='new_product_price'></pre><br>
		Category:
		<select name='new_product_category'>
			<option value='<?php echo $category->getID();?>'> <?php echo $category->getName(); ?> </option>
		</select> <br> <br>
		<input type='submit' class='submit-btn-add' value='Add Product' name='SubmitAddProductBtn'>
	</form>
	</div>
</fieldset>
<?php } ?>
</section>