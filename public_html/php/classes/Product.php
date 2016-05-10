<?php
namespace Edu\Cnm\CartridgeCoders;

require_once ("autoload.php");

/**
 * Product class for Cartridge Coders capstone project
 *
 * @author Marlan Ball <wyndows@earthlink.net>
 * @version 1.0.0
 */
class Product implements \JsonSerializable {
	// use ValidateDate;

	/**
	 * id for this product; this is the primary key
	 * @var int $productId
	 */
	private $productId;
	/**
	 * the account id of the product (foreign key)
	 * @var string $productAccountId
	 */
	private $productAccountId;
	/**
	 * the image id of the product (foreign key)
	 * @var string $productImageId
	 */
	private $productImageId;
	/**
	 * the admin fee of the product
	 * @var string $productAdminFee
	 */
	private $productAdminFee;
	/**
	 * the description of the product
	 * @var string $productDescription
	 */
	private $productDescription;
	/**
	 * the price of the product
	 * @var string $productPrice
	 */
	private $productPrice;
	/**
	 * the shipping of the product
	 * @var string $productShipping
	 */
	private $productShipping;
	/**
	 * the sold status of the product
	 * @var string $productSold
	 */
	private $productSold;
	/**
	 * the title of the product
	 * @var string $productTitle
	 */
	private $productTitle;

	/**
	 * constructor for this product
	 *
	 * @param int|null $newProductId id of this product or null if a new product
	 * @param int $newProductAccountId id of account holder selling product
	 * @param int $newProductImageId id of image attached to product
	 * @param decimal $newProductAdminFee percent of sale listing fee
	 * @param string $newProductDescription string containing description of the product
	 * @param decimal $newProductPrice cost of product
	 * @param decimal $newProductShipping shipping cost of product
	 * @param int $newProductSold sold status of product
	 * @param string $newProductTitle title of product listing
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g. strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(int $newProductId = null, int $newProductAccountId, int $newProductImageId, decimal $newProductAdminFee, string $newProductDescription, decimal $newProductPrice, decimal $newProductShipping, int $newProductSold, string $newProductTitle) {
		try {
			$this->setProductId($newProductId);
			$this->setProductAccountId($newProductAccountId);
			$this->setProductImageId($newProductImageId);
			$this->setProductAdminFee($newProductAdminFee);
			$this->setProductDescription($newProductDescription);
			$this->setProductPrice($newProductPrice);
			$this->setProductShipping($newProductShipping);
			$this->setProductSold($newProductSold);
			$this->setProductTitle($newProductTitle);
		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			//rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			//rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for product id
	 *
	 * @return int|null value of product id
	 */

	public function getProductId() {
		return ($this->productId);
	}

	/**
	 * mutator method for product id
	 *
	 * @param int|null $newProductId new value of product id
	 * @throws \RangeException if $newProductId is not positive
	 * @throws \TypeError if $newProductId is not an integer
	 */
	public function setProductId(int $newProductId = null) {
		// base case: if the product id is null, this is a new product without a mySQL assigned id
		if($newProductId === null) {
			$this->productId = null;
			return;
		}

		// verify the product id is positive
		if($newProductId <= 0) {
			throw(new \RangeException("product id is not positive"));
		}

		// store the product id
		$this->productId = $newProductId;

	}

	/**
	 * accessor method for product account id
	 *
	 * @return int value of product account id
	 */

	public function getProductAccountId() {
		return ($this->productAccountId);
	}

	/**
	 * mutator method for product account id
	 *
	 * @param int|null $newProductAccountId new value of product account id
	 * @throws \RangeException if $newProductAccountId is not positive
	 * @throws \TypeError if $newProductAccountId is not an integer
	 */
	public function setProductAccountId(int $newProductAccountId) {
		// verify the productAccountId is positive
		if($newProductAccountId <= 0) {
			throw(new \RangeException("productAccountId is not positive"));
		}

		// convert and store the account id
		$this->productAccountId = $newProductAccountId;
	}

	/**
	 * accessor method for product image id
	 *
	 * @return int value of product image id
	 */

