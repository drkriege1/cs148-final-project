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
		$<input type="text" name="price" maxlength="5" value="<? echo $slideRow[0][fld_price]; ?>"><br>.00	
	</fieldset>
	
	<fieldset>
		<legend>Available:</legend>
		Yes<input type="radio" name="availability" value="1"<? if ($slideRow[0][fld_availability] == 1 || $slideRow[0][fld_availability] != 0) echo ' checked=""'; ?>> 
		No<input type="radio" name="availability" value="0"<? if ($slideRow[0][fld_availability] == 0) echo ' checked=""'; ?>>
	</fieldset>
	
	<fieldset>
		<legend>Display:</legend>
		Yes<input type="radio" name="display" value="1"<? if ($slideRow[0][fld_display] == 1 || $slideRow[0][fld_display] != 0) echo ' checked=""'; ?>> 
		No<input type="radio" name="display" value="0"<? if ($slideRow[0][fld_display] == 0) echo ' checked=""'; ?>>
	</fieldset>
	
	<input type="submit" formaction="<? $_SERVER['PHP_SELF'] ?>">
</form>