<!DOCTYPE html>

<html>
	<head>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<title>Login with PayPal - v3</title>
	</head>
	<body>

<div class="container">
	<div class="col-md-12">
		<div class="well">
			<p><strong>Welcome!! You are now a member of ROMuLess</strong></p>
		</div>
	</div>



		<?php
		// ---------------------------------------- encrypted config files -------------------------------------
		require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
		$config = readConfig("/etc/apache2/capstone-mysql/cartridge.ini");
		$paypal = json_decode($config["privkeys"])->paypal;
		// --------------------------------------------- get auth code -----------------------------------------
		require_once(dirname(__DIR__) . "/vendor/autoload.php");
		$authCode = filter_input(INPUT_GET, "code", FILTER_SANITIZE_STRING);
		// ----- TEMP VERIFY DATA - TO BE REMOVED
		//		echo nl2br("authCode: \n");
		//		print_r($authCode);
		//		echo nl2br("\n");
		//		echo nl2br("\n");
		//------------------------------------------------ cURL ------------------------------------------------
		// ----- @see https://developer.paypal.com/docs/api/#identity
		// ----- @see http://incarnate.github.io/curl-to-php/
		// ----- cURL - initialize session - get access token from authorization code
		$ch = curl_init();
		// ----- cURL - set options
		curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/identity/openidconnect/tokenservice");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=" . $paypal->clientId . "&client_secret=" . $paypal->clientSecret . "&grant_type=authorization_code&code=" . $authCode);
		curl_setopt($ch, CURLOPT_POST, 1);
		// ----- cURL - get results
		$accessToken = curl_exec($ch);
		// ----- cURL - error checking
		if(curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		// ----- cURL - close session
		curl_close($ch);
		// ----- TEMP VERIFY DATA - TO BE REMOVED
//		echo nl2br("accessToken JSON: \n");
//		print_r($accessToken);
//		echo nl2br("\n");
//		echo nl2br("\n");
		// ------ break apart return JSON data in $accessToken
		$json = json_decode($accessToken);
		$accessTokenExtractToken = ($json->access_token);
		// ----- TEMP VERIFY DATA - TO BE REMOVED
//		echo nl2br("accessToken JSON extraction: \n");
//		echo $accessTokenExtractToken;
//		echo nl2br("\n");
//		echo nl2br("\n");
		// ----- cURL - get user attributes
		// @see https://developer.paypal.com/docs/api/#get-user-information
		// @see http://incarnate.github.io/curl-to-php/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/identity/openidconnect/userinfo/?schema=openid");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		$headers = array();
		$headers[] = "Authorization: Bearer " . $accessTokenExtractToken;
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$userAttributes = curl_exec($ch);
		if(curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		// ----- cURL - verify data (REMOVE LATER)
//		echo nl2br("userAttributes JSON: \n");
//		print_r($userAttributes);
//		echo nl2br("\n");
//		echo nl2br("\n");
		// ------ break apart return JSON data in $userAttributes
		$json = json_decode($userAttributes);
		//		$userAttributesUserId = ($json->user_id);
		$userAttributesName = ($json->name);
		$userAttributesEmail = ($json->email);
		$userAttributesFirstName = ($json->given_name);
		// ----- TEMP VERIFY DATA - TO BE REMOVED
//		echo nl2br("accessToken JSON extraction: \n");
//		echo "Full Name: " . $userAttributesName;
//		echo nl2br("\n");
//		echo "Email: " . $userAttributesEmail;
//		echo nl2br("\n");
//		echo nl2br("\n");

		var_dump($userAttributesName);
		var_dump($userAttributesEmail);
		var_dump($userAttributesFirstName);

		//--------------------------------------------- Enter into mySQL ---------------------------------------------



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
				if(empty($requestObject->accountName) === true) {
					throw(new \InvalidArgumentException ("No content for account - get it together already.", 405));
				}


				// perform actual put or post
				if($method === "PUT") {

					// retrieve the account to update
					$account = CartridgeCoders\Account::getAccountByAccountId($pdo, $id);
					if($account === null) {
						throw(new RuntimeException("Account does not exist", 404));
					}

					// put the new Account content into the account and update
					$account->setAccountContent($requestObject->accountImageId, $requestObject->accountActive, $requestObject->accountAdmin, $requestObject->accountName, $requestObject->accountPpEmail, $requestObject->accountUserName);
					$account->update($pdo);

					// update reply
					$reply->message = "Account updated OK";

				} else if($method === "POST") {

					// make sure accountIf is available
					if(empty($requestObject->accountImageId) === true) {
						throw(new \InvalidArgumentException ("No Account Id", 405));
					}

					// create new account and insert into database
					$account = new CartridgeCoders\Account(null, $requestObject->accountImageId, $requestObject->accountActive, $requestObject->accountAdmin, $requestObject->accountName, $requestObject->accountPpEmail, $requestObject->accountUserName);
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





		?>


<!--	----------------------------------------- Leave PHP/ Enter HTML -------------------------------------------->


	<div class="row">
		<div class="col-md-6">
			<div class="well">
				<p>Name:</p>
				<p>Email:</p>
				<p>UserName:</p>
				<p>Active:</p>
				<p>Image:</p>
			</div>
		</div>

		<div class="col-md-6">
			<div class="well">
				<p>DB lookup pending</p>
				<p>DB lookup pending</p>
				<p>DB lookup pending</p>
				<p>DB lookup pending</p>
				<p>DB lookup pending</p>
			</div>
		</div>

	</div>





</div>
	</body>
</html>
