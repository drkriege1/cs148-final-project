<?
	//get array of tags called $tagNames
	$sql = "select pk_tag_name from tbl_tag";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	while ($tagNames[] = $stmt->fetchColumn());
	array_pop($tagNames);

	// skip field validation for 'deletingRecord()
	function deleteRecord() {
		global $db;
		$sql = "delete from tbl_art_tag where fk_art_id='". $_SERVER['QUERY_STRING'] ."'; ";
		$sql .= "delete from tbl_art where pk_art_id='". $_SERVER['QUERY_STRING'] ."';";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		header("Location: https://www.uvm.edu/~drkriege/cs148/assignment7.1/cs148-final-project/gallery.php");
		exit;
	}
	
	if ($_POST['deleteRecord'] == 1) deleteRecord();
	
	//Validation...
	if ($valid) {
		$addOrUpdate = "Update Art";
	} else $addOrUpdate = "Add Art";
	require_once "includes/slide_form_validate.php";
	$isValid = false;
	
	if ($_POST['submit'] == "Submit") {
		if (validForm() === true) $isValid = true;
		else {
			$tmp = validForm();
			foreach ($tmp as $e) $errors[] = "<li>$e</li>";
		}
	}
	
	//if valid, update database
	if ($isValid) {
		//clean up tbl_tag: delete tags that are not in tbl_art_tag
		$sql = "delete from tbl_tag where pk_tag_name not in (select fk_tag_name from tbl_art_tag) ;";
		$stmt = $db->prepare($sql);
		$stmt->execute();
	
		//sanitize fields from $_POST (only text fields are actually sanitized, others are excluded)
		foreach ($_POST as $key => $value) {
			if ($key == 'MAX_FILE_SIZE' || $key == 'deleteRecord' || $key == 'leaveImage' || $key == 'image' || $key == 'submit' || $key == 'newTag' || $key == 'tags') {
			} elseif ($key == 'name' || $key == 'price' || $key == 'description') {
				$sanitizedFields[$key] = strtolower(htmlspecialchars($value, ENT_QUOTES));			
			} else {
				$sanitizedFields[$key] = $value;
			}
		}
		//add $_FILES['image']
		if ($_POST['leaveImage'] === 0 || $valid !== true) {
			copy($_FILES['image']['tmp_name'], $targetFolder . $_FILES['image']['name']);
			$imgSrc = $httpFolder . $_FILES['image']['name'];
			$sanitizedFields['image'] = $imgSrc;
		} else $sanitizedFields['image'] = $slideRow[0][fld_img_src];
		
		//send email 'Successful Form Submission'
		$subject = "Successful Form Submission";
		$msg = "Form submitted with the following fields:<br><br>";
		foreach ($sanitizedFields as $name => $field) {
			$msg .= "  $name : $field<br>";
		}
		require_once "includes/mailMessage.php";
		$mail = sendMail("", $subject, $msg);
		
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
			exit;
		}
			//if new...
		elseif ($_SERVER['QUERY_STRING'] == ""){
			//var_dump($sanitizedFields);
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
			if (sizeof($_POST['tags']) != 0) $tagsArray = $_POST['tags'];
			if (strlen($_POST['newTag']) > 0) {
				//sanitize 'newTag'
				$newTag = strtolower(htmlspecialchars($_POST['newTag'], ENT_QUOTES));
				if (!in_array($newTag, $tagNames)) {
					$tagsArray[] = $newTag;
					$sql = "insert into tbl_tag set pk_tag_name=?;";
					$stmt = $db->prepare($sql);
					$stmt->execute(array($newTag));
				}
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
			exit;
		}
		
	}
	/*
	else {
		echo "<ul>";
		foreach ($errors as $error) echo $error;
		echo "</ul>";
	}
	*/
?>