<?php

/**
 * Formulating plan for unit testing of Image class
 *
 * Class will consist of imageId, imageFileName & imageType
 * Primary key = imageId
 * Foreign keys = n/a
 *
 * Testing will be on;
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
	

	/**
	 * test inserting a valid Image File Name and verify that the actual mySQL data matches
	 */
	public function testInsertValidImageFileName() {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		// create a new image file name and insert into mySQL
		$image = new Image(null, $this->VALID_IMAGEFILENAME1, $this->VALID_IMAGETYPE);
		$image->insert($this->getPDO());

		// grab data from mySQL and enforce the fields match expectations
		$pdoImageFileName = Image::getImageFileNameByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImageFileName->getImageFileName(), $this->VALID_IMAGEFILENAME1);
	}

	/**
	 * test inserting a image file name that already exist
	 * @expectedException \PDOException
	 */

	public function testInsertInvalidImageFileName() {

		// create an image file name with a non null image id and watch it fail
		$image = new Image(CartridgeCodersTest::INVALID_KEY, $this->VALID_IMAGEFILENAME1, $this->VALID_IMAGETYPE);
		$image->insert($this->getPDO());
	}

	/**
	 * test inserting a new file name, editing it and then updating it
	 */

	public function testupdateValidImageFileName() {

		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		// create a new image file name and insert into mySQL
		$image = new Image(null, $this->VALID_IMAGEFILENAME1, $this->VALID_IMAGETYPE);
		$image->insert($this->getPDO());

		// edit the image file name and upsate it in mySQL
		$image->setImageFileName($this->VALID_IMAGEFILENAME2);
		$image->update($this->getPDO());

		//grab the data from mySQL and enforce that the fields match our expectations
		$pdoImageFileName = Image::getImageFileNameByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImageFileName->getImageFileName(), $this->VALID_IMAGEFILENAME2);
	}

	/**
	 * test updating a image file name that already exist
	 * @expectedException \PDOException
	 */
	public function testUpdateInvalidImageFileName() {

		// create a image file name with a non null image file name id and watch it fail
		$image = new Image(null, $this->VALID_IMAGEFILENAME1, $this->VALID_IMAGETYPE);
		$image->update($this->getPDO());
	}
	

	/**
	 * test grabbing a image file name that does not exist
	 */

	public function testGetInvalidImageFileNameByImageId() {

		// grab a image id that exceeds the maximum allowable image id
		$image = Image::getImageFileNameByImageId($this->getPDO(), CartridgeCodersTest::INVALID_KEY);
		$this->assertNull($image);
	}

	/**
	 * test grabbing a image file name by image file name name
	 */

	public function testGetValidImageFileNameByImageFileName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		// create a new image file name and insert it into mySQL
		$image = new Image(null, $this->VALID_IMAGEFILENAME1, $this->VALID_IMAGETYPE);
		$image->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Image::getImageFileNameByImageFileName($this->getPDO(), $image->getImageFileName(), $image->getImageType());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Image", $results);

		// grab the result from the array and validate it
		$pdoImage = $results[0];
//		$this->assertEquals($pdoImage->getImageId(), $this->getPDO());
		$this->assertEquals($pdoImage->getImageFileName(), $this->VALID_IMAGEFILENAME1);
		$this->assertEquals($pdoImage->getImageType(), $this->VALID_IMAGETYPE);
	}

	/**
	 * test grabbing a image file name by name that does not exist
	 */
	public function testGetInvalidImageFileNameByImageFileName() {
		// grab image file name that does not exist
		$image = Image::getImageFileNameByImageFileName($this->getPDO(), "this image file name never existed");
		$this->assertCount(0, $image);
	}

	/**
	 * test grabbing all image file names
	 **/
	public function testGetAllValidImageFileNames() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		// create a new image file name and insert to into mySQL
		$image = new Image(null, $this->VALID_IMAGEFILENAME1, $this->VALID_IMAGETYPE);
		$image->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Image::getAllImageFileNames($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Image", $results);

		// grab the result from the array and validate it
		$pdoImage = $results[0];
//		$this->assertEquals($pdoImage->getImageid(), $this->getImageid());
		$this->assertEquals($pdoImage->getImageFileName(), $this->VALID_IMAGEFILENAME1);
		$this->assertEquals($pdoImage->getImageType(), $this->VALID_IMAGETYPE);
	}
}

?>



















































