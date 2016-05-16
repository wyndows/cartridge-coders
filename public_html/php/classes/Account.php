<?php
namespace Edu\Cnm\CartridgeCoders;

require_once ("autoload.php");


/**
 * class for Account
 * @author Donald DeLeeuw <donald.deleeuw> based on code by Dylan McDonald <dmcdonad21@cnm.edu>
 */

class Account implements \JsonSerializable {

	/**
	 * id for account, this is the primary key
	 * @var int $accountId
	 */
	private $accountId;

	/**
	 * id for image id, this is a foreign key
	 * @var int $accountImageId
	 */
	private $accountImageId;

	/**
	 * id for account active
	 * @var tinyint $accountActive
	 */
	private $accountActive;

	/** id for account admin
	 * @var tinyint $accountAdmin
	 */
	private $accountAdmin;

	/**
	 * id for account name
	 * @var string $accountName
	 */
	private $accountName;

	/**
	 * id for PP email
	 * @var string $accountPpEmail
	 */
	private $accountPpEmail;

	/**
	 * id for user name
	 * @var string $accountUserName
	 */
	private $accountUserName;

	/**
	 * constructor for Account class
	 * @param int|null $newAccountId - id of account or null if new account - primary key
	 * @param int|null $newAccountImageId - id of image - this is a foreign key
	 * @param int|null $newAccountActive - flag for account active
	 * @param int|null $newAccountAdmin - flag for account admin
	 * @param string $newAccountName - user's name
	 * @param string $newAccountPpEmail - user's paypal email address
	 * @param string $newAccountUserName - user's chosen user name
	 * @throws \InvalidArgumentException - if data types are not valid
	 * @throws \RangeException - if values are out of range (strings too long, negative numbers, etc.)
	 * @throws \TypeError - if data types violate type hints
	 * @throws \Exception - catch all if another error occurs
	 */
	public function __construct(int $newAccountId = null, int $newAccountImageId, int $newAccountActive, int $newAccountAdmin, string $newAccountName, string $newAccountPpEmail, string $newAccountUserName) {
		try {
			$this->setAccountId($newAccountId);
			$this->setAccountImageId($newAccountImageId);
			$this->setAccountActive($newAccountActive);
			$this->setAccountAdmin($newAccountAdmin);
			$this->setAccountName($newAccountName);
			$this->setAccountPpEmail($newAccountPpEmail);
			$this->setAccountUserName($newAccountUserName);
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
	 * accessor method for account id
	 * @return int|null value of account id
	 */
	public function getAccountId() {
		return ($this->accountId);
	}

	/**
	 * mutator method for account id
	 * @param int|null $newAccountId - new value of account id
	 * @throws \RangeException if $newAccountId is not positive
	 * @throws \TypeError if $newAccountId is not an integer
	 **/
	public function setAccountId(int $newAccountId = null) {
		//if account id is null (composing), allow new account id without mySQL assignment
		if($newAccountId === null) {
			$this->accountId = null;
			return;
		}
		// verify account id is positive
		if($newAccountId <= 0) {
			throw(new \RangeException("account id is not positive"));
		}
		// convert and store account id
		$this->accountId = $newAccountId;
	}

	/**
	 * accessor method for account image id
	 * @return int|null value of account image id
	 */
	public function getAccountImageId() {
		return ($this->accountImageId);
	}

	/**
	 * mutator method for account image id
	 * @param int|null $newAccountImageId - new value of account id
	 * @throws \RangeException if $newAccountImageId is not positive
	 * @throws \TypeError if $newAccountImageId is not an integer
	 **/
	public function setAccountImageId(int $newAccountImageId) {

		// verify account image id is positive
		if($newAccountImageId <= 0) {
			throw(new \RangeException("account image id is not positive"));
		}
		// convert and store account image id
		$this->accountImageId = $newAccountImageId;
	}

	/**
	 * accessor method for account active flag
	 * @return int|null value of account active flag
	 */
	public function getAccountActive() {
		return ($this->accountActive);
	}

	/**
	 * mutator method for account active flag
	 * @param int|null $newAccountActive - new value of active flag
	 * @throws \RangeException if $newAccountActive is not positive
	 * @throws \TypeError if $newAccountActive is not an integer
	 **/
	public function setAccountActive(int $newAccountActive) {
		// verify account active flag is positive
		if($newAccountActive != 0 AND $newAccountActive != 1) {
			throw(new \RangeException("account active flag is not positive"));
		}
		// convert and store account active flag
		$this->accountActive = $newAccountActive;
	}


	/**
	 * accessor method for account admin flag
	 * @return int|null value of account admin flag
	 */
	public function getAccountAdmin() {
		return ($this->accountAdmin);
	}

	/**
	 * mutator method for account admin flag
	 * @param int|null $newAccountAdmin - new value of admin flag
	 * @throws \RangeException if $newAccountAdmin is not positive
	 * @throws \TypeError if $newAccountAdmin is not an integer
	 **/
	public function setAccountAdmin(int $newAccountAdmin) {
		
		// verify account admin flag is positive
		if($newAccountAdmin < 0) {
			throw(new \RangeException("account admin flag is not positive"));
		}
		// convert and store account admin flag
		$this->accountAdmin = $newAccountAdmin;
	}


	/**
	 * accessor method for account name
	 *
	 * @return string of account name
	 */
	public function getAccountName() {
		return ($this->accountName);
	}

	/**
	 * mutator method for account name
	 * @param string $newAccountName - new value of account name
	 * @throws \InvalidArgumentException if $newAccountName is not a string or insecure
	 * @throws \RangeException if $newAccountName is > 128 chars
	 * @throws \TypeError if $newAccountName is not a string
	 */
	public function setAccountName(string $newAccountName) {
		// verify account name is secure
		$newAccountName = trim($newAccountName);
		$newAccountName = filter_var($newAccountName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAccountName) === true) {
			throw(new \InvalidArgumentException("account name is empty or insecure"));
		}
		// verify the account name will fit in the database
		if(strlen($newAccountName) > 128) {
			throw(new \RangeException("account name too large"));
		}
		// store account file name
		$this->accountName = $newAccountName;
	}


	/**
	 * accessor method for account pay pal email
	 * @return string of account pay pal email
	 */
	public function getAccountPpEmail() {
		return ($this->accountPpEmail);
	}

	/**
	 * mutator method for account pay pal email
	 * @param string $newAccountPpEmail - new value of account pay pal email
	 * @throws \InvalidArgumentException if $newAccountPpEmail is not a string or insecure
	 * @throws \RangeException if $newAccountPpEmail is > 128 chars
	 * @throws \TypeError if $newAccountPpEmail is not a string
	 */
	public function setAccountPpEmail(string $newAccountPpEmail) {
		// verify account pay pal email is secure
		$newAccountPpEmail = trim($newAccountPpEmail);
		$newAccountPpEmail = filter_var($newAccountPpEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAccountPpEmail) === true) {
			throw(new \InvalidArgumentException("account pay pal email is empty or insecure"));
		}
		// verify the account pay pal email will fit in the database
		if(strlen($newAccountPpEmail) > 128) {
			throw(new \RangeException("account pay pal email too large"));
		}
		// store account pay pal email
		$this->accountPpEmail = $newAccountPpEmail;
	}


