<?
	//This should probably be a require_once
	$title = "Emily Deutchman's Art ~ ";
	
	require_once "includes/connect.php";
	
	if ($_SERVER['QUERY_STRING'] != '') {
		$sql = "select fld_name, fld_img_src, fld_description, fld_availability, fld_price, fk_tag_name, 
				fld_last_modified from tbl_art, tbl_art_tag where pk_art_id=? and pk_art_id=fk_art_id;";
		$stmt = $db->prepare($sql);
		$stmt->execute(array($_SERVER['QUERY_STRING']));
		$slideRow[] = $stmt->fetch(PDO::FETCH_ASSOC);
		$valid = false;
		if (count($slideRow[0]) == 7) {
			$valid = true;
			$title .= ucfirst($slideRow[0][fld_name]);
			if ($slideRow[0][fld_availability] == 1) $availability = "(available)";
			else $availability = "(not available)";
			while ($temp = $stmt->fetch(PDO::FETCH_ASSOC)) if (count($temp) == 7) $slideRow[] = $temp;
			foreach ($slideRow as $tagRow) {
				$tags[] = "<a href='gallery.php?".$tagRow[fk_tag_name]."'>".ucfirst($tagRow[fk_tag_name])."</a>";
			}
			$tags = implode(", ", $tags);
		} else {
			$error = "Error: Invalid Art ID";
			$title .= $error;
		}
	} else $title .= "New Item";
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
  				echo "    <h1>".ucfirst($slideRow[0][fld_name])."</h1>\n";
  				echo "    <ul>\n";
  				if ($slideRow[0][fld_description] != "") echo "      <li>Description: " .$slideRow[0][fld_description]. "</li>\n";
  				
  				if ($slideRow[0][fld_price] != "") echo "      <li>Price: $".$slideRow[0][fld_price]." ";
  				else echo "      <li>\n";
  				echo "$availability</li>\n";
  				
  				echo "      <li>Tags: $tags</li>\n";
  				echo "      <li>Last Modified: " .$slideRow[0][fld_last_modified]. "</li>\n"; 		
  				echo "    </ul>";
  			}
  		}
  		require_once "includes/slide_form.php";
  	?>	
  	
  </body>
  
</html>