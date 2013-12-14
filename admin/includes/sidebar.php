<?	
	echo "<a href='gallery.php?all'>[ALL]</a><br>";
	
    $sql = "select distinct fk_tag_name from tbl_art_tag, tbl_art where fld_display = 1 and pk_art_id = fk_art_id group by fk_tag_name";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$tags_sidebar[] = $row[fk_tag_name];
	}

	if (sizeof($tags_sidebar) > 0) {
    	foreach ($tags_sidebar as $tag) {
    		$ucTag = ucwords($tag);
    		echo "<a href='gallery.php?$tag'>$ucTag</a><br>\n";
    	}
    }
    echo "<a href='gallery.php?hidden'>[HIDDEN]</a><br>";
    		
?>