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
 * Unit testing for the Image class for Cartridge Coders
 * @see Image
 */
class ImageTest extends CartridgeCodersTest {

	/**
	 *content of the imageFileName
	 * @var string $VALID_IMAGEFILENAME1
	 */
	protected $VALID_IMAGEFILENAME1 = "pictureofsegacartridge";

	/**
	 * content of the updated ImageFileName
	 * @var string $VALID_IMAGEFILENAME2
	 */
	protected $VALID_IMAGEFILENAME2 = "pictureofnintendocartridge";

	/**
	 * content of the updated ImageType
	 * @var string $VALID_IMAGETYPE
	 */
	protected $VALID_IMAGETYPE = "image/jpg";


































?>

