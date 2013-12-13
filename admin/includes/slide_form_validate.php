<?
	function validName($string) {
		if (strlen($string) == 0) return false;
		return true;
	}

	function validPrice($string) {
		if (strlen($string) == 0) return false;
		if (preg_match("|\D|", $string)) return false;
		return true;
	}
	
?>

<?
/*
if (isset($_POST) && $_SERVER['QUERY_STRING'] == '') {
	//$_POST["image"]
	foreach ($_POST as $f => $v) {
		if ($f == "name" || $f == "description") {
			$sanitizedFields[$f] = htmlspecialchars($v);
		} elseif ($f == "price") {
			$sanitizedFields[$f] = preg_replace("[^0-9]", "", $v);
		}
	}
	$sql = "insert into tbl_art set ";
	$sql .= "fld_display=:display, fld_name=:name, fld_img_src=:image, ";
	$sql .= "fld_description=:description, fld_availability=:availability, fld_price=:price;";
	$stmt = $db->prepare($sql);
	$stmt->execute($sanitizedFields)
}
*/
?>