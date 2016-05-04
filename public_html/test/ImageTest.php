<?php

/**
 * Formulating plan for unit testing of Image class
 *
 * Class will consist of imageId, imageFileName & imageType
 * Primary key = imageId
 * Foreign keys = n/a
 *
 * Testing will be on;
 * imageId - xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 * imageFileName - xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 * imageType - xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 *
 * Testing will consist of;
 * xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 * xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 * xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 * xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 * xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 * xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 * xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 *
 * @author Donald DeLeeuw <donald.deleeuw@gmail.com> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 */

namespace Edu\Cnm\CartridgeCoders\Test;

use Edu\Cnm\CartridgeCoders\Image;

// grab the project test parameters
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
	


}



















































