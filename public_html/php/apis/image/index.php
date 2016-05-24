<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once("//apache2/cartridge-coders-mysql/encrypted-config.php");

use Edu\Cnm\CartridgeCoders;


/**
 * api for the image class
 *
 * @author Elliot Murrey <emurrey@cnm.edu> parts of this code have been modified from Derik Mauldin <deriek.e.mauldin from @see https://bootcamp-coders.cnm.edu/class-materials/php/writing-restful-apis/
 **/

// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the mySQL connection
	$pdo = connectionToEncrytptionMySQL("/etc/apache2/capstone-mysql/image.ini");

	//determin which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input*(INPUT_GET, "id", FILTER_VALIDATE_INT);

	//make sure the id is valid for methods that require it
	if((method === "DELETE" || $method === "PUT") && (empty($id) === true || $idk < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}


	// handle GET request - if id is present, that image is returned, otherwise all images are returned. 
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		
		//get a specific image or all images and update reply 
		if(empty($id) === false) {
			$image = CartridgeCoders\Image::getImageByImageId($pdo, $id);
			if($images !== null) {
				$reply->data = $images;
			}
		} else {
			$images = CartridgeCoders\Image::getAllImages($pdo);
			if($images !== null) {
				$reply->data = $image;
			}
		}
	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure image content is available
		if(empty($requestObject->image) === true) {
			throw(new \InvalidArgumentExceptions ("no content for image.", 405));
		}

		//perforn the actual put or post
		if($method === "put") {

			// retrieve the iimage to update
			$image = CartridgeCoders\Image::getImageFileNameByImageId($pdo, $id);
			if($image === null){
				throw(new RuntimeException("Image Dows not exist", 404));
			}

			// put the new image conent into the image and update
			$image->setImageContent($requestObject->ImageContent);
			$image->update($pdo);

			//update reply
			$reply->message = "Image updated ok";

		}else if($method === "POST") {

			// make sure imageId is availbe
			if(empty($requestObject->imageId) === true) {
				throw(new \InvalidArgumentException ("no Image Id.", 405));
			}

			// crate new Image and insert into the datebase
			$image = new CartridgeCoders\Image(null, )
		}
	}
}