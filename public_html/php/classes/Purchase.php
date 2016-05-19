<?php
namespace Edu\Cnm\CartridgeCoders;

require_once ("autoload.php");

/**
 * Purchase class for Cartridge Coders capstone project
 *
 * @author Marlan Ball <wyndows@earthlink.net>
 * @version 1.0.0
 */
class Purchase implements \JsonSerializable {

	use ValidateDate;

	/**
	 * id for this purchase; this is the primary key
	 * @var int $purchaseId
	 */
	private $purchaseId;
	/**
	 * the account id of the purchase (foreign key)
	 * @var string $purchaseAccountId
	 */
	private $purchaseAccountId;
	/**
	 * the paypal transaction id of the purchase
	 * @var string $purchasePayPalTransactionId
	 */
	private $purchasePayPalTransactionId;
	/**
	 * the purchase creation date
	 * @var \DateTime $purchaseCreateDate
	 **/
	private $purchaseCreateDate;


	/**
	 * constructor for this purchase
	 *
	 * @param int|null $newPurchaseId id of this purchase or null if a new purchase
	 * @param int $newPurchaseAccountId id of account holder making purchase
	 * @param string $newPurchasePayPalTransactionId id of paypal transaction
	 * @param \DateTime|string|null $newPurchaseCreateDate date and time Purchase was made or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g. strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(int $newPurchaseId = null, int $newPurchaseAccountId, string $newPurchasePayPalTransactionId, $newPurchaseCreateDate = null) {
		try {
			$this->setPurchaseId($newPurchaseId);
			$this->setPurchaseAccountId($newPurchaseAccountId);
			$this->setPurchasePayPalTransactionId($newPurchasePayPalTransactionId);
			$this->setPurchaseCreateDate($newPurchaseCreateDate);
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
	 * accessor method for purchase id
	 *
	 * @return int|null value of purchase id
	 */

	public function getPurchaseId() {
		return ($this->purchaseId);
	}

	/**
	 * mutator method for purchase id
	 *
	 * @param int|null $newPurchaseId new value of purchase id
	 * @throws \RangeException if $newPurchaseId is not positive
	 * @throws \TypeError if $newPurchaseId is not an integer
	 */
	public function setPurchaseId(int $newPurchaseId = null) {
		// base case: if the purchase id is null, this is a new purchase without a mySQL assigned id
		if($newPurchaseId === null) {
			$this->purchaseId = null;
			return;
		}

		// verify the purchase id is positive
		if($newPurchaseId <= 0) {
			throw(new \RangeException("purchase id is not positive"));
		}

		// store the purchase id
		$this->purchaseId = $newPurchaseId;

	}

	/**
	 * accessor method for purchase account id
	 *
	 * @return int value of purchase account id
	 */

	public function getPurchaseAccountId() {
		return ($this->purchaseAccountId);
	}

	/**
	 * mutator method for purchase account id
	 *
	 * @param int|null $newPurchaseAccountId new value of purchase account id
	 * @throws \RangeException if $newPurchaseAccountId is not positive
	 * @throws \TypeError if $newPurchaseAccountId is not an integer
	 */
	public function setPurchaseAccountId(int $newPurchaseAccountId) {
		// verify the purchaseAccountId is positive
		if($newPurchaseAccountId <= 0) {
			throw(new \RangeException("purchaseAccountId is not positive"));
		}

		// convert and store the account id
		$this->purchaseAccountId = $newPurchaseAccountId;
	}

	/**
	 * accessor method for purchase paypal transaction id
	 *
	 * @return int value of purchase paypal transaction id
	 */

	public function getPurchasePayPalTransactionId() {
		return ($this->purchasePayPalTransactionId);
	}

	/**
	 * mutator method for purchase paypal transaction id
	 *
	 * @param string $newPurchasePayPalTransactionId new value of purchase paypal transaction id
	 * @throws \RangeException if $newPurchasePayPalTransactionId is not positive
	 * @throws \TypeError if $newPurchasePayPalTransactionId is not an integer
	 */
	public function setPurchasePayPalTransactionId(string $newPurchasePayPalTransactionId) {
		// verify the purchase paypal transaction id is secure
		$newPurchasePayPalTransactionId = trim($newPurchasePayPalTransactionId);
		$newPurchasePayPalTransactionId = filter_var($newPurchasePayPalTransactionId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPurchasePayPalTransactionId) === true) {
			throw(new \InvalidArgumentException("purchase paypal transaction id is empty or insecure"));
		}

		// verify the purchase paypal transaction id will fit in the database
		if(strlen($newPurchasePayPalTransactionId) > 28) {
			throw(new \RangeException("purchase paypal transaction id too large"));
		}

