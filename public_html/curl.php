<!DOCTYPE html>

<html>


<!------------------------------------------------------->
<!-- @author Donald Deleeuw <donald.deleeuw@gmail.com> -->
<!------------------------------------------------------->


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

		$accountPpEmail = $userAttributesEmail;

			var_dump($accountPpEmail);

		//--------------------------------------------- mySQL -------------------------------------------------------

		require_once dirname(__DIR__) . "/public_html/php/classes/autoload.php";
		require_once dirname(__DIR__) . "/public_html/php/lib/xsrf.php";
		require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

		use Edu\Cnm\CartridgeCoders;


		// verify the session, start if not active
		if(session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		// grab the mySQL connection
		$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cartridge.ini");

		// determine which HTTP method was used
		$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

		//prepare an empty reply
		$reply = new stdClass();
		$reply->status = 200;
		$reply->data = null;


		// ----------------------------------- mySQL lookup/new ----------------------------------


		// telling class this is a lookup
		$method = "GET";

		// set XSRF cookie
		setXsrfCookie();

		// Check if returning customer and pp email already exist in database

		$account = CartridgeCoders\Account::getAccountByAccountPpEmail($pdo, $accountPpEmail);
		if($account == null){
			// --------
			// code to create an account
			// -------
		} else {
			// ---------- customer data already exist
			exit;
		}




		// handle GET request - if id is present, that account is returned, otherwise all accounts are returned
		if($method === "GET") {


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






		//1 - look in DB for EM
		//2 - return if there - inster info w/ defaults if not
		//		public static function getAccountByAccountPpEmail(\PDO $pdo, string $accountPpEmail) {







		?>


		<!--	----------------------------------------- Leave PHP/ Enter HTML -------------------------------------------->


		<div class="container">
			<div class="col-md-12">
				<div class="well">
					<p><strong>Welcome!! You are now a member of ROMuLess</strong></p>
				</div>
			</div>
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
