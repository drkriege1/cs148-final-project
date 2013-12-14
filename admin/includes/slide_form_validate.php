<?php
	function validForm() {
		//$e = array();
		if (validName() !== true) $e[] = validName();
		if (validPrice() !== true) $e[] = validPrice();
		if (validImage() !== true) $e[] = validImage();
		//if (sizeof($e) == 0) return true;
		if (validName() === true && validPrice() === true && validImage() === true) return true;
		else return $e;
	}
////////////////////////////////////
	function validName() {
		if (strlen($_POST['name']) == 0) return "Error: Type in a 'Name'";
		return true;
	}

	function validPrice() {
		if (preg_match("|\D|", $_POST['price'])) return "Error: 'Price' Only Accepts Digits (0-9)";
		return true;
	}

	function validImage() {
		if ($_POST['leaveImage'] == 1) return true;
		if (isImage() === true) {
			if (uniqueImage() === true) {
				if (imageUploadSuccess() === true) {
					return true;
				} else return imageUploadSuccess();
			} else return uniqueImage();
		} else return isImage();
	}
	$targetFolder = "/users/d/r/drkriege/public_html/cs148/assignment7.1/cs148-final-project/img/";
	$httpFolder = "http://www.uvm.edu/~drkriege/cs148/assignment7.1/cs148-final-project/img/";

////////////////////////////////////////////////////////////////////////////////////////////////////
	function isImage() {
		if (empty($_FILES['image']['name'])) return "Error: Please Select an Image";
		if ($_FILES['image']['type'] != ("image/jpg" || "image/jpeg" || "image/png" || "image/gif")) {
			return "Error: File Must Be an Image with extension .jpg, .jpeg, .png, or .gif";
		} else return true;
	}
	function uniqueImage() {
		global $httpFolder;
		if (file_exists($httpFolder. $_FILES['image']['name'])) {
			return "Error: Image Name Already In Use, Please Rename Before Uploading";
		} else return true;
	}
	function imageUploadSuccess() {
		if ($_FILES['image']['error'] > 0) return "Error: Upload Error(s): " . $_FILES['image']['error'];
		else return true;
	}	
?>