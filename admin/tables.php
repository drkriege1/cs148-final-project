<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Emily Deutchman's Art ~ Display Tables</title>
  </head>
  <body>
	<?	// generate a table for database table
		require_once "includes/connect.php";
		require_once "includes/nav.php";
		require_once "includes/sidebar.php";
		
		$tables = array('tbl_art' => array(), 'tbl_tag' => array(), 'tbl_art_tag' => array());

		foreach ($tables as $table => $rows) {
			$sql = "select * from $table;";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			while ($rows[] = $stmt->fetch(PDO::FETCH_ASSOC));
			array_pop($rows);
			
			echo "<table border='1'>";
			echo "<caption>$table</caption>";
			//var_dump($rows);
			
			$labeled = false;
			
			foreach ($rows as $columns) {
	
				if (!$labeled) {
					echo "<tr>";
					foreach ($columns as $column => $value) {
						echo "<td>" . $column . "</td>";
					}
					echo "</tr>";
					$labeled = true;
				}
				
				echo "<tr>";
				foreach ($columns as $column => $value) {
					echo "<td>" . $value . "</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			echo "<br>";
		}
	?>	
  </body> 
</html>