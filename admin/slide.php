<?
	//This should probably be a require_once
	$title = "Emily Deutchman's Art ~ ";
	
	require_once "includes/connect.php";
	
	if ($_SERVER['QUERY_STRING'] != '') {
		$sql = "select fld_display, fld_name, fld_img_src, fld_description, fld_availability, 
		fld_price, fk_tag_name, fld_last_modified from tbl_art, tbl_art_tag 
		where pk_art_id=? and pk_art_id=fk_art_id 
		UNION 
		select fld_display, fld_name, fld_img_src, fld_description, fld_availability, fld_price, 
		null as fk_tag_name, fld_last_modified from tbl_art  where pk_art_id=?;";
		$stmt = $db->prepare($sql);
		$stmt->execute(array($_SERVER['QUERY_STRING'], $_SERVER['QUERY_STRING']));
		$slideRow[] = $stmt->fetch(PDO::FETCH_ASSOC);
		$valid = false;
		if (count($slideRow[0]) == 8) {
			$valid = true;
			$title .= ucwords($slideRow[0][fld_name]);
			if ($slideRow[0][fld_availability] == 1) $availability = "(available)";
			else $availability = "(not available)";
			while ($temp = $stmt->fetch(PDO::FETCH_ASSOC)) {
				if (count($temp) == 8) $slideRow[] = $temp;
			}
			foreach ($slideRow as $tagRow) {
				if ($tagRow[fk_tag_name] != "") {
					$tagsArray[] = $tagRow[fk_tag_name];
					$tags[] = "<a href='gallery.php?".$tagRow[fk_tag_name]."'>".ucwords($tagRow[fk_tag_name])."</a>";
				}
			}
			if (sizeof($tagsArray) > 0) $tags = implode(", ", $tags);
			else $tags = "None";

		} else {
			$error = "Error: Invalid Art ID";
			$title .= $error;
		}
	} else $title .= "New Item";
	require_once "includes/slide_form_processing.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><? echo $title; ?></title>
  </head>

  <body>
    <?	
    	require_once "includes/nav.php";
    	require_once "includes/sidebar.php";
    	if ($_SERVER['QUERY_STRING'] != '') {
    		if (!$valid) echo "<p>$error</p>";
    		else {
  				echo "<img src='".$slideRow[0][fld_img_src]."' alt='".$slideRow[0][fld_name]."'/>\n";
  				echo "    <h1>".ucwords($slideRow[0][fld_name])."</h1>\n";
  				echo "    <ul>\n";
  				if ($slideRow[0][fld_description] != "") echo "      <li>Description: " .$slideRow[0][fld_description]. "</li>\n";
  				
  				if ($slideRow[0][fld_price] != "") echo "      <li>Price: $".$slideRow[0][fld_price]." ";
  				else echo "      <li>\n";
  				echo "$availability</li>\n";
  				
  				echo "      <li>Tags: $tags</li>\n";
  				echo "      <li>Last Modified: " .$slideRow[0][fld_last_modified]. "</li>\n"; 		
  				echo "    </ul><br>";
  			}
  		}
  		if (!$isValid && $_POST['submit'] == "Submit") {
  			echo "<ul>";
  			foreach ($errors as $error) echo "\n$error";
  			echo "\n</ul>\n";
  		}
  		
  		if ($valid || $_SERVER['QUERY_STRING'] == "") require_once "includes/slide_form.php";
  		require_once "includes/footer.php";
  	?>	
  	
  </body>
  
</html>