		// store the purchase paypal transaction id
		$this->purchasePayPalTransactionId = $newPurchasePayPalTransactionId;
	}

	/**
	 * accessor method for purchase date
	 *
	 * @return \DateTime value of purchase date
	 **/
	public function getPurchaseCreateDate() {
		return($this->purchaseCreateDate);
	}

	/**
	 * mutator method for purchase date
	 *
	 * @param \DateTime|string|null $newPurchaseCreateDate purchase date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newPurchaseCreateDate is not a valid object or string
	 * @throws \RangeException if $newPurchaseCreateDate is  a date that does not exist
	 **/
	public function setPurchaseCreateDate($newPurchaseCreateDate = null) {
		// base case: if the date is null, use the current date and time
		if($newPurchaseCreateDate === null) {
			$this->purchaseCreateDate = new \DateTime();
			return;
		}

		// store the purchase date
		try {
			$newPurchaseCreateDate = $this->validateDate($newPurchaseCreateDate);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->purchaseCreateDate = $newPurchaseCreateDate;
	}

	/**
	 * inserts purchase information into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		// enforce the purchaseId is null (i.e., don't insert a purchase that already exists
		if($this->purchaseId !== null) {
			throw(new \PDOException("not a new purchase"));
		}

//		var_dump($this->purchasePayPalTransactionId);

		// create query template
		$query = "INSERT INTO purchase(purchaseAccountId, purchasePayPalTransactionId, purchaseCreateDate) VALUES(:purchaseAccountId, :purchasePayPalTransactionId, :purchaseCreateDate)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->purchaseCreateDate->format("Y-m-d H:i:s");
		$parameters = ["purchaseAccountId" => $this->purchaseAccountId, "purchasePayPalTransactionId" => $this->purchasePayPalTransactionId, "purchaseCreateDate" => $formattedDate];
		$statement->execute($parameters);

		// update the null purchaseId with what mySQL just gave us
		$this->purchaseId = intval($pdo->lastInsertId());
	}


	/**
	 * get the purchase by purchaseId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $purchaseId purchase id to search for
	 * @return Purchase|null purchase found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getPurchaseByPurchaseId(\PDO $pdo, int $purchaseId) {
		// sanitize the purchaseId before searching
		if($purchaseId <= 0) {
			throw(new \PDOException("purchase id is not positive"));
		}

		// create query template
		$query = "SELECT purchaseId, purchaseAccountId, purchasePayPalTransactionId, purchaseCreateDate FROM purchase WHERE purchaseId = :purchaseId";
		$statement = $pdo->prepare($query);

		// bind the purchase id to the place holder in the template
		$parameters = array("purchaseId" => $purchaseId);
		$statement->execute($parameters);

		// grab the purchase from mySQL
		try {
			$purchase = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$purchase = new Purchase($row["purchaseId"], $row["purchaseAccountId"], $row["purchasePayPalTransactionId"], $row["purchaseCreateDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($purchase);
	}

	/**
	 * get the purchase by purchaseAccountId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $purchaseAccountId purchase accountid to search for
	 * @return \SplFixedArray SplFixedArray of purchase found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getPurchaseByPurchaseAccountId(\PDO $pdo, int $purchaseAccountId) {
		// sanitize the purchaseAccountId before searching
		if($purchaseAccountId <= 0) {
			throw(new \PDOException("purchase accountid is not positive"));
		}

		// create query template
		$query = "SELECT purchaseId, purchaseAccountId, purchasePayPalTransactionId, purchaseCreateDate FROM purchase WHERE purchaseAccountId = :purchaseAccountId";
		$statement = $pdo->prepare($query);

		// bind the purchase accountid to the place holder in the template
		$parameters = array("purchaseAccountId" => $purchaseAccountId);
		$statement->execute($parameters);

		// build an array of purchases
		$purchases = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$purchase = new Purchase($row["purchaseId"], $row["purchaseAccountId"], $row["purchasePayPalTransactionId"], $row["purchaseCreateDate"]);
				$purchases[$purchases->key()] = $purchase;
				$purchases->next();
			}
			catch
			(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($purchases);
	}

	/**
	 * get the purchase by paypal transaction id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $purchasePayPalTransactionId purchase paypal transaction id to search for
	 * @return \SplFixedArray SplFixedArray of purchase found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPurchaseByPurchasePayPalTransactionId(\PDO $pdo, string $purchasePayPalTransactionId) {
		// sanitize the paypal transaction id before searching
		$purchasePayPalTransactionId = trim($purchasePayPalTransactionId);
		$purchasePayPalTransactionId = filter_var($purchasePayPalTransactionId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($purchasePayPalTransactionId) === true) {
			throw(new \PDOException("purchase paypal transaction id is invalid"));
		}

		// create query template
		$query = "SELECT purchaseId, purchaseAccountId, purchasePayPalTransactionId, purchaseCreateDate FROM purchase WHERE purchasePayPalTransactionId = :purchasePayPalTransactionId";
		$statement = $pdo->prepare($query);

		// bind the paypal transaction id to the place holder in the template
		$parameters = array("purchasePayPalTransactionId" => $purchasePayPalTransactionId);
		$statement->execute($parameters);

		// grab the purchase from mySQL
		try {
			$purchase = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$purchase = new Purchase($row["purchaseId"], $row["purchaseAccountId"], $row["purchasePayPalTransactionId"], $row["purchaseCreateDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($purchase);
	}

	
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["purchaseCreateDate"] = intval($this->purchaseCreateDate->format("U")) * 1000;
		return ($fields);
	}
}
?>