	/**
	 * accessor method for account user name
	 * @return string of account user name
	 */
	public function getAccountUserName() {
		return ($this->accountUserName);
	}

	/**
	 * mutator method for account user name
	 * @param string $newAccountPpEmail - new value of account user name
	 * @throws \InvalidArgumentException if $newAccountPpEmail is not a string or insecure
	 * @throws \RangeException if $newAccountPpEmail is > 128 chars
	 * @throws \TypeError if $newAccountPpEmail is not a string
	 */
	public function setAccountUserName(string $newAccountUserName) {
		// verify account user name is secure
		$newAccountUserName = trim($newAccountUserName);
		$newAccountUserName = filter_var($newAccountUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAccountUserName) === true) {
			throw(new \InvalidArgumentException("account user name is empty or insecure"));
		}
		// verify the account user name will fit in the database
		if(strlen($newAccountUserName) > 128) {
			throw(new \RangeException("account user name too large"));
		}
		// store account user name
		$this->accountUserName = $newAccountUserName;
	}


	// ----------------------------------------   accountId ----------------------------------------------
	/**
	 * insert this account into mySQL
	 *
	 * @param \PDO $pdo - PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		// enforce account id is null - make sure inserting new account vs an existing one
		if($this->accountId !== null) {
			throw(new \PDOException("not a new account"));
		}

		//create query table
		$query = "INSERT INTO account(accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName) VALUES (:accountImageId, :accountActive, :accountAdmin, :accountName, :accountPpEmail, :accountUserName)";
		$statement = $pdo->prepare($query); 

		// bind the member variables to the place holders on the template
		$parameters = ["accountImageId" => $this->accountImageId, "accountActive" => $this->accountActive, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);

		//update the null accountId with what mySQL just gave us
		$this->accountId = intval($pdo->lastInsertId());
	}

	/**
	 * updates this account in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) {

		// enforce the accountId is not null (don't update whats not there)
		if($this->accountId === null) {
			throw(new \PDOException("unable to update accout id that does not exist"));
		}

		// create query template
		$query = "UPDATE account SET accountId = :accountId WHERE accountId = :accountId";

		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders
		$parameters = ["accountId" => $this->accountId, "accountActive" => $this->accountActive, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);
	}


	/**
	 * getAllAccountIds
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of account ids found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllAccountIds(\PDO $pdo) {
		// create query template
		$query = "SELECT accountId, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of account ids
		$accountIds = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$accountId = new Image($row["accountId"], $row["imageFileName"], $row["imageType"]);
				$accountIds[$accountIds->key()] = $accountId;
				$accountIds->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($accountIds);
	}

// ------------------------------------------- AccountImageId   -------------------------------------------

	/**
	 * insert account image id into mySQL
	 * @param \PDO $pdo - PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insertAccountImageId(\PDO $pdo) {
		// enforce account image id is null - make sure inserting new id vs an existing one
		if($this->accountImageId !== null) {
			throw(new \PDOException("not an account image id"));
		}

		//create query table
		$query = "INSERT INTO account(accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName) VALUES(:accountImageId, :accountActive, :accountAdmin, :accountName, :accountPpEmail, :accountUserName)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders on the template
		$parameters = ["accountActive" => $this->accountActive, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);

		//update the null accountImageId with what mySQL just gave us
		$this->accountImageId = intval($pdo->lastInsertId());
	}

	/**
	 * updates account image id in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function updateAccountImageId(\PDO $pdo) {

		// enforce the accountImageId is not null (don't update whats not there)
		if($this->accountImageId === null) {
			throw(new \PDOException("unable to update image id that does not exist"));
		}

		// create query template
		$query = "UPDATE account SET accountImageId = :accountImageId WHERE accountImageId = :accountImageId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders
		$parameters = ["accountId" => $this->accountId, "accountImageId" => $this->accountImageId, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);
	}


	/**
	 * gets the account image id by account id
	 * @param \PDO $pdo PDO connection object
	 * @param int $accountImageId - account image id search for
	 * @param int $accountId - prim key
	 * @return Image|null - id found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getAccountImageIdByAccountId(\PDO $pdo, int $accountId) {
		// sanitize the accountId before searching
		if($accountId <= 0) {
			throw(new \PDOException("account id is not positive"));
		}
		// create query template
		$query = "SELECT accountAdmin, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountId = :accountId";
		$statement = $pdo->prepare($query);

		// bind the account id to the place holder in the template
		$parameters = array("accountId" => $accountId);
		$statement->execute($parameters);

		// grab the id from mySQL
		try {
			$accountId = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$accountId = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($accountId);
	}





	/**
	 * get the account by accountId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $accountId account id to search for
	 * @return Account|null product found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getAccountByAccountId(\PDO $pdo, int $accountId) {
		// sanitize the accountId before searching
		if($accountId <= 0) {
			throw(new \PDOException("account id is not account"));
		}

		// create query template
		$query = "SELECT accountId, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountId = :accountId";
		$statement = $pdo->prepare($query);

		// bind the account id to the place holder in the template
		$parameters = array("accountId" => $accountId);
		$statement->execute($parameters);

		// grab the account from mySQL
		try {
			$account = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$account = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($account);
	}







	/**
	 * Gets all the account image id
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of account image id found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllAccountImageIds(\PDO $pdo) {
		// create query template
		$query = "SELECT accountAdmin, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of account image id
		$accountImageIds = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$accountImageId = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
				$accountImageIds[$accountImageIds->key()] = $accountImageId;
				$accountImageIds->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($accountImageIds);
	}


	// -------------------------------------- accountAdmin --------------------------------------
	/**
	 * insert admin flag into mySQL
	 * @param \PDO $pdo - PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insertAdminFlag(\PDO $pdo) {
		// enforce admin flag is null - make sure inserting new flag vs an existing one
		if($this->accountAdmin !== null) {
			throw(new \PDOException("not an admin flag"));
		}

		//create query table
		$query = "INSERT INTO account(accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName) VALUES(:accountImageId, :accountActive, :accountAdmin, :accountName, :accountPpEmail, :accountUserName)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders on the template
		$parameters = ["accountActive" => $this->accountActive, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);

		//update the null accountAdmin with what mySQL just gave us
		$this->accountAdmin = intval($pdo->lastInsertId());
	}

	/**
	 * updates admin flag in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function updateAdminFlag(\PDO $pdo) {

		// enforce the accountAdmin is not null (don't update whats not there)
		if($this->accountAdmin === null) {
			throw(new \PDOException("unable to update accout admin that does not exist"));
		}

		// create query template
		$query = "UPDATE account SET accountAdmin = :accountAdmin WHERE accountAdmin = :accountAdmin";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders
		$parameters = ["accountId" => $this->accountId, "accountActive" => $this->accountActive, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);
	}


	/**
	 * gets the admin flag by account id
	 * @param \PDO $pdo PDO connection object
	 * @param int $accountAdmin - adming flag search for
	 * @param int $accountId - prim key
	 * @return Image|null - flag found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getAccountAdminByAccountId(\PDO $pdo, int $accountId) {
		// sanitize the accountId before searching
		if($accountId <= 0) {
			throw(new \PDOException("account id is not positive"));
		}
		// create query template
		$query = "SELECT accountAdmin, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountId = :accountId";
		$statement = $pdo->prepare($query);

		// bind the account id to the place holder in the template
		$parameters = array("accountId" => $accountId);
		$statement->execute($parameters);

		// grab the flag from mySQL
		try {
			$accountId = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$accountId = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($accountId);
	}

	/**
	 * Gets all teh admin flags
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of admin flags found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllAdminFlags(\PDO $pdo) {
		// create query template
		$query = "SELECT accountAdmin, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of admin flags
		$accountIds = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$accountId = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
				$accountIds[$accountIds->key()] = $accountId;
				$accountIds->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($accountIds);
	}


// ------------------------------------------- accountActive   -------------------------------------------

	/**
	 * insert account status into mySQL
	 * @param \PDO $pdo - PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insertAccountStatus(\PDO $pdo) {
		// enforce account status is null - make sure inserting new flag vs an existing one
		if($this->accountActive !== null) {
			throw(new \PDOException("not an account status"));
		}

		//create query table
		$query = "INSERT INTO account(accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName) VALUES(:accountImageId, :accountActive, :accountAdmin, :accountName, :accountPpEmail, :accountUserName)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders on the template
		$parameters = ["accountActive" => $this->accountActive, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);

		//update the null accountActive with what mySQL just gave us
		$this->accountActive = intval($pdo->lastInsertId());
	}

	/**
	 * updates account status in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function updateAccountStatus(\PDO $pdo) {

		// enforce the accountActive is not null (don't update whats not there)
		if($this->accountActive === null) {
			throw(new \PDOException("unable to update accout admin that does not exist"));
		}

		// create query template
		$query = "UPDATE account SET accountActive = :accountActive WHERE accountActive = :accountActive";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders
		$parameters = ["accountId" => $this->accountId, "accountActive" => $this->accountActive, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);
	}


	/**
	 * gets the account status by account id
	 * @param \PDO $pdo PDO connection object
	 * @param int $accountActive - account status search for
	 * @param int $accountId - prim key
	 * @return Image|null - flag found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getAccountStatusByAccountId(\PDO $pdo, int $accountId) {
		// sanitize the accountId before searching
		if($accountId <= 0) {
			throw(new \PDOException("account id is not positive"));
		}
		// create query template
		$query = "SELECT accountAdmin, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountId = :accountId";
		$statement = $pdo->prepare($query);

		// bind the account id to the place holder in the template
		$parameters = array("accountId" => $accountId);
		$statement->execute($parameters);

		// grab the flag from mySQL
		try {
			$accountId = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$accountId = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($accountId);
	}

	/**
	 * Gets all the account status
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of account status found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllAccountStatuses(\PDO $pdo) {
		// create query template
		$query = "SELECT accountAdmin, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of account status
		$accountActives = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$accountActive = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
				$accountActives[$accountActives->key()] = $accountActive;
				$accountActives->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($accountActives);
	}

// ------------------------------------------- accountName   -------------------------------------------


	/**
	 * insert account name into mySQL
	 * @param \PDO $pdo - PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insertAccountName(\PDO $pdo) {
		// enforce account name is null - make sure inserting new name vs an existing one
		if($this->accountName !== null) {
			throw(new \PDOException("not an account name"));
		}

		//create query table
		$query = "INSERT INTO account(accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName) VALUES(:accountImageId, :accountActive, :accountAdmin, :accountName, :accountPpEmail, :accountUserName)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders on the template
		$parameters = ["accountName" => $this->accountName, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);

		//update the null accountName with what mySQL just gave us
		$this->accountName = intval($pdo->lastInsertId());
	}

	/**
	 * updates account name in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function updateAccountName(\PDO $pdo) {

		// enforce the accountName is not null (don't update whats not there)
		if($this->accountName === null) {
			throw(new \PDOException("unable to update accout name that does not exist"));
		}

		// create query template
		$query = "UPDATE account SET accountName = :accountName WHERE accountName = :accountName";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders
		$parameters = ["accountId" => $this->accountId, "accountActive" => $this->accountActive, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);
	}


	/**
	 * gets the account name by account id
	 * @param \PDO $pdo PDO connection object
	 * @param string $accountName - account name search for
	 * @param int $accountId - prim key
	 * @return string|null - name found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getAccountNameByAccountId(\PDO $pdo, int $accountId) {
		// sanitize the accountId before searching
		if($accountId <= 0) {
			throw(new \PDOException("account id is not positive"));
		}
		// create query template
		$query = "SELECT accountAdmin, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountId = :accountId";
		$statement = $pdo->prepare($query);

		// bind the account id to the place holder in the template
		$parameters = array("accountId" => $accountId);
		$statement->execute($parameters);

		// grab the name from mySQL
		try {
			$accountId = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$accountId = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($accountId);
	}

	/**
	 * Gets all the account name
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of account name found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllAccountNames(\PDO $pdo) {
		// create query template
		$query = "SELECT accountAdmin, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of account name
		$accountNames = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$accountName = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
				$accountNames[$accountNames->key()] = $accountName;
				$accountNames->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($accountNames);
	}

// ------------------------------------------- accountPpEmail   -------------------------------------------

	/**
	 * insert account pay pal email into mySQL
	 * @param \PDO $pdo - PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insertAccountPpEmail(\PDO $pdo) {
		// enforce account pay pal email is null - make sure inserting new account pay pal email vs an existing one
		if($this->accountPpEmail !== null) {
			throw(new \PDOException("not an account pay pal email"));
		}

		//create query table
		$query = "INSERT INTO account(accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName) VALUES(:accountImageId, :accountActive, :accountAdmin, :accountName, :accountPpEmail, :accountUserName)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders on the template
		$parameters = ["accountPpEmail" => $this->accountPpEmail, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);

		//update the null accountPpEmail with what mySQL just gave us
		$this->accountPpEmail = intval($pdo->lastInsertId());
	}

	/**
	 * updates account pay pal email in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function updateAccountPpEmail(\PDO $pdo) {

		// enforce the accountPpEmail is not null (don't update whats not there)
		if($this->accountPpEmail === null) {
			throw(new \PDOException("unable to update accout name that does not exist"));
		}

		// create query template
		$query = "UPDATE account SET accountPpEmail = :accountPpEmail WHERE accountPpEmail = :accountPpEmail";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders
		$parameters = ["accountId" => $this->accountId, "accountActive" => $this->accountActive, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);
	}


	/**
	 * gets the account pay pal email by account id
	 * @param \PDO $pdo PDO connection object
	 * @param string $accountPpEmail - account pay pal email search for
	 * @param int $accountId - prim key
	 * @return string|null - name found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getAccountPpEmailByAccountId(\PDO $pdo, int $accountId) {
		// sanitize the accountId before searching
		if($accountId <= 0) {
			throw(new \PDOException("account id is not positive"));
		}
		// create query template
		$query = "SELECT accountAdmin, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountId = :accountId";
		$statement = $pdo->prepare($query);

		// bind the account id to the place holder in the template
		$parameters = array("accountId" => $accountId);
		$statement->execute($parameters);

		// grab the name from mySQL
		try {
			$accountId = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$accountId = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($accountId);
	}

	/**
	 * Gets all the account pay pal email
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of account pay pal email found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllAccountPpEmails(\PDO $pdo) {
		// create query template
		$query = "SELECT accountAdmin, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of account pay pal email
		$accountPpEmails = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$accountPpEmail = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountPpEmail"], $row["accountPpEmail"], $row["accountUserName"]);
				$accountPpEmails[$accountPpEmails->key()] = $accountPpEmail;
				$accountPpEmails->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($accountPpEmails);
	}

// ------------------------------------------- accountAccountUserName   -------------------------------------------

	/**
	 * insert account user name into mySQL
	 * @param \PDO $pdo - PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insertAccountUserName(\PDO $pdo) {
		// enforce account user name is null - make sure inserting new account user name vs an existing one
		if($this->accountUserName !== null) {
			throw(new \PDOException("not an account user name"));
		}

		//create query table
		$query = "INSERT INTO account(accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName) VALUES(:accountImageId, :accountActive, :accountAdmin, :accountName, :accountPpEmail, :accountUserName)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders on the template
		$parameters = ["accountPpEmail" => $this->accountPpEmail, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);

		//update the null accountUserName with what mySQL just gave us
		$this->accountUserName = intval($pdo->lastInsertId());
	}

	/**
	 * updates account user name in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function updateAccountUserName(\PDO $pdo) {

		// enforce the accountUserName is not null (don't update whats not there)
		if($this->accountUserName === null) {
			throw(new \PDOException("unable to update accout name that does not exist"));
		}

		// create query template
		$query = "UPDATE account SET accountUserName = :accountUserName WHERE accountUserName = :accountUserName";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders
		$parameters = ["accountId" => $this->accountId, "accountActive" => $this->accountActive, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);
	}


	/**
	 * gets the account user name by account id
	 * @param \PDO $pdo PDO connection object
	 * @param string $accountUserName - account user name search for
	 * @param int $accountId - prim key
	 * @return string|null - name found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getAccountUserNameByAccountId(\PDO $pdo, int $accountId) {
		// sanitize the accountId before searching
		if($accountId <= 0) {
			throw(new \PDOException("account id is not positive"));
		}
		// create query template
		$query = "SELECT accountAdmin, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountId = :accountId";
		$statement = $pdo->prepare($query);

		// bind the account id to the place holder in the template
		$parameters = array("accountId" => $accountId);
		$statement->execute($parameters);

		// grab the name from mySQL
		try {
			$accountId = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$accountId = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($accountId);
	}

	/**
	 * Gets all the account user name
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of account user name found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllAccountUserNames(\PDO $pdo) {
		// create query template
		$query = "SELECT accountAdmin, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of account user name
		$accountUserNames = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$accountUserName = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountPpEmail"], $row["accountPpEmail"], $row["accountUserName"]);
				$accountUserNames[$accountUserNames->key()] = $accountUserName;
				$accountUserNames->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($accountUserNames);
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

