<?php
namespace Edu\Cnm\CartridgeCoders;

require_once ("autoload.php");


/**
 * Class for ProductPurchase
 * @author Donald DeLeeuw <donald.deleeuw@gmail.com> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 */

class ProductPurchase implements \JsonSerializable {

	/**
	 * id for productId, this is a foreign key & 1/2 composite primary key
	 * @var int $productPurchaseProductId
	 */
	private $productPurchaseProductId;

	/**
	 * id for purchaseId, this is a foreign key & 1/2 composite primary key
	 * @var int $productPurchasePurchaseId
	 */
	private $productPurchasePurchaseId;

	/**
	 * constructor for ProductPurchase class
	 * @param int|null $newProductPurchaseProductId - primary key of product table - this is a foreign key & 1/2 composite primary key
	 * @param int|null $newproductPurchasePurchaseId - primary key of purchase table - this is a foreign key & 1/2 composite primary key
	 * @throws \InvalidArgumentException - if data types are not valid
	 * @throws \RangeException - if values are out of range (strings too long, negative numbers, etc.)
	 * @throws \TypeError - if data types violate type hints
	 * @throws \Exception - catch all if another error occurs
	 **/
	public function __construct(int $newProductPurchasePurchaseId = null, int $newProductPurchaseProductId = null) {
		try {
			$this->setProductPurchasePurchaseId($newProductPurchasePurchaseId);
			$this->setProductPurchaseProductId($newProductPurchaseProductId);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw (new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for productPurchasePurchaseId
	 * @return int|null value of productPurchasePurchaseId
	 */

	public function getPproductPurchasePurchaseId() {
		return($this->productPurchasePurchaseId);
	}

	/**
	 * mutator method for productPurchasePurchaseId
	 * @param int|null $newProductPurchasePurchaseId new value of productPurchasePurchaseId
	 * @throws \RangeException if $newProductPurchasePurchaseId is not positive
	 * @throws \TypeError if $newProductPurchasePurchaseId is not an integer
	 */
	public function setProductPurchasePurchaseId(int $newProductPurchasePurchaseId) {
		// verify the productPurchasePurchaseId is positive
		if($newProductPurchasePurchaseId <= 0) {
			throw(new \RangeException("productPurchasePurchaseId is not positive"));
		}

		// convert and store the profile id
		$this->productPurchasePurchaseId = $newProductPurchasePurchaseId;
	}

	/**
	 * accessor method for productPurchaseProductId
	 * @return int|null value of productPurchaseProductId
	 */

	public function getproductPurchaseProductId() {
		return($this->productPurchaseProductId);
	}

	/**
	 * mutator method for productPurchaseProductId
	 * @param int|null $newProductPurchaseProductId new value of productPurchaseProductId
	 * @throws \RangeException if $newProductPurchaseProductId is not positive
	 * @throws \TypeError if $newProductPurchaseProductId is not an integer
	 */
	public function setProductPurchaseProductId(int $newProductPurchaseProductId) {
		// verify the productPurchaseProductId is positive
		if($newProductPurchaseProductId <= 0) {
			throw(new \RangeException("productPurchaseProductId is not positive"));
		}

		// convert and store the profile id
		$this->productPurchaseProductId = $newProductPurchaseProductId;
	}



	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}

}



