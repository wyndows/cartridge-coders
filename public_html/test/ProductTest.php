<?php

/**
 * Formulating plan for unit testing of Product class
 *
 * Class will consist of:
 * 	productId
 * 	productAccountId
 * 	productImageId
 * 	productAdminFee
 * 	productDescription
 * 	productPrice
 * 	productShipping
 * 	productSold
 * 	productTitle
 *
 * Primary key will be:
 * 	productId
 *
 * Foreign Keys:
 * 	productAccountId
 * 	productImageId
 *
 * Testing will be on:
 * 	insertProduct
 * 	updateProduct
 * 	deleteProduct
 * 	getProductByProductId
 * 	getProductByProductAccountId
 * 	getProductByProductImageId
 * 	getProductByProductDescription
 * 	getProductByProductPrice
 * 	getProductByProductSold
 * 	getProductByProductTitle
 * 	getAllProducts
 *
 * Testing will consist of the following:
 * 	test inserting a valid Product key and verify that the actual mySQL data matches
 * 	test inserting a Product that already exists
 * 	test inserting a Product, editing it, and then updating it
 * 	test updating a Product that already exists
 * 	test creating a Product and then deleting it
 * 	test deleting a Product that does not exist
 * 	test grabbing a Product that does not exist
 * 	test grabbing a Product by productId
 * 	test grabbing a Product by productAccountId
 * 	test grabbing a Product by productImageId
 * 	test grabbing a Product by productDescription
 * 	test grabbing a Product by productPrice
 * 	test grabbing a Product by productSold
 * 	test grabbing a Product by productTitle
 * 	test grabbing a Product by productId that does not exist
 * 	test grabbing a Product by productAccountId that does not exist
 * 	test grabbing a Product by productImageId that does not exist
 * 	test grabbing a Product by productDescription that does not exist
 * 	test grabbing a Product by productPrice that does not exist
 * 	test grabbing a Product by productSold that does not exist
 * 	test grabbing a Product by productTitle that does not exist
 * 	test grabbing all Products in the table that does not exist
 *
 * @author Marlan Ball <wyndows@earthlink.net> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 */
namespace Edu\Cnm\CartridgeCoders\Test;

use Edu\Cnm\CartridgeCoders\Product;

