<?
	function validImage($string) {
		
	}

	function validName($string) {
		if (strlen($string) == 0) return false;
		return true;
	}

	function validPrice($string) {
		if (preg_match("|\D|", $string)) return false;
		return true;
	}
	
?>