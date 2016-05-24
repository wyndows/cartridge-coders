<?php
use Edu\Cnm\CartridgeCoders;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");


/**
 * api for the Feedback class
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
	$partyId = filter_input(INPUT_GET, "partyId", FILTER_VALIDATE_INT);
	$senderId = filter_input(INPUT_GET, "senderId", FILTER_VALIDATE_INT);
	$recipientId = filter_input(INPUT_GET, "recipientId", FILTER_VALIDATE_INT);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	//make sure the party id is valid for the method that requires it
	if(($method === "GET") && (empty($partyId) === true || $partyId < 0)) {
		throw(new InvalidArgumentException("party id cannot be empty or negative", 405));
	}

	//make sure the sender id is valid for the method that requires it
	if(($method === "GET") && (empty($senderId) === true || $senderId < 0)) {
		throw(new InvalidArgumentException("sender id cannot be empty or negative", 405));
	}

	//make sure the recipient id is valid for the method that requires it
	if(($method === "GET") && (empty($recipientId) === true || $recipientId < 0)) {
		throw(new InvalidArgumentException("recipient id cannot be empty or negative", 405));
	}

	// handle GET request - if id is present, that feedback is returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific feedback and update reply
		if(empty($id) === false) {
			$feedback = CartridgeCoders\Feedback::getFeedbackByFeedbackId($pdo, $id);
			if($feedback !== null) {
				$reply->data = $feedback;
			}
		}

		//get feedbacks by party id and update reply
		if(empty($partyId) === false) {
			$feedbacks = CartridgeCoders\Feedback::getFeedbackByPartyId($pdo, $partyId);
			if($feedbacks !== null) {
				$reply->data = $feedbacks;
			}

			//get feedbacks by sender id and update reply
			if(empty($senderId) === false) {
				$feedbacks = CartridgeCoders\Feedback::getFeedbackByFeedbackSenderId($pdo, $senderId);
				if($feedbacks !== null) {
					$reply->data = $feedbacks;
				}

				//get feedbacks by recipient id and update reply
				if(empty($partyId) === false) {
					$feedbacks = CartridgeCoders\Feedback::getFeedbackByFeedbackRecipientId($pdo, $recipientId);
					if($feedbacks !== null) {
						$reply->data = $feedbacks;
					}


				} else if($method === "PUT" || $method === "POST") {

					verifyXsrf();
					$requestContent = file_get_contents("php://input");
					$requestObject = json_decode($requestContent);

					//make sure feedback content is available
					if(empty($requestObject->feedbackContent) === true) {
						throw(new \InvalidArgumentException ("No content in feedback.", 405));
					}
					//make sure feedback rating is available
					if(empty($requestObject->feedbackRating) === true) {
						throw(new \InvalidArgumentException ("No rating in feedback.", 405));
					}

					//perform the actual put or post
					if($method === "PUT") {

						// update feedback content if it needs updated
						if(($requestObject->feedbackContent) === true) {

							// retrieve the feedback to update
							$feedback = CartridgeCoders\Feedback::getFeedbackByFeedbackId($pdo, $id);
							if($feedback === null) {
								throw(new RuntimeException("Feedback does not exist", 404));
							}

							// put the new feedback content into the feedback and update
							$feedback->setFeedbackContent($requestObject->feedbackContent);
							$feedback->update($pdo);

							// update reply
							$reply->message = "Feedback updated OK";

							// update feedback rating if it needs updated
						}
						if(($requestObject->feedbackRating) === true) {

							// retrieve the feedback to update
							$feedback = CartridgeCoders\Feedback::getFeedbackByFeedbackId($pdo, $id);
							if($feedback === null) {
								throw(new RuntimeException("Feedback does not exist", 404));
							}

							// put the new feedback rating into the feedback and update
							$feedback->setFeedbackRating($requestObject->feedbackRating);
							$feedback->update($pdo);

							// update reply
							$reply->message = "Feedback updated OK";

						} else if($method === "POST") {

							//  make sure senderId or recipientId is available
							if(empty($requestObject->feedbackSenderId) === true || empty($requestObject->feedbackRecipientId) === true) {
								throw(new \InvalidArgumentException ("No Sender or Recipient ID.", 405));
							}

							// create new feedback and insert into the database
							$feedback = new CartridgeCoders\Feedback(null, $requestObject->feedbackSenderId, $requestObject->feedbackProductId, $requestObject->feedbackRecipientId, $requestObject->feedbackContent, $requestObject->feedbackRating);
							$feedback->insert($pdo);

							// update reply
							$reply->message = "Feedback created OK";
						}

					} else if($method === "DELETE") {
						verifyXsrf();

						// retrieve the Feedback to be deleted
						$feedback = CartridgeCoders\Feedback::getFeedbackByFeedbackId($pdo, $id);
						if($feedback === null) {
							throw(new RuntimeException("Feedback does not exist", 404));
						}

						// delete feedback
						$feedback->delete($pdo);

						// update reply
						$reply->message = "Feedback deleted OK";
					} else {
						throw (new InvalidArgumentException("Invalid HTTP method request"));
					}
				}
			}
		}
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