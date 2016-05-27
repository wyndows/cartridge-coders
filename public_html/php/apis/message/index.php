<?php
use Edu\Cnm\CartridgeCoders;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");


/**
 * api for the Message class
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
	$senderId = filter_input(INPUT_GET, "senderId", FILTER_VALIDATE_INT);
	$recipientId = filter_input(INPUT_GET, "recipientId", FILTER_VALIDATE_INT);
	$productId = filter_input(INPUT_GET, "productId", FILTER_VALIDATE_INT);
	$content = filter_input(INPUT_GET, "content", FILTER_SANITIZE_STRING);
	$mailgunId = filter_input(INPUT_GET, "mailgunId", FILTER_SANITIZE_STRING);
	$subject = filter_input(INPUT_GET, "subject", FILTER_SANITIZE_STRING);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle GET request - if id is present, that feedback is returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific message and update reply
		if(empty($id) === false) {
			$message = CartridgeCoders\Message::getMessageByMessageId($pdo, $id);
			if($message !== null) {
				$reply->data = $message;
			}
			//get messages by party id and update reply
		} else if (empty($partyId) === false) {
			$messages = CartridgeCoders\Message::getMessageByPartyId($pdo, $partyId);
			if($messages !== null) {
				$reply->data = $messages;
			}
			}
	} else if($method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//  make sure senderId, recipientId and productId is available
		if(empty($requestObject->messageSenderId) === true && empty($requestObject->messageRecipientId) === true && empty($requestObject->messageProductId) === true) {
			throw(new \InvalidArgumentException ("No Sender, Recipient or Product Id.", 405));
		}

		// create new message and insert into the database
		$message = new CartridgeCoders\Message(null, $requestObject->messageSenderId, $requestObject->messageProductId, $requestObject->messageRecipientId, $requestObject->messageContent, $requestObject->messageMailGunId, $requestObject->messageSubject);
		$feedback->insert($pdo);

		// update reply
		$reply->message = "Feedback created OK";

	} else {
			throw (new InvalidArgumentException("Invalid HTTP method request"));
		}


	// update reply with exception information
} catch
(Exception $exception) {
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
