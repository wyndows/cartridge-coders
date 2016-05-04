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

	/**
	 * test inserting a valid Image File Name and verify that the actuak mySQL data matches
	 */
	public function testInsertValidImageFileName(){

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("imageFileName");

		// create a new image file name and insert into mySQL
		$imageFileName = new ImageFileName(null, $this->VALID_IMAGEFILENAME1);
		$imageFileName->insert($this->getPDO());

		// grab data from mySQL and enforce the fields match expectations
		$pdoImageFileName = ImageFileName::getImageFileNameByImageId($this->getPDO(), $imageFileName->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ImageFileName"));
		$this->assertEquals($pdoImageFileName->getImageFileNameName(), $this->VALID_IMAGEFILENAME1);
	}


}



















































