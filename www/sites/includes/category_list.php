<?php $category = Category::Load($selectedCategory);?>
<fieldset>
<legend>Categories</legend>
<div class='margin-top-spacing'>
<?php 
	$categories = Category::GetAll();
	Category::SetCurrentCategory($selectedCategory);
	foreach($categories as $cat) {
		echo "<form method='POST' action='home.php'>";
		echo $cat->toInputHtml();
		echo "</form>";
	}
?>
</div>
</fieldset>
<?php if($admin !== null) { //add category form ?>
<fieldset style='margin-top: 5px'>
	<legend>Update Category</legend>
	<form class='margin-top-spacing' method='post' action='../actions/update_category.php'>
		<input type='text' name='updated_category_name' placeholder='<?php echo $category->getName(); ?>'>
		<div>
			<select name='update_category_parent'>
				<option value='null'> no parent </option>
			</select>
		</div>
		<input type='submit' class='submit-btn-update' value='Update' name='SubmitUpdateCategoryBtn'>
		<input type='hidden' name='updated_category_id' value='<?php echo $selectedCategory; ?>'>
	</form>
</fieldset>
<fieldset style='margin-top: 5px'>
	<legend>Add Category</legend>
	<form class='margin-top-spacing' method='post' action='../actions/add_category.php'>
		<input type='text' name='new_category_name'>
		<div>
			<select name='new_category_parent'>
				<option value='null'> no parent </option>
			</select>
		</div>
		<input type='submit' class='submit-btn-add' value='Add' name='SubmitAddCategoryBtn'>
	</form>
</fieldset>
<fieldset style='margin-top: 5px'>
	<legend>Remove Category</legend>
	<form id='remove-category-form' class='margin-top-spacing' method='post' action='../actions/remove_category.php'>
		<div id="confirm-category-removal" style='display: none'>
			<div class="btn-back">
				<p id='category-removal-info'>Are you sure you want to do that?</p>
				<button class="yes">Yes</button>
				<button class="no">No</button>
			</div>
		</div>
		<div id='select-and-remove'>
			<select id='remove-category-select' name='remove_category_id'>
	<?php 
		foreach($categories as $catIDX => $cat) {
			$selected = "";
			if($cat->getID() === $selectedCategory) $selected = "selected";
			if($catIDX === 0) continue; //omit category 1 -> 'uncategorized'
			echo "<option $selected value='".$cat->getID()."'>".$cat->getName()."</option>";
		}
	?>
			</select>
		
		<input type='submit' id='btn-remove-category' class='sumbit-btn-remove' value='Remove' name='SubmitRemoveCategoryBtn'>
		</div>
	</form>
</fieldset>
<?php } ?>

<script>
	var removeConfirmed = false;
	var removeCategoryBtn = document.getElementById('btn-remove-category');

	if(removeCategoryBtn){ //that means admin's here!
		 removeCategoryBtn.addEventListener('click', onRemoveCategoryClick);
		 document.querySelector('.btn-back .yes').addEventListener('click', onYesClick);
		 document.querySelector('.btn-back .no').addEventListener('click', onNoClick);
	}

	function getRemoveCategoryName() {
		return document.getElementById('remove-category-select').selectedOptions[0].label;
	}

	function onRemoveCategoryClick(e) {
		if(!removeConfirmed) {
			e.preventDefault();
			document.getElementById('category-removal-info').innerHTML = 'Are you sure you want to remove: <strong>' + getRemoveCategoryName() + '</strong>?';
			document.getElementById('select-and-remove').style.display = 'none';
			document.getElementById('confirm-category-removal').style.display = 'block';
		}
	}

	function onYesClick(e) {
		e.preventDefault();
		removeConfirmed = true;
		document.getElementById('remove-category-form').submit();
	}

	function onNoClick(e) {
		e.preventDefault();
		removeConfirmed = false;
		document.getElementById('select-and-remove').style.display = 'block';
		document.getElementById('confirm-category-removal').style.display = 'none';
	}
</script>