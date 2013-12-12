<?
	//This should probably be a require_once
	$title = "Emily Deutchman's Art ~ ";
	
	require_once "includes/connect.php";
	
	if ($_SERVER['QUERY_STRING'] != '') {
		$sql = "select fld_name, fld_img_src, fld_description, fld_availability, fld_price, fk_tag_name, 
				fld_last_modified from tbl_art, tbl_art_tag where pk_art_id=? and pk_art_id=fk_art_id;";
		$stmt = $db->prepare($sql);
		$stmt->execute(array($_SERVER['QUERY_STRING']));
		$row[] = $stmt->fetch(PDO::FETCH_ASSOC);
		$valid = false;
		if (count($row[0]) == 7) {
			$valid = true;
			$title .= ucfirst($row[0][fld_name]);
			if ($row[0][fld_availability] == 1) $availability = "(available)";
			else $availability = "(not available)";
			while ($temp = $stmt->fetch(PDO::FETCH_ASSOC)) if (count($temp) == 7) $row[] = $temp;
			foreach ($row as $tagRow) {
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
  				echo "<img src='".$row[0][fld_img_src]."' alt='".$row[0][fld_name]."'/>\n";
  				echo "    <h1>".ucfirst($row[0][fld_name])."</h1>\n";
  				echo "    <ul>\n";
  				if ($row[0][fld_description] != "") echo "      <li>Description: $row[0][fld_description]</li>\n";
  				
  				if ($row[0][fld_price] != "") echo "      <li>Price: $".$row[0][fld_price]." ";
  				else echo "      <li>\n";
  				echo "$availability</li>\n";
  				
  				echo "      <li>Tags: $tags</li>\n";
  				echo "      <li>Last Modified: " .$row[0][fld_last_modified]. "</li>\n"; 		
  				echo "    </ul>";
  			}
  		}
  		require_once "includes/slide_form.php";
  	?>	
  	
  </body>
  
</html>