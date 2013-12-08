<?
	//This should probably be a require_once
	$title = "Emily Deutchman's Art ~ ";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <?
    	// Make page- and tag- specific title
    	$page = "Gallery";
    	$tag;
    	if ($_SERVER['QUERY_STRING'] == '' || $_SERVER['QUERY_STRING'] == "all") {
    		$title .= $page;
    	} else {
    		$tag = $_SERVER['QUERY_STRING'];
    		$tagUC = ucfirst($tag);
    		$title .= ": Art tagged '$tagUC'";
    	}
    ?>
    <title><? echo $title; ?></title>
  </head>

  <body>
    <?
    	require_once "includes/nav.php";
    	require_once "includes/connect.php";
    
    	// if no query, display images and names for tags
    	if ($_SERVER['QUERY_STRING'] == '') {
    		echo "<a href='gallery.php?all'><h1>View Entire Gallery</h1></a><br><br>";
    		
    		// do a mysql query to populate $tags[] appropriately
    		$sql = "select distinct fk_tag_name, fld_img_src from tbl_art_tag, tbl_art where fk_art_id = pk_art_id and fld_display = 1 group by fk_tag_name;";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$tags[$row[fk_tag_name]] = $row[fld_img_src];
			}

    		// Display an image for each tag that links to appropriately filtered gallery
    		foreach ($tags as $tag_name => $img_src) {
    			echo "<a href='gallery.php?$tag_name'>\n";
    			echo "<img class='thumbnail' src='$img_src' alt='$tag_name' />\n";
    			echo "<br><h1>$tag_name</h1></a>\n";
    		}
    		
    	}
    	
    	// if query is "all", display unfiltered gallery
    	else if ($_SERVER['QUERY_STRING'] == "all") {
    		require_once "includes/sidebar.php";
    		$sql = "select pk_art_id, fld_name, fld_img_src from tbl_art where fld_display = 1";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$art[$row[pk_art_id]] = array($row[fld_img_src], $row[fld_name]);
			}
    		foreach ($art as $id => $imgSrc_name) {
    			echo "<a href='slide.php?$id'>\n";
    			echo "<img class='thumbnail' src='$imgSrc_name[0]' alt='$imgSrc_name[1]' />\n";
    			echo "<br><h1>$imgSrc_name[1]</h1></a>\n";
    		}
    	}
    	
    	// if query is some tag, display gallery filtered by that tag
    	// ...
    	else {
    		require_once "includes/sidebar.php";
    		$sql = "select fk_art_id, fld_name, fld_img_src from tbl_art_tag, tbl_art where fk_tag_name=? and fk_art_id=pk_art_id and fld_display = 1 group by fk_art_id;";
			$stmt = $db->prepare($sql);
			$stmt->execute(array($_SERVER['QUERY_STRING']));
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$art[$row[fk_art_id]] = array($row[fld_img_src], $row[fld_name]);
			}
			if (!$art) {
				echo "Nothing has this tag...";
			} else {
    			foreach ($art as $id => $imgSrc_name) {
    				echo "<a href='slide.php?$id'>\n";
    				echo "<img class='thumbnail' src='$imgSrc_name[0]' alt='$imgSrc_name[1]' />\n";
    				echo "<br><h1>$imgSrc_name[1]</h1></a>\n";
    			}
    		}
    	}
    	
    	require_once "includes/footer.php";
    ?>
  </body>
  
</html>