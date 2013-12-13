<?
	//get array of tags called $tagNames
	$sql = "select pk_tag_name from tbl_tag";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	while ($tagNames[] = $stmt->fetchColumn());
	array_pop($tagNames);
	

	//Validation...
	require_once "includes/slide_form_validate.php";
	$isValid = false;
	$errors = array();
	$validName = validName($_POST['name']);
	$validPrice = validPrice($_POST['price']);
	if (!$validName) $errors[] = "<li>Error: invalid Name</li>";
	if (!$validPrice) $errors[] = "<li>Error: invalid Price</li>";
	if ($validName and $validPrice) $isValid = true;
	
	//if valid, update database
	if ($isValid) {
		//sanitize fields from $_POST (only text fields are actually sanitized)
		foreach ($_POST as $key => $value) {
			if ($key == 'submit' || $key == 'newTag' || $key == 'tags') {
			}
			elseif ($key == 'name' || $key == 'price' || $key == 'description') {
				$sanitizedFields[$key] = strtolower(htmlspecialchars($value, ENT_QUOTES));
			}
			else $sanitizedFields[$key] = $value;
		}
		//check if art is new or pre-existing
			//if pre-existing...
		if ($valid) {
			//delete tbl_art_tag entries where fk_art_id=pk_art_id
			$sql = "delete from tbl_art_tag where fk_art_id='". $_SERVER['QUERY_STRING'] ."';";
			//echo $sql;
			$stmt = $db->prepare($sql);
			$stmt->execute();
			//if necessary, add record to tbl_tag
			$tagsArray = $_POST['tags'];
			if (strlen($_POST['newTag']) > 0) {
				$tagsArray[] = $_POST['newTag'];
				$sql = "insert into tbl_tag set pk_tag_name=?;";
				$stmt = $db->prepare($sql);
				$stmt->execute(array($_POST['newTag']));
			}
			//add records to tbl_art_tag
			if (sizeof($tagsArray) > 0) {
				$sql = "";
				foreach ($tagsArray as $tag) {
					$sql .= "insert into tbl_art_tag set ";
					$sql .= "fk_tag_name=?, fk_art_id='". $_SERVER['QUERY_STRING'] ."'; ";
				}
				$stmt = $db->prepare($sql);
				/*
			$temp = $tagsArray;
			$temp = implode(", ". $_SERVER['QUERY_STRING'], $temp);
			$temp = explode(", ", $temp);
			$temp[] = $_SERVER['QUERY_STRING'];
			*/
				$stmt->execute($tagsArray);
			}
			//update tbl_art
			$sql = "update tbl_art set ";
			$sql .= "fld_display=:display, fld_name=:name, fld_img_src=:image, ";
			$sql .= "fld_description=:description, fld_availability=:availability, fld_price=:price ";
			$sql .= "where pk_art_id='". $_SERVER['QUERY_STRING'] ."';";
			$stmt = $db->prepare($sql);
			$stmt->execute($sanitizedFields);
			header("Location: ". $_SERVER['PHP_SELF'] ."?".$_SERVER['QUERY_STRING']);
		}
			//if new...
		elseif ($_SERVER['QUERY_STRING'] == ""){
			$sql = "insert into tbl_art set ";
			$sql .= "fld_display=:display, fld_name=:name, fld_img_src=:image, ";
			$sql .= "fld_description=:description, fld_availability=:availability, fld_price=:price;";
			$stmt = $db->prepare($sql);
			$stmt->execute($sanitizedFields);
			$sql = "select last_insert_id();";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$auto_ID = $stmt->fetchColumn();
			
			//if necessary add record to tbl_tag
			$tagsArray = $_POST['tags'];
			if (strlen($_POST['newTag']) > 0) {
				$tagsArray[] = $_POST['newTag'];
				$sql = "insert into tbl_tag set pk_tag_name=?;";
				$stmt = $db->prepare($sql);
				$stmt->execute(array($_POST['newTag']));
			}
			//add records to tbl_art_tag
			if (sizeof($tagsArray) > 0) {
				$sql = "";
				foreach ($tagsArray as $tag) {
					$sql .= "insert into tbl_art_tag set ";
					$sql .= "fk_tag_name=?, fk_art_id='". $auto_ID ."';";
				}
				$stmt = $db->prepare($sql);
				$stmt->execute($tagsArray);
			}
			header("Location: ". $_SERVER['PHP_SELF'] ."?$auto_ID");
		}
		
	} else {
		if ($valid) $addOrUpdate = "Update Art"; else $addOrUpdate = "Add Art";
	}
	/*
	else {
		echo "<ul>";
		foreach ($errors as $error) echo $error;
		echo "</ul>";
	}
	*/
?>