<?php 
	$categories = Category::GetAll();
	Category::SetCurrentCategory($selectedCategory);
	foreach($categories as $category) {
		echo "<form method='POST'>";
		echo $category->toInputHtml();
		echo "</form>";
	}
	
	if($admin !== null) { //add category form
?>
<fieldset style='margin-top: 20px'>
	<legend>Add Category</legend>
	<form method='post' action='../actions/add_category.php'>
		<input type='text' name='new_category_name'><br>
		Parent:
		<select name='new_category_parent'>
			<option value='null'> no parent </option>
		</select> <br> <br>
		<input type='submit' class='input-button' value='Add Category' name='SubmitAddCategoryBtn'>
	</form>
</fieldset>
<?php } ?>