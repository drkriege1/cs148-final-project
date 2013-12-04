<?	
	echo "<a href='gallery.php?all'>[ALL]</a><br>";
	
    $sql = "select pk_tag_name from tbl_tag;";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$tags[] = $row[pk_tag_name];
	}

    foreach ($tags as $tag) {
    	$tag = ucfirst($tag);
    	echo "<a href='gallery.php?$tag'>$tag</a><br>\n";
    }
    		
?>