<h1><? echo $addOrUpdate; ?></h1>
<form id="slideForm" method="post">
	<fieldset>
		<legend>Image:</legend>
		<input type="file" name="image" value="<? echo $slideRow[0][fld_img_src]; ?>"><br>
	</fieldset>
	
	<fieldset>
		<legend>Name:</legend>
		<input type="text" name="name" value="<? echo $slideRow[0][fld_name]; ?>"><br>
	</fieldset>
	
	<fieldset>
		<legend>Description:</legend>
		<textarea name="description" rows="4" cols="50" maxlength="200"><? echo $slideRow[0][fld_description]; ?></textarea><br>
	</fieldset>
	
	<fieldset>
		<legend>Price:</legend>
		$<input type="text" name="price" maxlength="4" value="<? echo $slideRow[0][fld_price]; ?>">.00<br>	
	</fieldset>
	
	<fieldset>
		<legend>Available:</legend>
		Yes<input type="radio" name="availability" value="1"<? if ($slideRow[0][fld_availability] == 1 || $slideRow[0][fld_availability] != 0) echo ' checked=""'; ?>> 
		No<input type="radio" name="availability" value="0"<? if ($slideRow[0][fld_availability] == 0) echo ' checked=""'; ?>>
	</fieldset>
	
	<fieldset>
		<legend>Display:</legend>
		<? $display = $slideRow[0][fld_display]; ?>
		Yes<input type="radio" name="display" value="1"<?  if ($display == 1) echo ' checked=""'; ?>> 
		No<input type="radio" name="display" value="0"<? if ($display != 1) echo ' checked=""'; ?>>
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
	
	<input type="submit" name="submit" value="Submit" formaction="<? echo $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']; ?>">
</form>