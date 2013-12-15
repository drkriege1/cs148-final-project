<h1><? echo $addOrUpdate; ?></h1>
<? 
if (empty($_SERVER['QUERY_STRING'])) $formAction = $_SERVER['PHP_SELF'];
else $formAction = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
?>
<form id="slideForm" method="post" action="<? echo $formAction; ?>" enctype="multipart/form-data">
	<fieldset>
		<legend>Image:</legend>
		<?	
			if ($_POST['image'] != "") $uploadChecked = ' checked=""'; else $keepChecked = ' checked=""';
			if ($addOrUpdate == "Update Art") {
				echo '<label>Keep Existing Image<input type="radio" name="leaveImage" value="1" checked=""></label><br>';
				echo '<label>Upload New Image<input type="radio" name="leaveImage" value="0"></label><br>';
			}
		?>
		<input type="hidden" name="MAX_FILE_SIZE" value="3145728"> <!-- == 3 mb -->
		<input type="file" name="image"><br>
	</fieldset>
	
	<fieldset>
		<legend>Name:</legend>
		<input type="text" name="name" value="<? echo $_POST['name']; ?>"><br>
	</fieldset>
	
	<fieldset>
		<legend>Description:</legend>
		<textarea name="description" rows="4" cols="50" maxlength="200"><? echo $_POST['description']; ?></textarea><br>
	</fieldset>
	
	<fieldset>
		<legend>Price:</legend>
		$<input type="text" name="price" maxlength="4" value="<? echo $_POST['price']; ?>">.00<br>	
	</fieldset>
	
	<fieldset>
		<legend>Available:</legend>
		Yes<input type="radio" name="availability" value="1"<? if ($_POST['availability'] == 1 || $_POST['submit'] != "Submit") echo ' checked=""'; ?>> 
		No<input type="radio" name="availability" value="0"<? if ($_POST['availability'] == 0 && $_POST['submit'] == "Submit") echo ' checked=""'; ?>>
	</fieldset>
	
	<fieldset>
		<legend>Display:</legend>
		<? $display = $slideRow[0][fld_display]; ?>
		Yes<input type="radio" name="display" value="1"<?  if ($_POST['display'] == 1 || $_POST['submit'] != "Submit") echo ' checked=""'; ?>> 
		No<input type="radio" name="display" value="0"<? if ($_POST['display'] == 0 && $_POST['submit'] == "Submit") echo ' checked=""'; ?>>
	</fieldset>
	
	<fieldset>
		<legend>Tags:</legend>
		<?
			$tagFields = array();
			if (sizeof($tagsArray) == 0) $tagsArray = array();
			foreach ($tagNames as $tag) {
				$checked = "";
				if (in_array($tag, $tagsArray)) $checked = ' checked=""';
				$tagFields[] = ucfirst($tag) .'<input type="checkbox" name="tags[]" value="'. $tag .'"'. $checked .'">';
			}
			$tagFields = implode(' | ', $tagFields);
			echo $tagFields;
			echo "<br>";
		?>
		New Tag: <input type="text" name="newTag" maxlength="50">

	</fieldset>
	
	<fieldset>
		<legend>Submit Form</legend>
		<input type="submit" name="submit" value="Submit"><br>
		<?
		if ($addOrUpdate == "Update Art") {
			echo '<label>Normal Submit<input type="radio" name="deleteRecord" value="0" checked=""></label>';
			echo '<label>Delete Record<input type="radio" name="deleteRecord" value="1"></label>';
		}
		?>
	</fieldset>
</form>