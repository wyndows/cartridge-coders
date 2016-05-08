<?php

namespace Edu\Cnm\CartridgeCoders;

require_once ("autoload.php");

/**
 * ProductCategory class for Cartridge Coders capstone project
 *
 * @author Marlan Ball <wyndows@earthlink.net>
 * @version 1.0.0
 */
class ProductCategory implements \JsonSerializable {
	// use ValidateDate;

	/**
	 * foreign key, this is part of a composite primary key
	 * @var int $productCategoryCategoryId
	 */
	private $productCategoryCategoryId;
	/**
	 * foreign key, this is part of a composite primary key
	 * @var string $productCategoryProductId
	 */
	private $productCategoryProductId;

	/**
	 * constructor for this category
	 *
	 * @param int $newProductCategoryCategoryId foreign key part of composite primary key
	 * @param int $newProductCategoryProductId foreign key part of composite primary key
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g. strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(int $newProductCategoryCategoryId, int $newProductCategoryProductId) {
		try {
			$this->setProductCategoryCategoryId($newProductCategoryCategoryId);
			$this->setProductCategoryProductId($newProductCategoryProductId);
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
	 * accessor method for productCategoryCategoryId
	 *
	 * @return int|null value of productCategoryCategoryId
	 */

	public function getproductCategoryCategoryId() {
		return($this->productCategoryCategoryId);
	}

	/**
	 * mutator method for productCategoryCategoryId
	 *
	 * @param int|null $newProductCategoryCategoryId new value of productCategoryCategoryId
	 * @throws \RangeException if $newProductCategoryCategoryId is not positive
	 * @throws \TypeError if $newProductCategoryCategoryId is not an integer
	 */
	public function setProductCategoryCategoryId(int $newProductCategoryCategoryId) {
		// verify the productCategoryCategoryId is positive
		if($newProductCategoryCategoryId <= 0) {
			throw(new \RangeException("productCategoryCategoryId is not positive"));
		}

		// convert and store the profile id
		$this->productCategoryCategoryId = $newProductCategoryCategoryId;
	}

	/**
	 * accessor method for productCategoryProductId
	 *
	 * @return int|null value of productCategoryProductId
	 */

	public function getproductCategoryProductId() {
		return($this->productCategoryProductId);
	}

	/**
	 * mutator method for productCategoryProductId
	 *
	 * @param int|null $newProductCategoryProductId new value of productCategoryProductId
	 * @throws \RangeException if $newProductCategoryProductId is not positive
	 * @throws \TypeError if $newProductCategoryProductId is not an integer
	 */
	public function setProductCategoryProductId(int $newProductCategoryProductId) {
		// verify the productCategoryProductId is positive
		if($newProductCategoryProductId <= 0) {
			throw(new \RangeException("productCategoryProductId is not positive"));
		}

		// convert and store the profile id
		$this->productCategoryProductId = $newProductCategoryProductId;
	}

	/**
	 * inserts productCategory composite primary key information into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		// enforce the productCategoryCategoryId or productCategoryProductId is not null (i.e., don't insert a composite primary key with missing data
		if($this->productCategoryCategoryId === null || $this->productCategoryProductId === null) {
			throw(new \PDOException("not a valid composite key"));
		}

		// create query template
		$query = "INSERT INTO productCategory(productCategoryCategoryId, productCategoryProductId) VALUES(:productCategoryCategoryId, :productCategoryProductId)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["productCategoryCategoryId" => $this->productCategoryCategoryId, "productCategoryProductId" => $this->productCategoryProductId];
		$statement->execute($parameters);
	}

	/**
	 * deletes this productCategory composite primary key from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) {
		// enforce the productCategoryCategoryId and productCategoryProductId is not null (don't delete a category that has just been inserted)
		if($this->productCategoryCategoryId === null && $this->productCategoryProductId === null) {
			throw(new \PDOException("unable to delete a productCategory that does not exist"));
		}

		// create query template
		$query = "DELETE FROM productCategory WHERE (productCategoryCategoryId = :productCategoryCategoryId AND productCategoryProductId = :productCategoryProductId)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["productCategoryCategoryId" => $this->productCategoryCategoryId, "productCategoryProductId" => $this->productCategoryProductId];
		$statement->execute($parameters);
	}

	/**
	 * updates the productCategory data in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) {
		// enforce the productCategoryCategoryId is not null (don't update the category data that hasn't been inserted yet
		if($this->productCategoryCategoryId === null || $this->productCategoryProductId) {
			throw(new \PDOException("unable to update the productCategory data that doesn't exist"));
		}

		// create query template
		$query = "UPDATE productCategory SET productCategoryCategoryId = :productCategoryCategoryId AND productCategoryProductId = :productCategoryProductId WHERE productCategoryCategoryId = :productCategoryCategoryId AND productCategoryProductId = :productCategoryProductId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["productCategoryCategoryId" => $this->productCategoryCategoryId, "productCategoryProductId" => $this->productCategoryProductId];
		$statement->execute($parameters);
	}

	/**
	 * get the productCategory by productCategoryCategoryId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $productCategoryCategoryId productCategoryCategoryId to search for
	 * @return productCategoryCategoryId|null productCategoryCategoryId found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProductCategoryByProductCategoryCategoryId(\PDO $pdo, int $categoryId) {
		// sanitize the productCategoryCategoryId before searching
		if($productCategoryCategoryId <= 0) {
			throw(new \PDOException("productCategoryCategoryId is not positive"));
		}

		// create query template
		$query = "SELECT productCategoryCategoryId, productCategoryProductId FROM productCategory WHERE productCategoryCategoryId = :productCategoryCategoryId";
		$statement = $pdo->prepare($query);

		// bind the composite key to the place holder in the template
		$parameters = array("productCategoryCategoryId" => $productCategoryCategoryId, "productCategoryProductId" = $productCategoryProductId);
		$statement->execute($parameters);

		// grab the category from mySQL
		try {
			$productCategory = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$productCategory = new ProductCategory($row["productCategoryCategoryId"], $row["productCategoryProductId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($productCategory);
	}

	/**
	 * get the productCategory by productCategoryProductId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $productCategoryCategoryId productCategoryCategoryId to search for
	 * @return productCategoryProductId|null productCategoryProductId found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProductCategoryByProductCategoryProductId(\PDO $pdo, int $categoryId) {
		// sanitize the productCategoryProductId before searching
		if($productCategoryProductId <= 0) {
			throw(new \PDOException("productCategoryProductId is not positive"));
		}

		// create query template
		$query = "SELECT productCategoryCategoryId, productCategoryProductId FROM productCategory WHERE productCategoryProductId = :productCategoryProductId";
		$statement = $pdo->prepare($query);

		// bind the composite key to the place holder in the template
		$parameters = array("productCategoryCategoryId" => $productCategoryCategoryId, "productCategoryProductId" = $productCategoryProductId);
		$statement->execute($parameters);

		// grab the category from mySQL
		try {
			$productCategory = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$productCategory = new ProductCategory($row["productCategoryCategoryId"], $row["productCategoryProductId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($productCategory);
	}

	/**
	 * gets all productCategory primary keys
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of ProductCategories found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllProductCategories(\PDO $pdo) {
		// create query template
		$query = "SELECT productCategoryCategoryId, productCategoryProductId FROM productCategory";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of productCategories
		$productCategories = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productCategory = new ProductCategory($row["productCategoryCategoryId"], $row["productCategoryProductId"]);
				$productCategories[$productCategories->key()] = $productCategory;
				$productCategories->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($productCategories);
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