<?php

	namespace Edu\Cnm\CartridgeCoders;

	require_once ("autoload.php");

	/**
	 * Category class for Cartridge Coders capstone project
	 *
	 * @author Marlan Ball <wyndows@earthlink.net>
	 * @version 1.0.0
	 */
	class Category implements \JsonSerializable {
		// use ValidateDate;

		/**
		 * id for this category; this is the primary key
		 * @var int $categoryId
		 */
		private $categoryId;
		/**
		 * the name of the category
		 * @var string $categoryName
		 */
		private $categoryName;

		/**
		 * constructor for this category
		 *
		 * @param int|null $newCategoryId id of this category or null if a new category
		 * @param string $newCategoryName string containing name of the category
		 * @throws \InvalidArgumentException if data types are not valid
		 * @throws \RangeException if data values are out of bounds (e.g. strings too long, negative integers)
		 * @throws \TypeError if data types violate type hints
		 * @throws \Exception if some other exception occurs
		 */
		public function __construct(int $newCategoryId = null, string $newCategoryName) {
			try {
				$this->setCategoryId($newCategoryId);
				$this->setCategoryName($newCategoryName);
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
		 * accessor method for category id
		 *
		 * @return int|null value of category id
		 */

		public function getCategoryId() {
			return($this->categoryId);
		}

		/**
		 * mutator method for category id
		 *
		 * @param int|null $newCategoryId new value of category id
		 * @throws \RangeException if $newCategoryId is not positive
		 * @throws \TypeError if $newCategoryId is not an integer
		 */
		public function setCategoryId(int $newCategoryId = null) {
			// base case: if the category id is null, this is a new category without a mySQL assigned id
			if($newCategoryId === null) {
				$this->categoryId = null;
				return;
			}

			// verify the category id is positive
			if($newCategoryId <=0) {
				throw(new \RangeException("category id is not positive"));
			}

			// store the category id
			$this->categoryId = $newCategoryId;

		}

		/**
		 * accessor method for category name
		 *
		 * @return string value of category name
		 */
		public function getCategoryName() {
			return($this->categoryName);
		}

		/**
		 * mutator method for category name
		 *
		 * @param string $newCategoryName new value of category name
		 * @throws \InvalidArgumentException if $newCategoryName is not a string or insecure
		 * @throws \RangeException if $newCategoryName is > 50 characters
		 * @throws \TypeError if $newCategoryName is not a string
		 */
		public function setCategoryName(string $newCategoryName) {
			// verify the category name is secure
			$newCategoryName = trim($newCategoryName);
			$newCategoryName = filter_var($newCategoryName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newCategoryName) === true) {
				throw(new \InvalidArgumentException("category name content is empty or insecure"));
			}

			// verify the category name will fit in the database
			if(strlen($newCategoryName) > 50) {
				throw(new \RangeException("category name is too long"));
			}

			// store the category name
			$this->categoryName = $newCategoryName;
		}

		/**
		 * inserts category information into mySQL
		 *
		 * @param \PDO $pdo PDO connection object
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError if $pdo is not a PDO connection object
		 */
		public function insert(\PDO $pdo) {
			// enforce the categoryId is null (i.e., don't insert a category that already exists
			if($this->categoryId !== null) {
				throw(new \PDOException("not a new category"));
			}

			// create query template
			$query = "INSERT INTO category(categoryName) VALUES(:categoryName)";
			$statement = $pdo->prepare($query);

			// bind the member variables to the place holders in the template
			$parameters = ["categoryId" => $this->categoryId, "categoryName" => $this->categoryName];
			$statement->execute($parameters);

			// update the null categoryId with what mySQL just gave us
			$this->categoryId = intval($pdo->lastInsertId());

		}

		/**
		 * deletes this category from mySQL
		 *
		 * @param \PDO $pdo PDO connection object
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError if $pdo is not a PDO connection object
		 */
		public function delete(\PDO $pdo) {
			// enforce the categoryId is not null (don't delete a category that has just been inserted)
			if($this->categoryId === null) {
				throw(new \PDOException("unable to delete a category that does not exist"));
			}

			// create query template
			$query = "DELETE FROM category WHERE categoryId = :categoryId";
			$statement = $pdo->prepare($query);

			// bind the member variables to the place holder in the template
			$parameters = ["categoryId" => $this->categoryId];
			$statement->execute($parameters);
		}

		/**
		 * updates the category data in mySQL
		 *
		 * @param \PDO $pdo PDO connection object
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError if $pdo is not a PDO connection object
		 */
		public function update(\PDO $pdo) {
			// enforce the categoryId is not null (don't update the category data that hasn't been inserted yet
			if($this->categoryId === null) {
				throw(new \PDOException("unable to update the category data that doesn't exist"));
			}

			// create query template
			$query = "UPDATE category SET categoryName = :categoryName WHERE categoryId = :categoryId";
			$statement = $pdo->prepare($query);

			// bind the member variables to the place holders in the template
			$parameters = ["categoryName" => $this->categoryName];
			$statement->execute($parameters);
		}

		/**
		 * gets the category name by content
		 *
		 * @param \PDO $pdo PDO connection object
		 * @param string $categoryName category name content to search for
		 * @return \SplFixedArray SplFixedArray of category data found
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when variables are not the correct data type
		 */
		public static function getCategoryByCategoryName(\PDO $pdo, string $categoryName) {
			// sanitize the description before searching
			$categoryName = trim($categoryName);
			$categoryName = filter_var($categoryName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($categoryName) === true) {
				throw(new \PDOException("category name is invalid"));
			}

			// create query template
			$query = "SELECT categoryId, categoryName  FROM category WHERE categoryName LIKE :categoryName";
			$statement = $pdo->prepare($query);

			// bind the category content to the place holder in the template
			$categoryName = "%$categoryName%";
			$parameters = array("categoryName" => $categoryName);
			$statement->execute($parameters);

			// build an array of categories
			$categories = new \SplFixedArray($statement->rowCount());
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			while(($row = $statement->fetch()) !== false) {
				try {
					$category = new Category($row["categoryId"], $row["categoryName"]);
					$categories[$categories->key()] = $category;
					$categories->next();
				} catch(\Exception $exception) {
					// if the row couldn't be converted, rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
			}
			return($categories);

		}

		/**
		 * get the category by categoryId
		 *
		 * @param \PDO $pdo PDO connection object
		 * @param int $categoryId category id to search for
		 * @return Category|null category found or null if not found
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when variables are not the correct data type
		 */
		public static function getCategoryByCategoryId(\PDO $pdo, int $categoryId) {
			// sanitize the categoryId before searching
			if($categoryId <= 0) {
				throw(new \PDOException("category id is not positive"));
			}

			// create query template
			$query = "SELECT categoryId, categoryName";
			$statement = $pdo->prepare($query);

			// bind the category id to the place holder in the template
			$parameters = array("categoryId" => $categoryId);
			$statement->execute($parameters);

			// grab the category from mySQL
			try {
				$category = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
					$category = new Category($row["categoryId"], $row["categoryName"]);
				}
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return($category);
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