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
		return($this->productId);
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
		if($newProductId <=0) {
			throw(new \RangeException("product id is not positive"));
		}

		// store the product id
		$this->productId = $newProductId;

	}








?>