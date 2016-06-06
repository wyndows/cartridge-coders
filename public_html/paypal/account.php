<?php require_once("includes.php"); ?>
<?php require_once("top.php"); ?>
<?php require_once("category.php"); ?>
<head>

</head>
<!------------------------------------------------------->
<!-- @author Donald Deleeuw <donald.deleeuw@gmail.com> -->
<!------------------------------------------------------->
<?php
// ---------------------------------------- encrypted config files -------------------------------------
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
$config = readConfig("/etc/apache2/capstone-mysql/cartridge.ini");
$paypal = json_decode($config["privkeys"])->paypal;


// --------------------------------------------- get auth code -----------------------------------------
require_once(dirname(__DIR__) . "/vendor/autoload.php");
$authCode = filter_input(INPUT_GET, "code", FILTER_SANITIZE_STRING);
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

// ------ break apart return JSON data in $accessToken
$json = json_decode($accessToken);
$accessTokenExtractToken = ($json->access_token);

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

// ------ break apart return JSON data in $userAttributes
$json = json_decode($userAttributes);

//		$userAttributesUserId = ($json->user_id);
$userAttributesName = ($json->name);
$userAttributesEmail = ($json->email);
$userAttributesFirstName = ($json->given_name);
$accountPpEmail = $userAttributesEmail;
$accountName = $userAttributesName;
$accountTempUserName = "TempUserName".rand(1, 9999999);

//--------------------------------------------- mySQL -------------------------------------------------------

require_once dirname(__DIR__) . "/php/classes/autoload.php";
require_once dirname(__DIR__) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");


use Edu\Cnm\CartridgeCoders;
use Edu\Cnm\CartridgeCoders\Account;


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

// Check if returning customer or new customer
$accounts = CartridgeCoders\Account::getAccountByAccountPpEmail($pdo, $accountPpEmail);

// -------- customer data does NOT exist, added new acount
if (is_object($accounts) && (count(get_object_vars($accounts)) < 1)){
	$account = new Account(null, 1, 1, 0, $accountName, $accountPpEmail, $accountTempUserName);
	$account->insert($pdo);

	//update the null accountId with what mySQL just gave us
	$accountId = intval($pdo->lastInsertId());

	// update accountUserName with FirstName + accountId
	$accountUserName = $userAttributesFirstName . $accountId;
	var_dump($accountUserName); // ------------------------------------------------ DELETE ME

	// replace temp username with personalized username
	$account->setAccountUserName($accountUserName);
	$account->update($pdo);


} else {
	// ---------- customer data already exist
	// -- GET customer data
	$account = Account::getAccountByAccountPpEmail($pdo, $accountPpEmail)[0];
}


?>


<!--	----------------------------------------- Leave PHP/ Enter HTML -------------------------------------------->


<div class="container">
	<div class="col-md-12">
		<div class="well">
			<p><strong>Welcome to ROMuLess! You are now logged in.</strong></p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="well">
				<p>Name:</p>
				<p>Email:</p>
				<p>UserName:</p>
			</div>
		</div>
		<div class="col-md-6">
			<div class="well">
				<p><?php echo $account->getAccountName(); ?></p>
				<p><?php echo $account->getAccountPpEmail(); ?></p>
				<p><?php echo $account->getAccountUserName(); ?></p>
			</div>
		</div>
	</div>
</div>


<div class="container">
	<div class="col-md12">
		<div class="well">
			<!-- PayPal Checkout Button begin -------------------------------------------------------------  -->
			<form action='expresscheckout.php' METHOD='POST'>
				<input type='image' name='submit' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif'
						 border='0' align='top' alt='Check out with PayPal'/>
			</form>
			<!-- PayPal Checkout Button begin -------------------------------------------------------------  -->
		</div>
	</div>
</div>


</body>
</html>
