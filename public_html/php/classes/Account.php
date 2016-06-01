<?php
namespace Edu\Cnm\CartridgeCoders;

require_once("autoload.php");


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


	// ----------------------------------------   INSERT/UPDATE/DELETE ------------------------------------------
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
	 * Update
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
		$query = "UPDATE account SET accountImageId = :accountImageId, accountActive  = :accountActive, accountAdmin  = :accountAdmin, accountName  = :accountName, accountPpEmail  = :accountPpEmail, accountUserName  = :accountUserName    WHERE accountId = :accountId";

		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders
		$parameters = ["accountId" => $this->accountId, "accountImageId" => $this->accountImageId, "accountActive" => $this->accountActive, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);
	}


	/**
	 * delete
	 * * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function delete(\PDO $pdo) {

		// enforce the accountId is not null (don't delete whats not there)
		if($this->accountId === null) {
			throw(new \PDOException("unable to delete accout id that does not exist"));
		}


		// create query template
		$query = "DELETE FROM account WHERE accountId = :accountId";

		$statement = $pdo->prepare($query);


		// bind the member variables to the place holders
		$parameters = ["accountId" => $this->accountId];
		$statement->execute($parameters);

	}


	// ----------------------------------------  END INSERT/UPDATE/DELETE ------------------------------------------

	//---------------------------------------------------------------------- GET BYs -------------------------------


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
	 * gets the account account by account image id
	 * @param \PDO $pdo PDO connection object
	 * @param int $accountImageId - account image id search for
	 * @param int $accountId - prim key
	 * @return Image|null - id found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getAccountByAccountImageId(\PDO $pdo, int $accountImageId) {
		// sanitize the accountId before searching
		if($accountImageId <= 0) {
			throw(new \PDOException("account image id is not positive"));
		}
		// create query template
		$query = "SELECT accountId, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountImageId = :accountImageId";
		$statement = $pdo->prepare($query);

		// bind the account id to the place holder in the template
		$parameters = array("accountImageId" => $accountImageId);
		$statement->execute($parameters);

		// build an array of accounts
		$accounts = new \SplFixedArray(($statement->rowCount()));
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$account = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
				$accounts[$accounts->key()] = $account;
				$accounts->next();
			} catch
			(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($accounts);
	}


	public static function getAccountByValidAccountActive(\PDO $pdo, int $accountActive) {
		// sanitize the accountId before searching
		if($accountActive <= 0) {
			throw(new \PDOException("account active is not positive"));
		}
		// create query template
		$query = "SELECT accountId, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountActive = :accountActive";
		$statement = $pdo->prepare($query);

		// bind the account active to the place holder in the template
		$parameters = array("accountActive" => $accountActive);
		$statement->execute($parameters);

		// build an array of accounts
		$accounts = new \SplFixedArray(($statement->rowCount()));
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$account = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
				$accounts[$accounts->key()] = $account;
				$accounts->next();
			} catch
			(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($accounts);
	}


	public static function getAccountByValidAccountAdmin(\PDO $pdo, int $accountAdmin) {
		// sanitize the accountId before searching
		if($accountAdmin <= 0) {
			throw(new \PDOException("account admin is not positive"));
		}
		// create query template
		$query = "SELECT accountId, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountAdmin = :accountAdmin";
		$statement = $pdo->prepare($query);

		// bind the account active to the place holder in the template
		$parameters = array("accountAdmin" => $accountAdmin);
		$statement->execute($parameters);

		// build an array of accounts
		$accounts = new \SplFixedArray(($statement->rowCount()));
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$account = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
				$accounts[$accounts->key()] = $account;
				$accounts->next();
			} catch
			(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($accounts);
	}


	public static function getAccountByValidAccountName(\PDO $pdo, string $accountName) {
		// sanitize the description before searching
		$accountName = trim($accountName);
		$accountName = filter_var($accountName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($accountName) === true) {
			throw(new \PDOException("account name is invalid"));
		}

		// create query template
		$query = "SELECT accountId, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountName = :accountName";
		$statement = $pdo->prepare($query);

		// bind the account name to the place holder in the template
		$parameters = array("accountName" => $accountName);
		$statement->execute($parameters);

		// build an array of accounts
		$accounts = new \SplFixedArray(($statement->rowCount()));
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$account = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
				$accounts[$accounts->key()] = $account;
				$accounts->next();
			} catch
			(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($accounts);
	}


	
	
	
	
	
	
	
	public static function getAccountByAccountPpEmail(\PDO $pdo, string $accountPpEmail) {
		// sanitize the description before searching
		$accountPpEmail = trim($accountPpEmail);
		$accountPpEmail = filter_var($accountPpEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($accountPpEmail) === true) {
			throw(new \PDOException("account pp email is invalid"));
		}

		// create query template
		$query = "SELECT accountId, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountPpEmail = :accountPpEmail";
		$statement = $pdo->prepare($query);

		// bind the pp em to the place holder in the template
		$parameters = array("accountPpEmail" => $accountPpEmail);
		$statement->execute($parameters);

		// build an array of accounts
		$accounts = new \SplFixedArray(($statement->rowCount()));
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$account = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
				$accounts[$accounts->key()] = $account;
				$accounts->next();
			} catch
			(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($accounts);
	}


	
	
	
	
	
	
	
	
	public static function getAccountByValidAccountUserName(\PDO $pdo, string $accountUserName) {
		// sanitize the description before searching
		$accountUserName = trim($accountUserName);
		$accountUserName = filter_var($accountUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($accountUserName) === true) {
			throw(new \PDOException("account user name is invalid"));
		}

		// create query template
		$query = "SELECT accountId, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountUserName = :accountUserName";
		$statement = $pdo->prepare($query);

		// bind the user name to the place holder in the template
		$parameters = array("accountUserName" => $accountUserName);
		$statement->execute($parameters);

		// build an array of accounts
		$accounts = new \SplFixedArray(($statement->rowCount()));
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$account = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
				$accounts[$accounts->key()] = $account;
				$accounts->next();
			} catch
			(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($accounts);
	}

//-------------------------------------------------------------- END GET BYs -------------------------------
	// ------------------------------------------------------ GET ALL ---------------------------------

	/**
	 * get all accounts
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Products found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllAccounts(\PDO $pdo) {
		// create query template
		$query = "SELECT accountId, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of accounts
		$accounts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$account = new Account($row["accountId"], $row["accountImageId"], $row["accountActive"], $row["accountAdmin"], $row["accountName"], $row["accountPpEmail"], $row["accountUserName"]);
				$accounts[$accounts->key()] = $account;
				$accounts->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($accounts);
	}

	// ------------------------------------------------------ END GET ALL ---------------------------------


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

