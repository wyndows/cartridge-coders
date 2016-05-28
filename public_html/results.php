
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

//$prefix = "Edu\\Cnm\\CartridgeCoders";
//$baseDir = __DIR__;
//require_once("vendor/autoload.php");
//require_once(dirname(__DIR__) . "/vendor/autoload.php");

//$code = filter_input(INPUT_GET, "code", FILTER_SANITIZE_STRING);
//echo $code;
//
//
//$apicontext = new PPApiContext(array('mode' => 'sandbox'));
//$params = array(
//	'client_id' => 'AWoiHG8w-yaeYyODSBIzJ-awWkLVPo7G9zWJMomAFeMTVw5wyRG_b2pyYxl7a7wB7ByjVLJ0aQ6FdVDj',
//	'client_secret' => 'EDRJgYO1yO0_Y_ligCIUIomHjaGRiXyuWt5lYr7W4pupqxyyC_iK_1N36MYB3jdiKxCp6JAyzxg5a2FE',
//	'code' => 'code'
//);
//$token = PPOpenIdTokeninfo::createFromAuthorizationCode($params,$apicontext);
//
//echo $token;


// ---------------------------------------------- cURL ----------------------------------------------

// curl - initialize session
$ch = curl_init();
curl -v -X GET https://api.sandbox.paypal.com/v1/payments/payment?sort_order=asc&sort_by=update_time \
-H "Content-Type:application/json" \
-H "Authorization: Bearer <Access-Token>"
?>



		<h2>Your Data</h2>
		<p><b>Name:</b> echo </p>
		<p><b>Email:</b> </b> echo </p>
		<p><b>Code:</b> </b> echo </p>
		<p><b>Token:</b> </b> echo </p>



		<hr/>


	</body>
</html>
