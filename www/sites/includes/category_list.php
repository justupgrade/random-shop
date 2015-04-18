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
<fieldset style='margin-top: 20px'>
	<legend>Remove Category</legend>
	<form method='post' action='../actions/remove_category.php'>
		<select name='remove_category_id'>
<?php 
	foreach($categories as $catIDX => $category) {
		if($catIDX === 0) continue; //omit category 1 -> 'uncategorized'
		echo "<option value='".$category->getID()."'>".$category->getName()."</option>";
	}
?>
		</select>
		<input type='submit' class='input-button' value='Remove Category' name='SubmitRemoveCategoryBtn'>
	</form>
</fieldset>
<?php } ?>