// grab the project test parameters
require_once("CartridgeCodersTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * Unit testing for the Product class for Cartridge Coders
 *
 * @see Product
 **/
class ProductTest extends CartridgeCodersTest {
	/**
	 * content of the Product
	 * @var string $VALID_PRODUCTADMINFEE
	 **/
	protected $VALID_PRODUCTADMINFEE = 0.1;
	/**
	 * content of the Product
	 * @var string $VALID_PRODUCTADMINFEE2
	 **/
	protected $VALID_PRODUCTADMINFEE2 = 0.2;
	/**
	 * content of the Product
	 * @var string $VALID_PRODUCTDESCRIPTION
	 **/
	protected $VALID_PRODUCTDESCRIPTION = "Legend of Zelda Cartridge for Nintendo";
	/**
	 * content of the Product
	 * @var string $VALID_PRODUCTDESCRIPTION2
	 **/
	protected $VALID_PRODUCTDESCRIPTION2 = "Legend of Zelda Cartridge for Sega";
	/**
	 * content of the Product
	 * @var string $VALID_PRODUCTPRICE
	 **/
	protected $VALID_PRODUCTPRICE = 29.99;
	/**
	 * content of the Product
	 * @var string $VALID_PRODUCTPRICE2
	 **/
	protected $VALID_PRODUCTPRICE2 = 39.99;
	/**
	 * content of the Product
	 * @var string $VALID_PRODUCTSHIPPING
	 **/
	protected $VALID_PRODUCTSHIPPING = 5.99;
	/**
	 * content of the Product
	 * @var string $VALID_PRODUCTSHIPPING2
	 **/
	protected $VALID_PRODUCTSHIPPING2 = 7.99;
	/**
 * content of the Product
 * @var string $VALID_PRODUCTSOLD
 **/
	protected $VALID_PRODUCTSOLD = 0;
	/**
	 * content of the Product
	 * @var string $VALID_PRODUCTSOLD2
	 **/
	protected $VALID_PRODUCTSOLD2 = 1;
	/**
	 * content of the Product
	 * @var string $VALID_PRODUCTTITLE
	 **/
	protected $VALID_PRODUCTTITLE ="Legend of Zelda";
	/**
	 * content of the Product
	 * @var string $VALID_PRODUCTTITLE2
	 **/
	protected $VALID_PRODUCTTITLE2 ="Mario Brothers";

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert an Account to own the test Product
		$this->account = new Account(null, $this->image->getImageId, 1, 0, "john", "john@john.com", "johndoe");
		$this->account->insert($this->getPDO());

		// create and insert an Image to own the test Product
		$this->image = new Image(null, "filename", "type/jpg");
		$this->image->insert($this->getPDO());
	}

	/**
 * test inserting a valid Product Id and verify that the actual mySQL data matches
 **/
	public function testInsertValidProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new product and insert into mySQL
		$product = new PRODUCT(null, $this->getCategoryId, $this->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProductAccountId(), $this->account->getAccountId);
		$this->assertEquals($pdoProduct->getProductImageId(), $this->image->getImageId);
		$this->assertEquals($pdoProduct->getProductAdminFee(), $this->VALID_PRODUCTADMINFEE);
		$this->assertEquals($pdoProduct->getProductDescription(), $this->VALID_PRODUCTDESCRIPTION);
		$this->assertEquals($pdoProduct->getProductPrice(), $this->VALID_PRODUCTPRICE);
		$this->assertEquals($pdoProduct->getProductShipping(), $this->VALID_PRODUCTSHIPPING);
		$this->assertEquals($pdoProduct->getProductSold(), $this->VALID_PRODUCTSOLD);
		$this->assertEquals($pdoProduct->getProductTitle(), $this->VALID_PRODUCTTITLE);
	}

	/**
	 * test inserting a valid Account Id and verify that the actual mySQL data matches
	 **/
	public function testInsertValidAccountId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new product and insert into mySQL
		$product = new PRODUCT(null, $this->account->getAccountId, $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByAccountId($this->getPDO(), $product->account->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProductAccountId(), $this->account->getAccountId);
		$this->assertEquals($pdoProduct->getProductImageId(), $this->image->getImageId);
		$this->assertEquals($pdoProduct->getProductAdminFee(), $this->VALID_PRODUCTADMINFEE);
		$this->assertEquals($pdoProduct->getProductDescription(), $this->VALID_PRODUCTDESCRIPTION);
		$this->assertEquals($pdoProduct->getProductPrice(), $this->VALID_PRODUCTPRICE);
		$this->assertEquals($pdoProduct->getProductShipping(), $this->VALID_PRODUCTSHIPPING);
		$this->assertEquals($pdoProduct->getProductSold(), $this->VALID_PRODUCTSOLD);
		$this->assertEquals($pdoProduct->getProductTitle(), $this->VALID_PRODUCTTITLE);
	}

	/**
	 * test inserting a valid Product Id and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new product and insert into mySQL
		$product = new PRODUCT(null, $this->account->getAccountId, $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByAccountId($this->getPDO(), $product->account->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProductAccountId(), $this->account->getAccountId);
		$this->assertEquals($pdoProduct->getProductImageId(), $this->image->getImageId);
		$this->assertEquals($pdoProduct->getProductAdminFee(), $this->VALID_PRODUCTADMINFEE);
		$this->assertEquals($pdoProduct->getProductDescription(), $this->VALID_PRODUCTDESCRIPTION);
		$this->assertEquals($pdoProduct->getProductPrice(), $this->VALID_PRODUCTPRICE);
		$this->assertEquals($pdoProduct->getProductShipping(), $this->VALID_PRODUCTSHIPPING);
		$this->assertEquals($pdoProduct->getProductSold(), $this->VALID_PRODUCTSOLD);
		$this->assertEquals($pdoProduct->getProductTitle(), $this->VALID_PRODUCTTITLE);
	}

	/**
	 * test inserting a Product that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProductId() {
		// create a Product with a non null product id and watch it fail
		$product = new Product(CartridgeCodersTest::INVALID_KEY, $this->account->getAccountId(), $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());
	}

	/**
 * test inserting an invalid account id
 *
 * @expectedException PDOException
 **/
	public function testInsertInvalidAccountId() {
		// create a Product with an invalid account id and watch it fail
		$product = new Product(null, CartridgeCodersTest::INVALID_KEY, $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());
	}

	/**
	 * test inserting an invalid product id
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProductId() {
		// create a Product with an invalid product id and watch it fail
		$product = new Product(null, $this->account->getAccountId, CartridgeCodersTest::INVALID_KEY, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());
	}

	/**
	 * test inserting a Product, editing Product Admin Fee, and then updating it
	 **/
	public function testUpdateValidProductAdminFee() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->account->getAccountId, $this->product->getProductId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// edit the Product Admin Fee and update it in mySQL
		$product->setProductAdminFee($this->VALID_PRODUCTADMINFEE2);
		$product->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProductAccountId(), $this->account->getAccountId);
		$this->assertEquals($pdoProduct->getProductImageId(), $this->image->getImageId);
		$this->assertEquals($pdoProduct->getProductAdminFee(), $this->VALID_PRODUCTADMINFEE2);
		$this->assertEquals($pdoProduct->getProductDescription(), $this->VALID_PRODUCTDESCRIPTION);
		$this->assertEquals($pdoProduct->getProductPrice(), $this->VALID_PRODUCTPRICE);
		$this->assertEquals($pdoProduct->getProductShipping(), $this->VALID_PRODUCTSHIPPING);
		$this->assertEquals($pdoProduct->getProductSold(), $this->VALID_PRODUCTSOLD);
		$this->assertEquals($pdoProduct->getProductTitle(), $this->VALID_PRODUCTTITLE);
	}

	/**
	 * test inserting a Product, editing Product Description, and then updating it
	 **/
	public function testUpdateValidProductDescription() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->account->getAccountId, $this->product->getProductId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// edit the Product Admin Fee and update it in mySQL
		$product->setProductDescription($this->VALID_PRODUCTDESCRIPTION2);
		$product->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProductAccountId(), $this->account->getAccountId);
		$this->assertEquals($pdoProduct->getProductImageId(), $this->image->getImageId);
		$this->assertEquals($pdoProduct->getProductAdminFee(), $this->VALID_PRODUCTADMINFEE);
		$this->assertEquals($pdoProduct->getProductDescription(), $this->VALID_PRODUCTDESCRIPTION2);
		$this->assertEquals($pdoProduct->getProductPrice(), $this->VALID_PRODUCTPRICE);
		$this->assertEquals($pdoProduct->getProductShipping(), $this->VALID_PRODUCTSHIPPING);
		$this->assertEquals($pdoProduct->getProductSold(), $this->VALID_PRODUCTSOLD);
		$this->assertEquals($pdoProduct->getProductTitle(), $this->VALID_PRODUCTTITLE);
	}


?>