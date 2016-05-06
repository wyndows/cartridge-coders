<?php
namespace Edu\Cnm\CartridgeCoders;

/**
 * Class for ProductPurchase
 * @author Donald DeLeeuw <donald.deleeuw@gmail.com> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 */

class ProductPurchase implements \JsonSerializable {

 /**
  * id for productPurchasePurchaseId.productPurchaseProductId, this is the primary key
  * @var int $productPurchasePurchaseIdProductPurchaseProductId
  */
 private $productPurchasePurchaseIdProductPurchaseProductId;


	/**
	 * id for productId, this is a foreign key
	 * @var int $productPurchaseProductId
	 */
	private $productPurchaseProductId;

	/**
	 * id for purchaseId, this is a foreign key
	 * @var int $productPurchasePurchaseId
	 */
	private $productPurchasePurchaseId;

	/**
	 * constructor for ProductPurchase class
//		* @param int|null $productPurchasePurchaseIdProductPurchaseProductId - composit of purchaseId and priductId - this is the primary key
	 * @param int|null $productPurchaseProductId - primary key of product table - this is a foreign key
	 * @param int|null $productPurchasePurchaseId - primary key of purchase table - this is a foreign key
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






}






