<?php

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\CartridgeCoders;




/**
 * api for Account Class
 *
 * @author Donald Deleeuw <donald.deleeuw@gmail.com> based on code by Derek Mauldin <derek.e.mauldin@gmail.com>
 *
 */

// verify the session, start if not active
if(session_start() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cartridge.ini");

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id can not be empty or negative", 405));
	}

	// handle GET request - if id is present, that account is returned, otherwise all accounts are returned
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();

		// get a specific account or all accounts and update reply
		if(empty($id) === false) {
			$account = CartridgeCoders\Account::getAccountByAccountId($pdo, $id);
			if($account !== null) {
				$reply->data = $account;
			}
		} else {
			$accounts = CartridgeCoders\Account::getAllAccounts($pdo);
			if($accounts !== null) {
				$reply->data = $accounts;
			}
		}
	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// make sure account content is available
		if(empty($requestObject->accountContent) === true) {
			throw(new \InvalidArgumentException ("No content for Account", 405));
		}


		// perform actual put or post
		if($method === "PUT") {

			// retrieve the account to update
			$account = CartridgeCoders\Account::getAccountByAccountId($pdo, $id);
			if($account === null) {
				throw(new RuntimeException("Account does not exist", 404));
			}

			// put the new Account content into the account and update
			$account->setAccountContent($requestObject->accountContent);
			$account->update($pdo);

			// update reply
			$reply->message = "Account updated OK";

		} else if($method === "POST") {

			// make sure accountIf is available
			if(empty($requestObject->accountId) === true) {
				throw(new \InvalidArgumentException ("No Account Id", 405));
			}

			// create new account and insert into database
			$account = new CartridgeCoders\Account(null, $requestObject->accountId, $requestObject->accountContent, null);
			$account->insert($pdo);

			// update reply
			$reply->message = "Account created OK";
		}


	} else if($method === "DELETE") {
		verifyXsrf();

		// retrieve the Account to be deleted
		$account = CartridgeCoders\Account::getAccountByAccountId($pdo, $id);
		if($account === null) {
			throw(new RuntimeException("Account does not exist", 404));
		}

		// delete account
		$account->delete($pdo);

		// update reply
		$reply->message = "Account deleted ok";
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


//GET - all Accounts
//GET - Account by ID
//POST - new Account (create id)
//PUT - update Account by Id
//DELETE - deletes an Account by Id

?>


