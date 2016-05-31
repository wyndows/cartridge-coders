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


		<h1>Login with PayPal - v3</h1>
		<p>Great! Now you are a member of our site.</p>
		<hr/>

		<?php

		// ---------------------------------------- encrypted config files -------------------------------------
		require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
		$config = readConfig("/etc/apache2/capstone-mysql/cartridge.ini");
		$paypal = json_decode($config["privkeys"])->paypal;

		// --------------------------------------------- get auth code -----------------------------------------


		require_once(dirname(__DIR__) . "/vendor/autoload.php");
		$authCode = filter_input(INPUT_GET, "code", FILTER_SANITIZE_STRING);

		// ----- TEMP VERIFY DATA - TO BE REMOVED
		echo nl2br("authCode: \n");
		print_r($authCode);
		echo nl2br("\n");
		echo nl2br("\n");


		//------------------------------------------------ cURL ------------------------------------------------
		// ----- @see https://developer.paypal.com/docs/api/#identity
		// ----- @see http://incarnate.github.io/curl-to-php/


		// ----- cURL - initialize session - get access token from authorization code
		$ch = curl_init();

		// ----- cURL - set options
		curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/identity/openidconnect/tokenservice");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=". $paypal->clientId . "&client_secret=". $paypal->clientSecret . "&grant_type=authorization_code&code=".$authCode);
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
		echo nl2br("accessToken JSON: \n");
		print_r($accessToken);
		echo nl2br("\n");
		echo nl2br("\n");

		// ------ break apart return JSON data in $accessToken

		$json = json_decode($accessToken);
		$accessTokenExtractToken = ($json->access_token);

		// ----- TEMP VERIFY DATA - TO BE REMOVED
		echo nl2br("accessToken JSON extraction: \n");
		echo $accessTokenExtractToken;
		echo nl2br("\n");
		echo nl2br("\n");


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

		//var_dump($headers);

		// ----- cURL - verify data (REMOVE LATER)
		echo nl2br("userAttributes JSON: \n");
		print_r($userAttributes);
		echo nl2br("\n");
		echo nl2br("\n");


		// ------ break apart return JSON data in $userAttributes

		$json = json_decode($userAttributes);
		//		$userAttributesUserId = ($json->user_id);
		$userAttributesName = ($json->name);
		$userAttributesEmail = ($json->email);


		// ----- TEMP VERIFY DATA - TO BE REMOVED
		echo nl2br("accessToken JSON extraction: \n");
		//		echo "UserId: ".$userAttributesUserId;
		//		echo nl2br("\n");
		echo "Full Name: " . $userAttributesName;
		echo nl2br("\n");
		echo "Email: " . $userAttributesEmail;
		echo nl2br("\n");
		echo nl2br("\n");


		//
		//		var_dump($userAttributes);


		?>






	</body>
</html>
