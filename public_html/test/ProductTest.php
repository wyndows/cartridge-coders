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
 * 	test inserting a valid Product Id and verify that the actual mySQL data matches
 * 	test inserting a valid Account Id and verify that the actual mySQL data matches
 * 	test inserting a valid Product Id and verify that the actual mySQL data matches
 * 	test inserting a Product that already exists
 * 	test inserting an invalid account id
 * 	test inserting an invalid product id
 * 	test inserting a Product, editing Product Admin Fee, and then updating it
 * 	test inserting a Product, editing Product Description, and then updating it
 * 	test inserting a Product, editing Product Price, and then updating it
 * 	test inserting a Product, editing Product Shipping, and then updating it
 * 	test inserting a Product, editing Product Sold, and then updating it
 * 	test inserting a Product, editing Product Title, and then updating it
 * 	test updating a Product that already exists
 * 	test creating a Product and then deleting it
 * 	test deleting a Product that does not exist
 * 	test grabbing a Product with Product Id that does not exist
 * 	test grabbing a Product with Account Id that does not exist
 * 	test grabbing a Product with Image Id that does not exist
 * 	test grabbing a Product by admin fee
 * 	test grabbing a Product by product description
 * 	test grabbing a Product by product price
 * 	test grabbing a Product by product shipping
 * 	test grabbing a Product by product sold
 * 	test grabbing a Product by product title
 * 	test grabbing a Product by admin fee that does not exist
 * 	test grabbing a Product by product description that does not exist
 * 	test grabbing a Product by product price that does not exist
 * 	test grabbing a Product by product shipping that does not exist
 * 	test grabbing a Product by product sold that does not exist
 * 	test grabbing a Product by product title that does not exist
 * 	test grabbing all Products
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
	protected $VALID_PRODUCTTITLE = "Legend of Zelda";
	/**
	 * content of the Product
	 * @var string $VALID_PRODUCTTITLE2
	 **/
	protected $VALID_PRODUCTTITLE2 = "Mario Brothers";

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
		$product = new Product(null, $this->getProductId, $this->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
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
		$product = new Product(null, $this->account->getAccountId, $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
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
		$product = new Product(null, $this->account->getAccountId, $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
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
	 * test inserting an invalid image id
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidImageId() {
		// create a Product with an invalid image id and watch it fail
		$product = new Product(null, $this->account->getAccountId, CartridgeCodersTest::INVALID_KEY, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());
	}

	/**
	 * test inserting a Product, editing Product Admin Fee, and then updating it
	 **/
	public function testUpdateValidProductAdminFee() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert into mySQL
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

		// create a new Product and insert into mySQL
		$product = new Product(null, $this->account->getAccountId, $this->product->getProductId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// edit the Product Description and update it in mySQL
		$product->setProductDescription($this->VALID_PRODUCTDESCRIPTION2);
		$product->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductDescription($this->getPDO(), $product->getProductDescription());
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

	/**
	 * test inserting a Product, editing Product Price, and then updating it
	 **/
	public function testUpdateValidProductPrice() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert into mySQL
		$product = new Product(null, $this->account->getAccountId, $this->product->getProductId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// edit the Product Price and update it in mySQL
		$product->setProductPrice($this->VALID_PRODUCTPRICE2);
		$product->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductPrice($this->getPDO(), $product->getProductPrice());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProductAccountId(), $this->account->getAccountId);
		$this->assertEquals($pdoProduct->getProductImageId(), $this->image->getImageId);
		$this->assertEquals($pdoProduct->getProductAdminFee(), $this->VALID_PRODUCTADMINFEE);
		$this->assertEquals($pdoProduct->getProductDescription(), $this->VALID_PRODUCTDESCRIPTION);
		$this->assertEquals($pdoProduct->getProductPrice(), $this->VALID_PRODUCTPRICE2);
		$this->assertEquals($pdoProduct->getProductShipping(), $this->VALID_PRODUCTSHIPPING);
		$this->assertEquals($pdoProduct->getProductSold(), $this->VALID_PRODUCTSOLD);
		$this->assertEquals($pdoProduct->getProductTitle(), $this->VALID_PRODUCTTITLE);
	}

	/**
	 * test inserting a Product, editing Product Shipping, and then updating it
	 **/
	public function testUpdateValidProductShipping() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert into mySQL
		$product = new Product(null, $this->account->getAccountId, $this->product->getProductId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// edit the Product Shipping and update it in mySQL
		$product->setProductShipping($this->VALID_PRODUCTSHIPPING2);
		$product->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductShipping($this->getPDO(), $product->getProductShipping());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProductAccountId(), $this->account->getAccountId);
		$this->assertEquals($pdoProduct->getProductImageId(), $this->image->getImageId);
		$this->assertEquals($pdoProduct->getProductAdminFee(), $this->VALID_PRODUCTADMINFEE);
		$this->assertEquals($pdoProduct->getProductDescription(), $this->VALID_PRODUCTDESCRIPTION);
		$this->assertEquals($pdoProduct->getProductPrice(), $this->VALID_PRODUCTPRICE);
		$this->assertEquals($pdoProduct->getProductShipping(), $this->VALID_PRODUCTSHIPPING2);
		$this->assertEquals($pdoProduct->getProductSold(), $this->VALID_PRODUCTSOLD);
		$this->assertEquals($pdoProduct->getProductTitle(), $this->VALID_PRODUCTTITLE);
	}

	/**
	 * test inserting a Product, editing Product Sold, and then updating it
	 **/
	public function testUpdateValidProductSold() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert into mySQL
		$product = new Product(null, $this->account->getAccountId, $this->product->getProductId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// edit the Product Sold and update it in mySQL
		$product->setProductSold($this->VALID_PRODUCTSOLD2);
		$product->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductSold($this->getPDO(), $product->getProductSold());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProductAccountId(), $this->account->getAccountId);
		$this->assertEquals($pdoProduct->getProductImageId(), $this->image->getImageId);
		$this->assertEquals($pdoProduct->getProductAdminFee(), $this->VALID_PRODUCTADMINFEE);
		$this->assertEquals($pdoProduct->getProductDescription(), $this->VALID_PRODUCTDESCRIPTION);
		$this->assertEquals($pdoProduct->getProductPrice(), $this->VALID_PRODUCTPRICE);
		$this->assertEquals($pdoProduct->getProductShipping(), $this->VALID_PRODUCTSHIPPING);
		$this->assertEquals($pdoProduct->getProductSold(), $this->VALID_PRODUCTSOLD2);
		$this->assertEquals($pdoProduct->getProductTitle(), $this->VALID_PRODUCTTITLE);
	}

	/**
	 * test inserting a Product, editing Product Title, and then updating it
	 **/
	public function testUpdateValidProductTitle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert into mySQL
		$product = new Product(null, $this->account->getAccountId, $this->product->getProductId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// edit the Product Title and update it in mySQL
		$product->setProductTitle($this->VALID_PRODUCTTITLE2);
		$product->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductSold($this->getPDO(), $product->getProductSold());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProductAccountId(), $this->account->getAccountId);
		$this->assertEquals($pdoProduct->getProductImageId(), $this->image->getImageId);
		$this->assertEquals($pdoProduct->getProductAdminFee(), $this->VALID_PRODUCTADMINFEE);
		$this->assertEquals($pdoProduct->getProductDescription(), $this->VALID_PRODUCTDESCRIPTION);
		$this->assertEquals($pdoProduct->getProductPrice(), $this->VALID_PRODUCTPRICE);
		$this->assertEquals($pdoProduct->getProductShipping(), $this->VALID_PRODUCTSHIPPING);
		$this->assertEquals($pdoProduct->getProductSold(), $this->VALID_PRODUCTSOLD);
		$this->assertEquals($pdoProduct->getProductTitle(), $this->VALID_PRODUCTTITLE2);
	}

	/**
	 * test updating a Product that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidProduct() {
		// create a Product with a non null product id and watch it fail
		$product = new Product(null, $this->account->getAccountId, $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->update($this->getPDO());
	}

	/**
	 * test creating a Product and then deleting it
	 **/
	public function testDeleteValidProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert into mySQL
		$product = new Product(null, $this->account->getAccountId, $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// delete the Product from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$product->delete($this->getPDO());

		// grab the data from mySQL and enforce the Product does not exist
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertNull($pdoProduct);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("product"));
	}

	/**
	 * test deleting a Product that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidProduct() {
		// create a Product and try to delete it without actually inserting it
		$product = new Product(null, $this->account->getAccountId, $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->delete($this->getPDO());
	}

	/**
	 * test grabbing a Product with Product Id that does not exist
	 **/
	public function testGetProductByInvalidProductId() {
		// grab a product id that exceeds the maximum allowable product id
		$product = Product::getProductByProductId($this->getPDO(), CartridgeCodersTest::INVALID_KEY);
		$this->assertNull($product);
	}

	/**
	 * test grabbing a Product with Account Id that does not exist
	 **/
	public function testGetProductByInvalidAccountId() {
		// grab an account id that exceeds the maximum allowable account id
		$product = Product::getProductByAccountId($this->getPDO(), CartridgeCodersTest::INVALID_KEY);
		$this->assertNull($product);
	}

	/**
	 * test grabbing a Product with Image Id that does not exist
	 **/
	public function testGetInvalidProductByImageId() {
		// grab an image id that exceeds the maximum allowable image id
		$product = Product::getProductByImageId($this->getPDO(), CartridgeCodersTest::INVALID_KEY);
		$this->assertNull($product);
	}

	/**
	 * test grabbing a Product by product admin fee
	 **/
	public function testGetProductByValidProductAdminFee() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert into mySQL
		$product = new Product(null, $this->account->getAccountId, $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Product::getProductByProductAdminFee($this->getPDO(), $product->getProductAdminFee());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Product", $results);

		// grab the result from the array and validate it
		$pdoProduct = $results[0];
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
	 * test grabbing a Product by product description
	 **/
	public function testGetProductByValidProductDescription() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert into mySQL
		$product = new Product(null, $this->account->getAccountId, $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Product::getProductByProductDescription($this->getPDO(), $product->getProductDescription());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Product", $results);

		// grab the result from the array and validate it
		$pdoProduct = $results[0];
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
	 * test grabbing a Product by product price
	 **/
	public function testGetProductByValidProductPrice() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert into mySQL
		$product = new Product(null, $this->account->getAccountId, $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Product::getProductByProductPrice($this->getPDO(), $product->getProductPrice());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Product", $results);

		// grab the result from the array and validate it
		$pdoProduct = $results[0];
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
	 * test grabbing a Product by product shipping
	 **/
	public function testGetProductByValidProductShipping() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert into mySQL
		$product = new Product(null, $this->account->getAccountId, $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Product::getProductByProductShipping($this->getPDO(), $product->getProductShipping());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Product", $results);

		// grab the result from the array and validate it
		$pdoProduct = $results[0];
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
	 * test grabbing a Product by product sold
	 **/
	public function testGetProductByValidProductSold() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert into mySQL
		$product = new Product(null, $this->account->getAccountId, $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Product::getProductByProductSold($this->getPDO(), $product->getProductSold());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Product", $results);

		// grab the result from the array and validate it
		$pdoProduct = $results[0];
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
	 * test grabbing a Product by product title
	 **/
	public function testGetProductByValidProductTitle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert into mySQL
		$product = new Product(null, $this->account->getAccountId, $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Product::getProductByProductTitle($this->getPDO(), $product->getProductTitle());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Product", $results);

		// grab the result from the array and validate it
		$pdoProduct = $results[0];
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
	 * test grabbing a Product by admin fee that does not exist
	 **/
	public function testGetProductByInvalidProductAdminFee() {
		// grab a product by searching for admin fee that does not exist
		$product = Product::getProductByProductAdminFee($this->getPDO(), 100);
		$this->assertCount(0, $product);
	}

	/**
	 * test grabbing a Product by product description that does not exist
	 **/
	public function testGetProductByInvalidProductDescription() {
		// grab a product by searching for description that does not exist
		$product = Product::getProductByProductDescription($this->getPDO(), "");
		$this->assertCount(0, $product);
	}

	/**
	 * test grabbing a Product by product price that does not exist
	 **/
	public function testGetProductByInvalidProductPrice() {
		// grab a product by searching for price that does not exist
		$product = Product::getProductByProductPrice($this->getPDO(), -1);
		$this->assertCount(0, $product);
	}

	/**
	 * test grabbing a Product by product shipping that does not exist
	 **/
	public function testGetProductByInvalidProductShipping() {
		// grab a product by searching for shipping that does not exist
		$product = Product::getProductByProductShipping($this->getPDO(), -1);
		$this->assertCount(0, $product);
	}

	/**
	 * test grabbing a Product by product sold that does not exist
	 **/
	public function testGetProductByInvalidProductSold() {
		// grab a product by searching for sold that does not exist
		$product = Product::getProductByProductSold($this->getPDO(), -1);
		$this->assertCount(0, $product);
	}

	/**
	 * test grabbing a Product by product title that does not exist
	 **/
	public function testGetProductByInvalidProductTitle() {
		// grab a product by searching for title that does not exist
		$product = Product::getProductByProductTitle($this->getPDO(), "");
		$this->assertCount(0, $product);
	}

	/**
	 * test grabbing all Products
	 **/
	public function testGetAllValidProducts() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert into mySQL
		$product = new Product(null, $this->account->getAccountId, $this->image->getImageId, $this->VALID_PRODUCTADMINFEE, $this->VALID_PRODUCTDESCRIPTION, $this->VALID_PRODUCTPRICE, $this->VALID_PRODUCTSHIPPING, $this->VALID_PRODUCTSOLD, $this->VALID_PRODUCTTITLE);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Product::getAllProducts($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Product", $results);

		// grab the result from the array and validate it
		$pdoProduct = $results[0];
		$this->assertEquals($pdoProduct->getProductAccountId(), $this->account->getAccountId);
		$this->assertEquals($pdoProduct->getProductImageId(), $this->image->getImageId);
		$this->assertEquals($pdoProduct->getProductAdminFee(), $this->VALID_PRODUCTADMINFEE);
		$this->assertEquals($pdoProduct->getProductDescription(), $this->VALID_PRODUCTDESCRIPTION);
		$this->assertEquals($pdoProduct->getProductPrice(), $this->VALID_PRODUCTPRICE);
		$this->assertEquals($pdoProduct->getProductShipping(), $this->VALID_PRODUCTSHIPPING);
		$this->assertEquals($pdoProduct->getProductSold(), $this->VALID_PRODUCTSOLD);
		$this->assertEquals($pdoProduct->getProductTitle(), $this->VALID_PRODUCTTITLE);
	}

}

?>