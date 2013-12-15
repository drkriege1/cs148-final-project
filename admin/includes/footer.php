<?
	echo "\n";
	$path = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
	if (preg_match("|/admin|", $path) === 1) {
		$standard = preg_replace("|/admin|", "", $path);
		$standard = "<a href='$standard'>Standard</a>";
		$admin = "Admin";
	} else {
		$standard = "Standard";
		$admin = preg_replace("|cs148-final-project/|", "cs148-final-project/admin/", $path);
		$admin = "<a href='$admin'>Admin</a>";
	}
?>
<p>
	View: <? echo $standard; ?> | <? echo $admin; ?>
	<hr>
	Site Created by Doug Krieger, Copywrite 2013
</p>