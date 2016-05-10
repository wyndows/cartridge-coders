<?php

/**
 * Formulating plan for unit testing of account class
 *
 * Class will consist of;
 * int|null AccountId - id of account or null if new account - primary key
 * int|null AccountImageId - id of image - this is a foreign key
 * int|null AccountActive - flag for account active
 * int|null AccountAdmin - flag for account admin
 * string AccountName - user's name
 * string AccountPpEmail - user's paypal email address
 * string AccountUserName - user's chosen user name
 *
 * Testing will be on;
 *
 *
 * 
 * insert (x1)
 * update
 * delete
 * get by attribute
 * get all (x1)
 *
 * 
 * 
 * 
 * Testing will consist of;
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 *
 * @author Donald DeLeeuw <donald.deleeuw@gmail.com> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 */

namespace Edu\Cnm\CartridgeCoders\Test;

use Edu\Cnm\CartridgeCoders\Account;

// grab  the project test parameters
require_once("CartridgeCodersTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "../php/classes/autoload.php");

/**
 * Unit testing for the account class for Cartridge Coders
 * @see Account
 */
class AccountTest extends CartridgeCodersTest {

	/**
	 *content of the accountId
	 * @var int $accountId
	 */
	private $accountId;


/**
 *content of the accountImageId
 * @var int $AccountImageId
 */
private $imageId;


/**
 *content of the accountActive
 * @var tinyint $accountActive
 */
private $accountActive;

/**
 *content of the accountAdmin
 * @var tinyint $accountAdmin
 */
private $accountAdmin;


/**
 *content of the accountName
 * @var string $accountName
 */
private $accountName;

/**
 *content of the accountPpEmail
 * @var string $accountPpEmail
 */
private $accountPpEmail;


/**
 *content of the accountUserName
 * @var string $accountUserName
 */
private $accountUserName;



































?>