	public function getProductImageId() {
		return ($this->productImageId);
	}

	/**
	 * mutator method for product image id
	 *
	 * @param int|null $newProductImageId new value of product image id
	 * @throws \RangeException if $newProductImageId is not positive
	 * @throws \TypeError if $newProductImageId is not an integer
	 */
	public function setProductImageId(int $newProductImageId) {
		// verify the productAccountId is positive
		if($newProductImageId <= 0) {
			throw(new \RangeException("productImageId is not positive"));
		}

		// convert and store the image id
		$this->productImageId = $newProductImageId;
	}

	/**
	 * accessor method for product admin fee
	 *
	 * @return decimal value of product admin fee
	 */
	public function getProductAdminFee() {
		return ($this->productAdminFee);
	}

	/**
	 * mutator method for product admin fee
	 *
	 * @param decimal $newProductAdminFee new value of product admin fee
	 * @throws \RangeException if $newProductAdminFee is not positive
	 * @throws \RangeException if $newProductAdminFee is too high
	 * @throws \TypeError if $newProductAdminFee is not a decimal
	 */
	public function setProductAdminFee(decimal $newProductAdminFee) {
		// verify the productAdminFee is positive and not too high
		if($newProductAdminFee < 0) {
			throw(new \RangeException("productAdminFee is not positive"));
		}
		if($newProductAdminFee >= 1000.00) {
			throw(new \RangeException("productAdminFee is too high"));
		}

		// convert and store the product admin fee
		$this->productAdminFee = $newProductAdminFee;
	}

	/**
	 * accessor method for product description
	 *
	 * @return string value of product description
	 */
	public function getProductDescription() {
		return ($this->productDescription);
	}

	/**
	 * mutator method for product description
	 *
	 * @param string $newProductDescription new value of product description
	 * @throws \InvalidArgumentException if $newProductDescription is not a string or insecure
	 * @throws \RangeException if $newProductDescription is > 255 characters
	 * @throws \TypeError if $newProductDescription is not a string
	 */
	public function setProductDescription(string $newProductDescription) {
		// verify the product description is secure
		$newProductDescription = trim($newProductDescription);
		$newProductDescription = filter_var($newProductDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProductDescription) === true) {
			throw(new \InvalidArgumentException("product description is empty or insecure"));
		}

		// verify the product description will fit in the database
		if(strlen($newProductDescription) > 255) {
			throw(new \RangeException("product description is too long"));
		}

