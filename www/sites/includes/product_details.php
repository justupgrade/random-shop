<section>
<fieldset>
<legend>Item Details:</legend>
<div class='margin-top-spacing'>
<?php 
	$item = Item::Load($selectedItem);
	
	$pictures = Picture::Load($selectedItem);

	
	//http://random-shop.com/home/tomasz/public_html/git/random-shop.com/www/uploads/3/2015/04/19/1b0e/logo.png
	
	
	if($user !== null) {
		echo $item->detailsToHtml();
		displayPictures($pictures);
		echo "<form method='post' action='../actions/add_to_cart.php'>";
		echo $item->addButtonHtml();
		echo "</form>";
	} elseif($admin !== null) {
		echo "<div id='photo-upload-container'>Drag photo(s) here, product will be automatically updated...</div>";
		displayPictures($pictures);
		//WHERE THE HELL THIS FORM HAS A CLOSING TAG?! DOES IT CLOSE AUTOMATICALLY OR DOES IT BREAK SITE?!
		echo "<form method='post' action='../actions/update_product.php'>";
		echo $item->getAdminDetails();
		echo $item->getAdminOptions();
	} else {
		displayPictures($pictures);
		echo $item->detailsToHtml();
	}
	
	function displayPictures($pictures) {
		if($pictures) {
			foreach($pictures as $picture) {
				$path = $picture->getPath();
				$pos = strpos($path,"www/");
				//echo "<img src='".substr($path, $pos+4)."' width='200'>";
				echo "<img src='../".substr($path, $pos+4)."' width='200'>";
			}
		}
	}
	
?>
</div>
</fieldset>
</section>

<script>

var currentItemID = null;

$(document).ready( function() {
	var obj = $("#photo-upload-container");

	if(!obj) return false;

	currentItemID = document.getElementById('updating_item_id').value;
	
	obj.on('dragenter', function (e)
	{
	    e.stopPropagation();
	    e.preventDefault();
	    $(this).css('border', '2px solid #0B85A1');
	});
	obj.on('dragover', function (e)
	{
	    e.stopPropagation();
	    e.preventDefault();
	});
	obj.on('drop', function (e)
	{
	    $(this).css('border', '2px dotted #0B85A1');
	    e.preventDefault();
	    var files = e.originalEvent.dataTransfer.files;
	 
	    handleFileUpload(files);
	});

	//prevent drop on document:
	$(document).on('dragenter', function (e)
	{
		e.stopPropagation();
		e.preventDefault();
	});
	$(document).on('dragover', function (e)
	{
		e.stopPropagation();
		e.preventDefault();
		obj.css('border', '2px dotted #0B85A1');
	});
	$(document).on('drop', function (e)
	{
		e.stopPropagation();
	 	e.preventDefault();
	});
});

	function handleFileUpload(files) {
		var i;
		for(i=0; i<files.length; i++) {
			if(files[i].type === "image/png") upload(files[i]);
		}
	}

	function upload(file) {
		var formData = new FormData();
		formData.append('filename', file);
		formData.append('item_id', currentItemID);

		var xhr = new XMLHttpRequest();
		xhr.addEventListener("load", onPhotoUploadComplete);
		xhr.open('POST','../actions/upload_photo.php',true);
		xhr.send(formData);
	}

	function onPhotoUploadComplete(e) {
		console.log(e.target.responseText);
	}

</script>