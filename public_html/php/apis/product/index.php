<?php
use Edu\Cnm\CartridgeCoders;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");


/**
 * api for hte product class
 *
 * @author Elliot Murrey <emurrey@cnm.edu> parts of this code are modified from a code that was modified from the original created by Derik Mauldin <deriek.e.mauldin>
 **/

// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cartridge.ini");

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTT_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$accountId = filter_input(INPUT_GET, "accountId", FILTER_VALIDATE_INT);
	$imageId = filter_input(INPUT_GET, "imageId", FILTER_VALIDATE_INT);
	$productPrice = filter_input(INPUT_GET, "productPrice", FILTER_VALIDATE_FLOAT);
	$productDescription = filter_input(INPUT_GET, "productDescription", FILTER_SANITIZE_STRING);
	$productTitle = filter_input(INPUT_GET, "productTitle", FILTER_SANITIZE_STRING);
	$productAdminFee = filter_input(INPUT_GET, "productAdminFee", FILTER_VALIDATE_FLOAT);
	$productShipping = filter_input(INPUT_GET, "productShipping", FILTER_VALIDATE_FLOAT);
	$productSold = filter_input(INPUT_GET, "productSold", FILTER_VALIDATE_INT);


	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle GET request - if id is present, that product is returned, otherwise all products are returned.
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		// get a specific product or all products and update reply
		if(empty($id) === false) {
			$product = CartridgeCoders\Product::getProductByProductId($pdo, $id);
			if($product !== null) {
				$reply->data = $product;
			}
			// product by account id
		} elseif(empty($accountId) === false) {
			$product = CartridgeCoders\Product::getProductByProductAccountId($pdo, $accountId);
			if($product !== null) {
				$reply->data = $product;
			}
			// product by image id
		} elseif(empty($imageId) === false) {
			$product = CartridgeCoders\Product::getProductByProductImageId($pdo, $imageId);
			if($product !== null) {
				$reply->data = $product;
			}
			// get product by product price
		} elseif(empty($productPrice) === false) {
			$product = CartridgeCoders\Product::getProductByProductPrice($pdo, $productPrice);
			if($product !== null) {
				$reply->data = $product;
			}
			// get product by product description
		} elseif(empty($productDescription) === false) {
			$product = CartridgeCoders\Product::getProductByProductDescription($pdo, $productDescription);
			if($product !== null) {
				$reply->data = $product;
			}
			// get product by product title
		} elseif(empty($productTitle) === false) {
			$product = CartridgeCoders\Product::getProductByProductTitle($pdo, $productTitle);
			if($product !== null) {
				$reply->data = $product;
			}

		} else {
			$products = CartridgeCoders\Product::getAllProducts($pdo);
			if($products !== null) {
				$reply->data = $products;
			}
		}
	} elseif($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// make sure the product content is available
		if(empty($requestObject->productPrice) === true) {
			throw(new \InvalidArgumentException ("no content for product.", 405));
		}

		// perform the actual put or post
		if($method === "PUT") {

			// retrieve the product to update
			$product = CartridgeCoders\Product::getProductByProductId($pdo, $id);
			if($product === null) {
				throw(new RuntimeException("product does not exist", 404));
			}

			// put the new product image into the product and update
			$product->setProductImageId($requestObject->productImageId);
			$product->update($pdo);

			// update reply
			$reply->message = "product update ok";

			// update product price

			if(empty($requestObject->productPrice) !== true) {

				// retrieve the product to update
				$product = CartridgeCoders\Product::getProductByProductId($pdo, $id);
				if($product === null) {
					throw(new RuntimeException("product does not exist", 404));
				}

				// put the new product price into the product and update it
				$product->setProductPrice($requestObject->productPrice);
				$product->update($pdo);

				// update reply
				$reply->message = "product updated k";

			}
			// update product admin fee
			if(empty($requestObject->productAdminFee) !== true) {

				// retrieve the product to update
				$product = CartridgeCoders\Product::getProductByProductId($pdo, $id);
				if($product === null) {
					throw(new RuntimeException("product does not exist", 404));
				}

				// put the product admin fee into the product and update it
				$product->setProductAdminFee($requestObject->productAdminFee);
				$product->update($pdo);

				// update reply
				$reply->message = "product admin fee updated";
			}
			// update product description
			if(empty($requestObject->productDescription) !== true) {

				// retrieve the product to update
				$product = CartridgeCoders\Product::getProductByProductId($pdo, $id);
				if($product === null) {
					throw(new RuntimeException("product does not exist", 404));
				}

				// put the product description into the product and update it
				$product->setProductDescription($requestObject->productDescription);
				$product->update($pdo);

				// update reply
				$reply->message = "product  updated ok";

			}
			// updated product sold
			if(empty($requestObject->productSold) !== true) {

				// retrieve the product to update
				$product = CartridgeCoders\Product::getProductByProductId($pdo, $id);
				if($product === null) {
					throw(new RuntimeException("product does not exist", 404));
				}

				// put the product sold into the product and update it
				$product->setProductSold($requestObject->productSold);
				$product->update($pdo);

				//update reply
				$reply->message = "SOOOOOOOOOLD";
			}
			// update product shipping
			if(empty($requestObject->productShipping) !== true) {

				// retrieve the product to update
				$product = CartridgeCoders\Product::getProductByProductId($pdo, $id);
				if($product === null) {
					throw(new RuntimeException("product does not exist", 404));
				}

				// put the product shipping into the product and update it
				$product->setProductShipping($requestObject->productShipping);
				$product->update($pdo);

				// update reply
				$reply->message = "Product shipping is now updated";
			}
			// update product Title
			if(empty($requestObject->productTitle) !== true) {

				// retrieve the product to update
				$product = CartridgeCoders\Product::getProductByProductId($pdo, $id);
				if($product === null) {
					throw(new RuntimeException("prodct does not exist", 404));
				}

				// put the product title into the product and update it
				$product->setProductTitle($requestObject->productTitle);
				$product->update($pdo);

				// update reply
				$reply->message = "product was updated ok";
			}
		} elseif($method === "POST") {

			// make sure the productId is available
			if(empty($requestObject->productAccountId) === true && empty($requestObject->productImageId) === true) {
				throw(new \InvalidArgumentException ("no productAccountId or productImageId.", 404));
			}

			// create a new product and insert into the database
			$product = new CartridgeCoders\Product(null, $requestObject->productAccountId, $requestObject->productImageId, $requestObject->productAdminFee, $requestObject->productDescription, $requestObject->productPrice, $requestObject->productShipping, $requestObject->productSold, $requestObject->productTitle);
			$product->insert($pdo);

			// update reply
			$reply->product = "product created ok";
		}
	} elseif($method === "DELETE") {
		verifyXsrf();

		// retrieve the product to be deleted
		$product = CartridgeCoders\Product::getProductByProductId($pdo, $id);
		if($product === null) {
			throw(new RuntimeException("product does not exist", 404));
		}

		// delete Product
		$product->delete($pdo);

		// update reply
		$reply->message = "product was deleted";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}
	// update reply wiht exceptioon information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: aplication/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to from end caller
header("Content-type: application/json");
echo json_encode($reply);