		// store the product description
		$this->productDescription = $newProductDescription;
	}

	/**
	 * accessor method for product price
	 *
	 * @return decimal value of product price
	 */
	public function getProductPrice() {
		return ($this->productPrice);
	}

	/**
	 * mutator method for product price
	 *
	 * @param decimal $newProductPrice new value of product price
	 * @throws \RangeException if $newProductPrice is not positive
	 * @throws \RangeException if $newProductPrice is too high
	 * @throws \TypeError if $newProductPrice is not a decimal
	 */
	public function setProductPrice(decimal $newProductPrice) {
		// verify the productPrice is positive and not too high
		if($newProductPrice < 0) {
			throw(new \RangeException("productPrice is not positive"));
		}
		if($newProductPrice >= 10000.00) {
			throw(new \RangeException("productPrice is too high"));
		}

		// convert and store the product price
		$this->productPrice = $newProductPrice;
	}

	/**
	 * accessor method for product shipping
	 *
	 * @return decimal value of product shipping
	 */
	public function getProductShipping() {
		return ($this->productShipping);
	}

	/**
	 * mutator method for product shippping
	 *
	 * @param decimal $newProductShipping new value of product shipping
	 * @throws \RangeException if $newProductShipping is not positive
	 * @throws \RangeException if $newProductShipping is too high
	 * @throws \TypeError if $newProductShipping is not a decimal
	 */
	public function setProductShipping(decimal $newProductShipping) {
		// verify the productShipping is positive and not too high
		if($newProductShipping < 0) {
			throw(new \RangeException("productShipping is not positive"));
		}
		if($newProductShipping >= 1000.00) {
			throw(new \RangeException("productShipping is too high"));
		}

		// convert and store the product shipping
		$this->productShipping = $newProductShipping;
	}

	/**
	 * accessor method for product sold
	 *
	 * @return int value of product sold
	 */
	public function getProductSold() {
		return ($this->productSold);
	}

	/**
	 * mutator method for product sold
	 *
	 * @param int $newProductSold new value of product sold
	 * @throws \RangeException if $newProductSold is not positive
	 * @throws \RangeException if $newProductSold is too high
	 * @throws \TypeError if $newProductSold is not an int
	 */
	public function setProductSold(int $newProductSold) {
		// verify the productSold is positive and not too high
		if($newProductSold < 0) {
			throw(new \RangeException("productSold is not positive"));
		}
		if($newProductSold > 1) {
			throw(new \RangeException("productSold is too high"));
		}

		// convert and store the product sold
		$this->productSold = $newProductSold;
	}

	/**
	 * accessor method for product title
	 *
	 * @return string value of product title
	 */
	public function getProductTitle() {
		return ($this->productTitle);
	}

	/**
	 * mutator method for product title
	 *
	 * @param string $newProductTitle new value of product title
	 * @throws \InvalidArgumentException if $newProductTitle is not a string or insecure
	 * @throws \RangeException if $newProductTitle is > 64 characters
	 * @throws \TypeError if $newProductTitle is not a string
	 */
	public function setProductTitle(string $newProductTitle) {
		// verify the product title is secure
		$newProductTitle = trim($newProductTitle);
		$newProductTitle = filter_var($newProductTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProductTitle) === true) {
			throw(new \InvalidArgumentException("product title is empty or insecure"));
		}

		// verify the product title will fit in the database
		if(strlen($newProductTitle) > 64) {
			throw(new \RangeException("product title is too long"));
		}

		// store the product title
		$this->productTitle = $newProductTitle;
	}

	/**
	 * inserts product information into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		// enforce the productId is null (i.e., don't insert a product that already exists
		if($this->productId !== null) {
			throw(new \PDOException("not a new product"));
		}

		// create query template
		$query = "INSERT INTO product(productAccountId, productImageId, productAdminFee, productDescription, productPrice, productShipping, productSold, productTitle) VALUES(:productAccountId, :productImageId, :productAdminFee, :productDescription, :productPrice, :productShipping, :productSold, :productTitle)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["productAccountId" => $this->account->getAccountId, "productImageId" => $this->image->getImageId, "productAdminFee" => $this->productAdminFee, "productDescription" => $this->productDescription, "productPrice" => $this->productPrice, "productShipping" => $this->productShipping, "productSold" => $this->productSold, "productTitle" => $this->productTitle];
		$statement->execute($parameters);

		// update the null productId with what mySQL just gave us
		$this->productId = intval($pdo->lastInsertId());

	}

	/**
	 * deletes this product from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) {
		// enforce the productId is not null (don't delete a product that has just been inserted)
		if($this->productId === null) {
			throw(new \PDOException("unable to delete a product that does not exist"));
		}

		// create query template
		$query = "DELETE FROM product WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["productId" => $this->productId];
		$statement->execute($parameters);
	}

	/**
	 * updates the product data in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) {
		// enforce the productId is not null (don't update the product data that hasn't been inserted yet
		if($this->productId === null) {
			throw(new \PDOException("unable to update the product data that doesn't exist"));
		}

		// create query template
		$query = "UPDATE product SET productAccountId = :productAccountId, productImageId = :productImageId, productAdminFee = :productAdminFee, productDescription = :productDescription, productPrice = :productPrice, productShipping = :productShipping, productSold = :productSold, productTitle = :productTitle WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["productAccountId" => $this->productAccountId, "productImageId" => $this->productImageId, "productAdminFee" => $this->productAdminFee, "productDescription" => $this->productDescription, "productPrice" => $this->productPrice, "productShipping" => $this->productShipping, "productSold" => $this->productSold, "productTitle" => $this->productTitle, "productId" => $this->productId];
		$statement->execute($parameters);
	}

	




	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
}
?>