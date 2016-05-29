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
		curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=AWoiHG8w-yaeYyODSBIzJ-awWkLVPo7G9zWJMomAFeMTVw5wyRG_b2pyYxl7a7wB7ByjVLJ0aQ6FdVDj&client_secret=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx&grant_type=authorization_code&code=".$authCode);
		curl_setopt($ch, CURLOPT_POST, 1);

		// ----- cURL - get results
		$accessToken = curl_exec($ch);

		// ----- cURL - error checking
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}

		// ----- cURL - close session
		curl_close ($ch);

		// ----- TEMP VERIFY DATA - TO BE REMOVED
		echo nl2br ("accessToken JSON: \n");
				print_r($accessToken);
		echo nl2br("\n");
		echo nl2br("\n");

// ------ break apart return JSON data in $accessToken


		 //------ http://stackoverflow.com/questions/4343596/parsing-json-file-with-php
				$jsonIterator = new RecursiveIteratorIterator(
					new RecursiveArrayIterator(json_decode($accessToken, TRUE)),
					RecursiveIteratorIterator::SELF_FIRST);


				echo nl2br ("accessToken JSON broken down: \n");
				foreach ($jsonIterator as $key => $val) {
					if(is_array($val)) {
						echo nl2br ("$key:\n");
					} else {
						echo nl2br("$key => $val\n");
					}
				}
		echo nl2br("\n");
		echo nl2br("\n");

//		var_dump($jsonIterator);
//		var_dump($key);
//		var_dump($val);


// http://stackoverflow.com/questions/29308898/how-do-i-extract-data-from-json-with-php

	//	$accessTokenExtract = json_decode($accessToken, true);


		$accessTokenExtractToken = $val;


			// ----- cURL - get user attributes
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/identity/openidconnect/userinfo");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");



		$headers = array();
		$headers[] = "Authorization:Bearer ".$accessTokenExtractToken;
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


		$userAttributes = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);


		// ----- cURL - verify data (REMOVE LATER)
		echo nl2br ("userAttributes: \n");
		print_r($userAttributes);
		echo nl2br("\n");
		echo nl2br("\n");











//		var_dump($accessTokenExtract);
//		var_dump($key);
		var_dump($accessTokenExtractToken);
		var_dump($userAttributes);

?>



	</body>
</html>
