<?php $category = Category::Load($selectedCategory);?>
<?php 
	$categories = Category::GetAll();
	Category::SetCurrentCategory($selectedCategory);
	foreach($categories as $cat) {
		echo "<form method='POST'>";
		echo $cat->toInputHtml();
		echo "</form>";
	}
	
	if($admin !== null) { //add category form
?>
<fieldset style='margin-top: 20px'>
	<legend>Update Category</legend>
	<form method='post' action='../actions/update_category.php'>
		<input type='text' name='updated_category_name' placeholder='<?php echo $category->getName(); ?>'><br>
		Parent:
		<select name='update_category_parent'>
			<option value='null'> no parent </option>
		</select> <br> <br>
		<input type='submit' class='input-button' value='Update' name='SubmitUpdateCategoryBtn'>
		<input type='hidden' name='updated_category_id' value='<?php echo $selectedCategory; ?>'>
	</form>
</fieldset>
<fieldset style='margin-top: 20px'>
	<legend>Add Category</legend>
	<form method='post' action='../actions/add_category.php'>
		<input type='text' name='new_category_name'><br>
		Parent:
		<select name='new_category_parent'>
			<option value='null'> no parent </option>
		</select> <br> <br>
		<input type='submit' class='input-button' value='Add' name='SubmitAddCategoryBtn'>
	</form>
</fieldset>
<fieldset style='margin-top: 20px'>
	<legend>Remove Category</legend>
	<form method='post' action='../actions/remove_category.php'>
		<select name='remove_category_id'>
<?php 
	foreach($categories as $catIDX => $cat) {
		if($catIDX === 0) continue; //omit category 1 -> 'uncategorized'
		echo "<option value='".$cat->getID()."'>".$cat->getName()."</option>";
	}
?>
		</select>
		<input type='submit' class='input-button' value='Remove' name='SubmitRemoveCategoryBtn'>
	</form>
</fieldset>
<?php } ?>