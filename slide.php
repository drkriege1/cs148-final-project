<?
	//This should probably be a require_once
	$title = "Emily Deutchman's Art ~ ";
	
	require_once "includes/connect.php";
	
	$sql = "select * from tbl_art where pk_art_id=?;";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($_SERVER['QUERY_STRING']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$title .= $row[fld_name];
	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>$title</title>
  </head>

  <body>
  	<img src=<?$row[fld_img_src]?> alt=<?$row[fld_name]?> />
  	
  	<h1><? echo ucfirst($row[fld_name]); ?></h1>
  	<ul>
  		<?
  			foreach ($row as $field => $value) {
  				if ($field != "fld_img_src") echo "<li>$field => $value</li>";
  			}
  		?>
  	</ul>
  	
  </body>
  
</html>