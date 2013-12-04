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
    		// ...
    		$sql = "select distinct fk_tag_name, fld_img_src from tbl_art_tag, tbl_art where fk_art_id = pk_art_id group by fk_tag_name;";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$tags[$row[0]] = $row[1]
			}
    		
    		// Display an image for each tag that links to appropriately filtered gallery
    		foreach ($tags as $tag_name => $img_src) {
    			echo "<a href='gallery.php?$tag'>";
    			echo "<img class='thumbnail' src='$img_src' alt='$tag_name' />";
    			echo "<br><h1>$tag_name</h1></a>";
    		}
    		
    	}
    	
    	// if query is "all", display unfiltered gallery
    	// ...
    	else if ($_SERVER['QUERY_STRING'] == "all") {
    		require_once "includes/sidebar.php";
    	}
    	
    	// if query is some tag, display gallery filtered by that tag
    	// ...
    	else {
    		require_once "includes/sidebar.php";
    	}
    	
    	require_once "includes/footer.php";
    ?>
  </body>
  
</html>