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
	 * test inserting a valid Image File Name and verify that the actual mySQL data matches
	 */
	public function testInsertValidImageFileName() {

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

	/**
	 * test inserting a image file name that already exist
	 * @expectedException \PDOException
	 */

	public function testInsertInvalidImageFileName() {

		// create an image file name with a non null image id and watch it fail
		$imageFileName = new ImageFileName(CartridgeCodersTest::INVALID_KEY, $this->VALID_IMAGEFILENAME1);
		$category->insert($this->getPDO());
	}

	/**
	 * test inserting a new file name, editing it and then updating it
	 */

	public function testupdateValidImageFileName() {

		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("imageFileName");

		// create a new image file name and insert into mySQL
		$imageFileName = new ImageFileNmae(null, $this->VALID_IMAGEFILENAME1);
		$imageFileName->insert($this->getPDO());

		// edit the image file name and upsate it in mySQL
		$imageFileName->setImageFileNameName($this->VALID_IMAGEFILENAME2);
		$imageFileName->update($this->getPDO());

		//grab the data from mySQL and enforce that the fields match our expectations
		$pdoImageFileName = ImageFileName::getImageFileNameByImageId($this->getPDO(), $imageFileName - getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("imageFileName"));
		$this->assertEquals($pdoImageFileName->getImageFileNameName(), $this->VALID_IMAGEFILENAME2);
	}

	/**
	 * test updating a image file name that already exist
	 * @expectatedException
	 */
	public function testUpdateInvalidImageFileName(){

		// create a image file name with a non null image file name id and watch it fail
		$imageFileName = new ImageFileName(null, $this->VALID_IMAGEFILENAME1);
		$imageFileName->update($this->getPDO());
	}

	/**
	 * test creatinga image file name and deleting it
	 */
	public function testDeleteValidImageFileName(){

		// count the number of rows and save it for later
		$numRows=$this->getConnection()->getRowCount("imageFileName");

		// create new image file anme and inseet it into mySQL
		$imageFileName = new ImageFileName(null, $this->VALID_IMAGEFILENAME1);
		$imageFileName->insert($this->getPDO());

		// delete the category from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("imageFileName"));
		$imageFileName->delete($this->getPDO());

		// grab the data from mySQL and enforce that the image file name does not exist
		$pdoImageFileName = ImageFileName::getImageFileNameByImageId($this->getPDO(), $imageFileName->getImageId());
		$this->assertNull($pdoImageFileName);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("imageFileName"));
	}

	/**
	 * test deleting an image file name that does not exist
	 * @expectedException \PDOException
	 */

	public function testDeleteInvalidImageFileName(){

		// create a image file name and try to delete it without actually inserting it

		$imageFileName = new ImageFileName(null, $this->VALID_IMAGEFILENAME1);
		$imageFileName->delete($this->getPDO());
	}

	/**
	 * test grabbing a image file name that does not exist
	 */

	public function testGetInvalidImageFileNameByImageId(){

		// grab a image id that exceeds the maximum allowable image id
		$imageFileName = ImageFileName::getImageFileNameByImageId($this->getPDO(), CartridgeCodersTest::INVALID_KEY);
		$this->assertNull($category);
	}

	




}



















































