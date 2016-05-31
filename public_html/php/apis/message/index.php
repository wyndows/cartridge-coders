<?php
use Edu\Cnm\CartridgeCoders;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
$config = readConfig("/etc/apache2/capstone-mysql/cartridge.ini");
$mailgunKeys = json_decode($config["privkeys"])->mailgun;

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
	$messageSenderId = filter_input(INPUT_GET, "messageSenderId", FILTER_VALIDATE_INT);
	$messageProductId = filter_input(INPUT_GET, "messageProductId", FILTER_VALIDATE_INT);
	$messageRecipientId = filter_input(INPUT_GET, "messageRecipientId", FILTER_VALIDATE_INT);
	$partyId = filter_input(INPUT_GET, "partyId", FILTER_VALIDATE_INT);
	$messageContent = filter_input(INPUT_GET, "messageContent", FILTER_SANITIZE_STRING);
	$messageSubject = filter_input(INPUT_GET, "messageSubject", FILTER_SANITIZE_STRING);

	//make sure the id is valid for methods that require it
	if($id < 0) {
		throw(new InvalidArgumentException("id cannot be negative", 405));
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
		} else if(empty($partyId) === false) {
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
		if(empty($requestObject->messageSenderId) === true && empty($requestObject->messageProductId) === true && empty($requestObject->messageRecipientId) === true) {
			throw(new \InvalidArgumentException ("No Sender, Recipient or Product Id.", 405));
		}

		// need to get account information for sending message
		//get a specific account

		$senderAccountInfo = CartridgeCoders\Account::getAccountByAccountId($pdo, $requestObject->messageSenderId);
//			if($senderAccountInfo !== null) {
//				$reply->data = $senderAccountInfo;
//			}
		$recipientAccountInfo = CartridgeCoders\Account::getAccountByAccountId($pdo, $requestObject->messageRecipientId);
//		if($recipientAccountInfo !== null) {
//			$reply->data = $recipientAccountInfo;
//		}


		// send message using mailgun
		$mailgunOptions = [
			"http" => [
				"method" => "POST",
				"header" => [
					"Authorization: Basic " . base64_encode("api:" . $mailgunKeys->key),
					"Content-type: application/x-www-form-urlencoded"
				],
				"content" => http_build_query([
//					"from" => "Senator Arlo <cartridgecoders@gmail.com>",
					"from" => $senderAccountInfo->getAccountUserName() . " " . "<" . $senderAccountInfo->getAccountPpEmail() . ">",
					"to" => $recipientAccountInfo->getAccountUserName() . " " . "<" . $recipientAccountInfo->getAccountPpEmail() . ">",
					"subject" => $requestObject->messageSubject,
					"text" => $requestObject->messageContent
				])
			]
		];
		$mailgunContext = stream_context_create($mailgunOptions);
		$status = file_get_contents($mailgunKeys->url, false, $mailgunContext);
		//testing message data


		// break apart return JSON data in $status
		$json = json_decode($status);
		// $messageMailGunId = ($json->user_id);
		$mailgunIdJson = ($json->id);
		$mailgunIdJson = substr($mailgunIdJson, 0, -53);
		$mailgunIdJson = str_replace("<", "", $mailgunIdJson);
		$messageMailGunId = str_replace(".", "", $mailgunIdJson);


		// create new message and insert into the database
		$message = new CartridgeCoders\Message(null, $requestObject->messageSenderId, $requestObject->messageProductId, $requestObject->messageRecipientId, $requestObject->messageContent, $messageMailGunId, $requestObject->messageSubject);
		$message->insert($pdo);

		// update reply
		$reply->message = "Message created OK";

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
