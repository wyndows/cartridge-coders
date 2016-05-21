<?php

require_once "../classes/autoload.php";
require_once "../lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\CartridgeCoders\DataDesign;

/**
 * api for Account Class
 *
 * @author Donald Deleeuw <donald.deleeuw@gmail.com> based on code by Derek Mauldin <derek.e.mauldin@gmail.com>
 *
 */

// verify the session, start if not active
if(session_start() !== PHP_SESSION_ACTIVE){
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try{
	// grab the mySQL connection
	$pdo=connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cartridge.ini");
	
	// determine which HTTP method was used
	$method =
}



























//GET - all Accounts
//GET - Account by ID
//POST - new Account (create id)
//PUT - update Account by Id


?>


