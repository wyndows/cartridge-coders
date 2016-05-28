
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
require_once(dirname(__DIR__) . "/vendor/autoload.php");

$code = filter_input(INPUT_GET, "code", FILTER_SANITIZE_STRING);
echo $code;

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

// curl - set options
curl_setopt($ch, CURLOPT_URL, "https://www.sandbox.paypal.com/webapps/auth/protocol/openidconnect/v1/authorize?client_id=AWoiHG8w-yaeYyODSBIzJ-awWkLVPo7G9zWJMomAFeMTVw5wyRG_b2pyYxl7a7wB7ByjVLJ0aQ6FdVDj&response_type=code&scope=openid+email+https%3A%2F%2Furi.paypal.com%2Fservices%2Fpaypalattributes&redirect_uri=https://bootcamp-coders.cnm.edu/~ddeleeuw/cartridge-coders/public_html/index.php");

curl_setopt_array(
	$ch,
	array(
		curl -v https://api.sandbox.paypal.com/v1/identity/openidconnect/tokenservice \
-u "<AWoiHG8w-yaeYyODSBIzJ-awWkLVPo7G9zWJMomAFeMTVw5wyRG_b2pyYxl7a7wB7ByjVLJ0aQ6FdVDj>:<Secret>" \
-d "grant_type=authorization_code
    &code=$code
    &redirect_uri=http://example.com/myapp/return.php"
	)




)




// curl - get response

$response = curl_exec($ch);

curl_close($ch);

echo $response



			?>


		
		<h2>Your Data</h2>
		<p><b>Name:</b> echo </p>
		<p><b>Email:</b> </b> echo </p>
		<p><b>Code:</b> </b> echo </p>
		<p><b>Token:</b> </b> echo </p>



		<hr/>


	</body>



	<?php

	$ch = curl_init();
	//Header
	curl_setopt($ch, CURLOPT_URL, "https://www.paypal.com/pl/cgi-bin/webscr?cmd=_login-submit&dispatch=5885d80a13c0db1f8e263663d3faee8de62a88b92df045c56447d40d60b23a7c");
	//curl_setopt($ch, CURLOPT_PROXY, $proxy);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return server response
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.6 (KHTML, like Gecko) Chrome/16.0.897.0 Safari/535.6');
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: 127.0.0.1", "HTTP_X_FORWARDED_FOR: 127.0.0.1"));


	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookieJar.txt'); // save cookie file
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_REFERER, 'https://www.paypal.com');
	curl_setopt ($ch, CURLOPT_COOKIESESSION, TRUE);
	curl_setopt($ch, CURLOPT_POST, 1); // use post data

	$post = array(
		"login_cmd" => null,
		"login_params" => null,
		"login_email" => "test",
		"login_password" => "test",
		"submit.x" => "login",
		//"auth" => "AOeCYVv0IxkugC2Pyz2AhTaW2P7hWuy5w9FoeuyB48gjjJZN3mTtuL79Tzs9dY.CF",
		"form_charset" => "UTF-8",
		"browser_name" => "Chrome",
		"browser_version" => "537.36",
		//"browser_version_full" => "40.0.2214.115",
		//"operating_system" => "Windows",
	);

	$post = http_build_query($post);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

	$data = curl_exec($ch);
	if(curl_errno($ch))
	{
		echo 'error:' . curl_error($ch);
	}
	curl_close($ch);

	print_r($data);


	?>

	
</html>
