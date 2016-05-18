<?php

namespace Edu\Cnm\CartridgeCoders;

require_once ("autoload.php");

/**
 * ProductPurchase class for Cartridge Coders capstone project
 *
 * @author Donald Deleeuw <donald.deleeuw@gmail.com> based on code by Marlan Ball <wyndows@earthlink.net>
 */
class ProductPurchase implements \JsonSerializable {
	// use ValidateDate;

	/**
	 * foreign key, this is part of a composite primary key
	 * @var int $productPurchasePurchaseId
	 */
	private $productPurchasePurchaseId;
	/**
	 * foreign key, this is part of a composite primary key
	 * @var string $productPurchaseProductId
	 */
	private $productPurchaseProductId;

	/**
	 * constructor for this purchase
	 *
	 * @param int $newProductPurchasePurchaseId foreign key part of composite primary key
	 * @param int $newProductPurchaseProductId foreign key part of composite primary key
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g. strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(int $newProductPurchasePurchaseId, int $newProductPurchaseProductId) {
		try {
			$this->setProductPurchasePurchaseId($newProductPurchasePurchaseId);
			$this->setProductPurchaseProductId($newProductPurchaseProductId);
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
	 * accessor method for productPurchasePurchaseId
	 *
	 * @return int|null value of productPurchasePurchaseId
	 */

	public function getproductPurchasePurchaseId() {
		return($this->productPurchasePurchaseId);
	}

	/**
	 * mutator method for productPurchasePurchaseId
	 *
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
	 *
	 * @return int|null value of productPurchaseProductId
	 */

	public function getproductPurchaseProductId() {
		return($this->productPurchaseProductId);
	}

	/**
	 * mutator method for productPurchaseProductId
	 *
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
	 * inserts productPurchase composite primary key information into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		// enforce the productPurchasePurchaseId or productPurchaseProductId is not null (i.e., don't insert a composite primary key with missing data
		if($this->productPurchasePurchaseId === null || $this->productPurchaseProductId === null) {
			throw(new \PDOException("not a valid composite key"));
		}

		// create query template
		$query = "INSERT INTO productPurchase(productPurchasePurchaseId, productPurchaseProductId) VALUES(:productPurchasePurchaseId, :productPurchaseProductId)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["productPurchasePurchaseId" => $this->productPurchasePurchaseId, "productPurchaseProductId" => $this->productPurchaseProductId];
		$statement->execute($parameters);
	}

	/**
	 * deletes this productPurchase composite primary key from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) {
		// enforce the productPurchasePurchaseId and productPurchaseProductId is not null (don't delete a purchase that has just been inserted)
		if($this->productPurchasePurchaseId === null && $this->productPurchaseProductId === null) {
			throw(new \PDOException("unable to delete a productPurchase that does not exist"));
		}

		// create query template
		$query = "DELETE FROM productPurchase WHERE (productPurchasePurchaseId = :productPurchasePurchaseId AND productPurchaseProductId = :productPurchaseProductId)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["productPurchasePurchaseId" => $this->productPurchasePurchaseId, "productPurchaseProductId" => $this->productPurchaseProductId];
		$statement->execute($parameters);
	}

	/**
	 * updates the productPurchase data in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) {
		// enforce the productPurchasePurchaseId is not null (don't update the purchase data that are null
		if($this->productPurchasePurchaseId === null || $this->productPurchaseProductId === null) {
			throw(new \PDOException("unable to update the productPurchase data that doesn't exist"));
		}

		// see if the foreign keys are too large
		if($this->productPurchasePurchaseId > 4294967295 || $this->productPurchaseProductId > 4294967295) {
			throw(new \PDOException("foreign keys are too large"));
		}

		// create query template
		$query = "UPDATE productPurchase SET productPurchasePurchaseId = :productPurchasePurchaseId AND productPurchaseProductId = :productPurchaseProductId WHERE productPurchasePurchaseId = :productPurchasePurchaseId AND productPurchaseProductId = :productPurchaseProductId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["productPurchasePurchaseId" => $this->productPurchasePurchaseId, "productPurchaseProductId" => $this->productPurchaseProductId];
		$statement->execute($parameters);
	}

	/**
	 * get the productPurchase by productPurchasePurchaseIdAndProductId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $productPurchasePurchaseId productPurchasePurchaseId to search for
	 * @param int $productPurchaseProductId productPurchaseProductId to search for
	 * @return productPurchase productPurchase found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProductPurchaseByProductPurchasePurchaseIdAndProductId(\PDO $pdo, int $productPurchasePurchaseId, int $productPurchaseProductId) {
		// sanitize the productPurchasePurchaseId before searching
		if($productPurchasePurchaseId <= 0) {
			throw(new \PDOException("productPurchasePurchaseId is not positive"));
		}
		// sanitize the productPurchaseProductId before searching
		if($productPurchaseProductId <= 0) {
			throw(new \PDOException("productPurchaseProductId is not positive"));
		}

		// create query template
		$query = "SELECT productPurchasePurchaseId, productPurchaseProductId FROM productPurchase WHERE productPurchasePurchaseId = :productPurchasePurchaseId AND productPurchaseProductId = :productPurchaseProductId";
		$statement = $pdo->prepare($query);

		// bind the composite key to the place holder in the template
		$parameters = array("productPurchasePurchaseId" => $productPurchasePurchaseId, "productPurchaseProductId" => $productPurchaseProductId);
		$statement->execute($parameters);

		// grab the purchase from mySQL
		try {
			$productPurchase = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$productPurchase = new ProductPurchase($row["productPurchasePurchaseId"], $row["productPurchaseProductId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($productPurchase);
	}

	/**
	 * gets all productPurchase primary keys
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of ProductPurchases found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllProductPurchases(\PDO $pdo) {
		// create query template
		$query = "SELECT productPurchasePurchaseId, productPurchaseProductId FROM productPurchase";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of productPurchases
		$productPurchases = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productPurchase = new ProductPurchase($row["productPurchasePurchaseId"], $row["productPurchaseProductId"]);
				$productPurchases[$productPurchases->key()] = $productPurchase;
				$productPurchases->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($productPurchases);
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

?>