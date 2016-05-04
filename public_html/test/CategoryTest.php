<?php
/**
 * Trying to create testing first for TDD style
 * Class will consist of categoryId and categoryName
 * Primary key will be categoryId
 * No foreign keys
 * Testing will be on insertCategory (user creates categories when they place item for sale), updateCategory (user may change categories after listing), deleteCategory (user may delete the listing), getCategoryByCategoryId (categoryId is a foreign key on other classes) and getCategoryByCategoryName (user may search for a cartridge by category name)
 */

// Parts of this code is modified from the original as authored by Dylan McDonald and is taken from bootcamp-coders.cnm.edu

namespace Edu\Cnm\CartridgeCoders\Test;

use Edu\Cnm\CartridgeCoders\Test\CartridgeCodersTest;
use Edu\Cnm\CartridgeCoders\Php\Classes\Category;

// grab the project test parameters
require_once("CartridgeCodersTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 *
 * @see Category
 * @author Marlan Ball <wyndows@earthlink.net>
 **/
class CategoryTest extends CartridgeCodersTest {
	/**
	 * content of the Category
	 * @var string $VALID_CATEGORYNAME
	 **/
	protected $VALID_CATEGORYNAME = "Sega";
	/**
	 * content of the updated Category
	 * @var string $VALID_CATEGORYNAME2
	 **/
	protected $VALID_CATEGORYNAME2 = "Nintendo";

	/**
	 * test inserting a valid Category and verify that the actual mySQL data matches
	 **/
	public function testInsertValidCategory() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("category");

		// create a new category and insert into mySQL
		$category = new Category(null, $this->VALID_CATEGORYNAME);
		$category->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoCategory = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORYNAME);

	}

	/**
	 * test inserting a Category that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidCategory() {
		// create a Category with a non null category id and watch it fail
		$category = new Category(CartridgeCodersTest::Test::INVALID_KEY, $this->category->getCategoryId());
		$category->insert($this->getPDO());
	}


}
?>