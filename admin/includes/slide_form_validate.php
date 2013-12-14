<?php
	function validForm() {
		$e = array();
		if (validName()); else $e[] = validName();
		if (validPrice()); else $e[] = validPrice();
		if (validImage());
		else {
			if(is_array(validImage())) array_merge($e, validImage());
			else $e[] = validImage();
		}
		if (sizeof($e) == 0) return true;
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
		if (isImage()) {
			if (uniqueImage()) {
				if (imageUploadSuccess()) {
					return true;
				} else return imageUploadSuccess();
			} else return uniqueImage();
		} else return isImage();
	}
	$targetFolder = "/users/d/r/drkriege/public_html/cs148/assignment7.1/cs148-final-project/img/";
	$httpFolder = "http://www.uvm.edu/~drkriege/cs148/assignment7.1/cs148-final-project/img/";

////////////////////////////////////////////////////////////////////////////////////////////////////
	function isImage() {
		if (empty($_FILES['image'])) return "Error: Please Select an Image";
		if ($_FILES['image']['type'] != ("image/jpg" || "image/jpeg" || "image/png" || "image/gif")) {
			return "Error: File Must Be an Image with extension .jpg, .jpeg, .png, or .gif";
		} else return true;
	}
	function uniqueImage() {
		if (file_exists($httpFolder. $_FILES['image']['name'])) {
			return "Error: Image Name Already In Use, Please Rename Before Uploading";
		} else return true;
	}
	function imageUploadSuccess() {
		if (sizeof($_FILES['image']['error']) > 0) {
/*			$e = array();
			foreach ($_FILES['image']['error'] as $key => $value) {
				$e[] = "Image Upload Error: $key => $value";
			}
*/			return $e;
		} else return true;
	}	
?>