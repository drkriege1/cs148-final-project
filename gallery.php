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
    	if (!isset($_SERVER['QUERY_STRING']) || $_SERVER['QUERY_STRING'] == "all") {
    		$title .= $page;
    	} else {
    		$tag = $_SERVER['QUERY_STRING'];
    		$tagUC = ucfirst($tag);
    		$title .= ": Art tagged '$tagUC'";
    	}
    ?>
    <title>$title</title>
  </head>

  <body>
    <?
    	// if no query, display images images and names for tags
    	if (!isset($_SERVER['QUERY_STRING'])) {
    		echo "<a href='gallery.php?all'><h1>View Entire Gallery</h1></a><br><br>";
    		
    		// do a mysql query to populate $tags[][] appropriately
    		// ...
    		
    		// Display an image for each tag that links to appropriately filtered gallery
    		foreach ($tags as $t) {
    			echo "<a href='gallery.php?$tag'>";
    			echo "<img class='thumbnail' src='$t[img_src]' alt='$t[tag_name]' />";
    			echo "<br><h1>$t[tag_name]</h1></a>";
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
    		require_once "includes/sidebar.php"
    	}
    ?>
  </body>
  
</html>