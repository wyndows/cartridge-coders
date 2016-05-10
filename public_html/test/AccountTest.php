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
 *
 *
 *
 *
 *
 * 
 * insertImageFileName (user creates imageFileName when they place item for sale)
 * updateImageFileName (user may change imageFileName after listing)
 * deleteImageFileName (user may delete the listing)
 * getImageFileNameByImageId (imageId is a foreign key on other classes)
 *
 * Testing will consist of;
 * test inserting a valid ImageFileName and verify that the actual mySQL data matches
 * test inserting a ImageFileName that already exists
 * test inserting a ImageFileName, editing it, and then updating it
 * test updating a ImageFileName that already exists
 * test creating a ImageFileName and then deleting it
 * test deleting a ImageFileName that does not exist
 * test grabbing a ImageFileName that does not exist
 * test grabbing a ImageFileName by ImageFileName name
 * test grabbing a ImageFileName by ImageFileName name that does not exist
 * test grabbing all ImageFileNames in the table
 *
 * @author Donald DeLeeuw <donald.deleeuw@gmail.com> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 */

namespace Edu\Cnm\CartridgeCoders\Test;

use Edu\Cnm\CartridgeCoders\Image;

// grab  the project test parameters
require_once("CartridgeCodersTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

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

