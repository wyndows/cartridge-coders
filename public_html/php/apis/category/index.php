<?php
use Edu\Cnm\CartridgeCoders;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");


/**
 * api for the Category class
 *
 * @author Marlan Ball <wyndows2k@earthlink.net> based on code by Derek Mauldin
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cartridge.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}


	// handle GET request - if id is present, that category is returned, otherwise all categories are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific category or all categories and update reply
		if(empty($id) === false) {
			$category = CartridgeCoders\Category::getCategoryByCategoryId($pdo, $id);
			if($category !== null) {
				$reply->data = $category;
			}
		} else {
			$categories = CartridgeCoders\Category::getAllCategories($pdo);
			if($categories !== null) {
				$reply->data = $categories;
			}
		}
	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure category name is available
		if(empty($requestObject->categoryName) === true) {
			throw(new \InvalidArgumentException ("No name for category.", 405));
		}


		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the category to update
			$category = CartridgeCoders\Category::getCategoryByCategoryId($pdo, $id);
			if($category === null) {
				throw(new RuntimeException("Category does not exist", 404));
			}

			// put the new category name into the category and update
			$category->setCategoryName($requestObject->categoryName);
			$category->update($pdo);

			// update reply
			$reply->message = "Category updated OK";

		} else if($method === "POST") {

			// create new category and insert into the database
			$category = new CartridgeCoders\Category(null, $requestObject->categoryName);
			$category->insert($pdo);

			// update reply
			$reply->message = "Category created OK";
		}

	} else if($method === "DELETE") {
		verifyXsrf();

		// retrieve the Category to be deleted
		$category = CartridgeCoders\Category::getCategoryByCategoryId($pdo, $id);
		if($category === null) {
			throw(new RuntimeException("Category does not exist", 404));
		}

		// delete category
		$category->delete($pdo);

		// update reply
		$reply->message = "Category deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}

	// update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);