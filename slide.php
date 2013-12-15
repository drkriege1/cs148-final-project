<?
	//This should probably be a require_once
	$title = "Emily Deutchman's Art ~ ";
	
	require_once "includes/connect.php";
	
	$sql = "select fld_name, fld_img_src, fld_description, fld_availability, 
	fld_price, fk_tag_name, fld_last_modified from tbl_art, tbl_art_tag 
	where pk_art_id=? and pk_art_id=fk_art_id and fld_display=1
	UNION 
	select fld_name, fld_img_src, fld_description, fld_availability, fld_price, 
	null as fk_tag_name, fld_last_modified from tbl_art  where pk_art_id=? and fld_display=1;";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($_SERVER['QUERY_STRING'], $_SERVER['QUERY_STRING']));
	$slideRow[] = $stmt->fetch(PDO::FETCH_ASSOC);
	$valid = false;
	if (count($slideRow[0]) == 7) {
		$valid = true;
		$title .= ucwords($slideRow[0][fld_name]);
		if ($slideRow[0][fld_availability] == 1) $availability = "(available)";
		else $availability = "(not available)";
		while ($temp = $stmt->fetch(PDO::FETCH_ASSOC)) {
			if (count($temp) == 7) $slideRow[] = $temp;
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
  			$email = substr(sha1('Emily Deutchman\'s Art'), 0, 30) . "@mailinator.com";
  			$subject = 'RE: '. $_SERVER['PHP_SELF'] ."?". $_SERVER['QUERY_STRING'];
  			$subject = urlencode($subject);
  			$sanitizedSubject = htmlspecialchars($subject);
  			echo "<a href='mailto:$email?Subject=$sanitizedSubject'>Send email about this item</a>";
  		}
  		require_once "includes/footer.php";
  	?>
  	
  </body>
  
</html>