<?php
/**
 * validates an image upload
 *
 * @param string $inputName index name in the $_FILES super global
 * @param array $acceptedTypes accepted file types, defaults to JPEG and PNG
 * @return resource valid image when image is detected as valid
 * @throws InvalidArgumentException if the image is not valid
 **/
function validateImage(string $inputName, array $acceptedTypes = ["image/jpeg", "image/png"]) {
	// if this is not an image, don't even bother
	if(in_array($_FILES[$inputName]["type"], $acceptedTypes) === false) {
		throw(new InvalidArgumentException("not a valid image"));
	}
	// generate an array of extensions based on MIME Types
	$acceptedExtensions = [];
	foreach($acceptedTypes as $type) {
		// silly JPEG
		if($type === "image/jpeg") {
			$acceptedExtensions[] = "jpg";
		}
		$acceptedExtensions[] = substr($type, strpos($type, "/") + 1);
	}
	// verify the extension
	$extension = explode(".", $_FILES[$inputName]["name"]);
	$extension = strtolower(end($extension));
	if(in_array($extension, $acceptedExtensions) === false) {
		throw(new InvalidArgumentException("not a valid image"));
	}
	// create the image data
	$image = false;
	foreach($acceptedExtensions as $extension) {
		// silly JPEG
		if($extension === "jpg") {
			continue;
		}
		$image = @call_user_func("imagecreatefrom$extension", $_FILES[$inputName]["tmp_name"]);
		if($image !== false) {
			break;
		}
	}
	// if the image wasn't created, throw an exception
	if($image === false) {
		throw(new InvalidArgumentException("not a valid image"));
	}
	// if the image was created, return it
	return($image);
}