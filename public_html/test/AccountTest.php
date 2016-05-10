<?php

/**
 * Formulating plan for unit testing of account class
 *
 * Class will consist of;
 * int|null AccountId - id of account or null if new account - primary key
 * int|null AccountImageId - id of image - this is a foreign key
 * int|null AccountActive - flag for account active
 * int|null AccountAdmin - flag for account admin
 * string AccountName - user's name
 * string AccountPpEmail - user's paypal email address
 * string AccountUserName - user's chosen user name
 *
 * Testing will be on;
 *
 *
 * 
 * insert (x1)
 * update
 * delete
 * get by attribute
 * get all (x1)
 *
 * 
 * 
 * 
 * Testing will consist of;
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 *
 * @author Donald DeLeeuw <donald.deleeuw@gmail.com> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 */

namespace Edu\Cnm\CartridgeCoders\Test;

use Edu\Cnm\CartridgeCoders\Account;

// grab  the project test parameters
require_once("CartridgeCodersTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "../php/classes/autoload.php");

/**
 * Unit testing for the account class for Cartridge Coders
 * @see Account
 */
class AccountTest extends CartridgeCodersTest {

	/**
	 *content of the accountId
	 * @var int $accountId
	 */
	private $accountId;


	/**
	 *content of the accountImageId
	 * @var int $AccountImageId
	 */
	private $imageId;


	/**
	 *content of the accountActive
	 * @var tinyint $accountActive
	 */
	private $accountActive;

	/**
	 *content of the accountAdmin
	 * @var tinyint $accountAdmin
	 */
	private $accountAdmin;


	/**
	 *content of the accountName
	 * @var string $accountName
	 */
	private $accountName;

	/**
	 *content of the accountPpEmail
	 * @var string $accountPpEmail
	 */
	private $accountPpEmail;


	/**
	 *content of the accountUserName
	 * @var string $accountUserName
	 */
	private $accountUserName;


// ------------------------------------------- AccountId -------------------------------------------

	/**
	 * insert AccountId into mySQL
	 * @param \PDO $pdo - PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insertAccountId(\PDO $pdo) {
		// enforce AccountId is null - make sure inserting new vs an existing one
		if($this->accountId !== null) {
			throw(new \PDOException("not an account id"));
		}

		//create query table
		$query = "INSERT INTO account(accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName) VALUES(:accountImageId, :accountActive, :accountAdmin, :accountName, :accountPpEmail, :accountUserName)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders on the template
		$parameters = ["accountImageId" => $this->accountImageId, "accountActive" => $this->accountActive, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);

		//update the null accountId with what mySQL just gave us
		$this->accountId = intval($pdo->lastInsertId());
	}

	/**
	 * updates AccountId in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function updateAccountId(\PDO $pdo) {

		// enforce the AccountId is not null (don't update whats not there)
		if($this->accountId === null) {
			throw(new \PDOException("unable to update account id that does not exist"));
		}

		// create query template
		$query = "UPDATE account SET accountId = :accountId WHERE accountId = :accountId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders
		$parameters = ["accountId" => $this->accountId, "accountImageId" => $this->accountImageId, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);
	}


	/**
	 * test creating a AccountId and then deleting it
	 **/
	public function testDeleteAccountId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new AccountId and insert into mySQL
		$account = new Account(null, $this->AccountId);
		$account->insert($this->getPDO());

		// delete the AccountId from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$account->delete($this->getPDO());

		// grab the data from mySQL and enforce that the AccountId does not exist
		$pdoAccount = Account::getAccountIdByAccountId($this->getPDO(), $account->getAccountId());
		$this->assertNull($pdoAccountId);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("account"));
	}

	/**
	 * gets the AccountId by account id
	 * @param \PDO $pdo PDO connection object
	 * @param int $accountId - account id search for
	 * @param int $accountId - prim key
	 * @return int|null - id found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getAccountIdByAccountId(\PDO $pdo, int $accountId) {
		// sanitize the accountId before searching
		if($accountId <= 0) {
			throw(new \PDOException("account id is not positive"));
		}
		// create query template
		$query = "SELECT accountId, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountId = :accountId";
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
	 * Gets all the account ids
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of account id found or null if not found
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

// ------------------------------------------- AccountImageId -------------------------------------------

	/**
	 * updates AccountImageId in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function updateAccountImageId(\PDO $pdo) {

		// enforce the AccountImageId is not null (don't update whats not there)
		if($this->accountImageId === null) {
			throw(new \PDOException("unable to update account image id that does not exist"));
		}

		// create query template
		$query = "UPDATE account SET accountImageId = :accountImageId WHERE accountImageId = :accountImageId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders
		$parameters = ["accountId" => $this->accountId, "accountImageId" => $this->accountImageId, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);
	}


	/**
	 * test creating a AccountImageId and then deleting it
	 **/
	public function testDeleteAccountImageId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new AccountImageId and insert into mySQL
		$account = new Account(null, $this->AccountImageId);
		$account->insert($this->getPDO());

		// delete the AccountImageId from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$account->delete($this->getPDO());

		// grab the data from mySQL and enforce that the AccountImageId does not exist
		$pdoAccount = Account::getAccountImageIdByAccountImageId($this->getPDO(), $account->getAccountImageId());
		$this->assertNull($pdoAccountImageId);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("account"));
	}

	/**
	 * gets the AccountImageId by account image id
	 * @param \PDO $pdo PDO connection object
	 * @param int $accountImageId - account image id search for
	 * @param int $accountId - prim key
	 * @return int|null - id found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getAccountImageIdByAccountId(\PDO $pdo, int $accountId) {
		// sanitize the accountId before searching
		if($accountId <= 0) {
			throw(new \PDOException("account id is not positive"));
		}
		// create query template
		$query = "SELECT accountId, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountId = :accountId";
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


// ------------------------------------------- AccountActive -------------------------------------------

	/**
	 * updates AccountActive in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function updateAccountActive(\PDO $pdo) {

		// enforce the AccountActive is not null (don't update whats not there)
		if($this->accountActive === null) {
			throw(new \PDOException("unable to update account active that does not exist"));
		}

		// create query template
		$query = "UPDATE account SET accountActive = :accountActive WHERE accountActive = :accountActive";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders
		$parameters = ["accountId" => $this->accountId, "accountImageId" => $this->accountImageId, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);
	}


	/**
	 * test creating a AccountActive and then deleting it
	 **/
	public function testDeleteAccountActive() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new AccountActive and insert into mySQL
		$account = new Account(null, $this->AccountActive);
		$account->insert($this->getPDO());

		// delete the AccountActive from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$account->delete($this->getPDO());

		// grab the data from mySQL and enforce that the AccountActive does not exist
		$pdoAccount = Account::getAccountActiveByAccountActive($this->getPDO(), $account->getAccountActive());
		$this->assertNull($pdoAccountActive);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("account"));
	}

	/**
	 * gets the AccountActive by account id
	 * @param \PDO $pdo PDO connection object
	 * @param int $accountActive - account active search for
	 * @param int $accountId - prim key
	 * @return int|null - id found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getAccountActiveByAccountId(\PDO $pdo, int $accountId) {
		// sanitize the accountId before searching
		if($accountId <= 0) {
			throw(new \PDOException("account id is not positive"));
		}
		// create query template
		$query = "SELECT accountId, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountId = :accountId";
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


// ------------------------------------------- AccountName -------------------------------------------

	/**
	 * updates AccountName in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function updateAccountName(\PDO $pdo) {

		// enforce the AccountName is not null (don't update whats not there)
		if($this->accountName === null) {
			throw(new \PDOException("unable to update account name that does not exist"));
		}

		// create query template
		$query = "UPDATE account SET accountName = :accountName WHERE accountName = :accountName";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders
		$parameters = ["accountId" => $this->accountId, "accountImageId" => $this->accountImageId, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);
	}


	/**
	 * test creating a AccountName and then deleting it
	 **/
	public function testDeleteAccountName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new AccountName and insert into mySQL
		$account = new Account(null, $this->AccountName);
		$account->insert($this->getPDO());

		// delete the AccountName from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$account->delete($this->getPDO());

		// grab the data from mySQL and enforce that the AccountName does not exist
		$pdoAccount = Account::getAccountNameByAccountName($this->getPDO(), $account->getAccountName());
		$this->assertNull($pdoAccountName);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("account"));
	}

	/**
	 * gets the AccountName by account id
	 * @param \PDO $pdo PDO connection object
	 * @param int $accountName - account name search for
	 * @param int $accountId - prim key
	 * @return int|null - id found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getAccountNameByAccountId(\PDO $pdo, int $accountId) {
		// sanitize the accountId before searching
		if($accountId <= 0) {
			throw(new \PDOException("account id is not positive"));
		}
		// create query template
		$query = "SELECT accountId, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountId = :accountId";
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


// ------------------------------------------- AccountPpEmail -------------------------------------------

	/**
	 * updates AccountPpEmail in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function updateAccountPpEmail(\PDO $pdo) {

		// enforce the AccountPpEmail is not null (don't update whats not there)
		if($this->accountPpEmail === null) {
			throw(new \PDOException("unable to update account pay pal email that does not exist"));
		}

		// create query template
		$query = "UPDATE account SET accountPpEmail = :accountPpEmail WHERE accountPpEmail = :accountPpEmail";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders
		$parameters = ["accountId" => $this->accountId, "accountImageId" => $this->accountImageId, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);
	}


	/**
	 * test creating a AccountPpEmail and then deleting it
	 **/
	public function testDeleteAccountPpEmail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new AccountPpEmail and insert into mySQL
		$account = new Account(null, $this->AccountPpEmail);
		$account->insert($this->getPDO());

		// delete the AccountPpEmail from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$account->delete($this->getPDO());

		// grab the data from mySQL and enforce that the AccountPpEmail does not exist
		$pdoAccount = Account::getAccountPpEmailByAccountPpEmail($this->getPDO(), $account->getAccountPpEmail());
		$this->assertNull($pdoAccountPpEmail);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("account"));
	}

	/**
	 * gets the AccountPpEmail by account id
	 * @param \PDO $pdo PDO connection object
	 * @param int $accountPpEmail - account pay pal email search for
	 * @param int $accountId - prim key
	 * @return int|null - id found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getAccountPpEmailByAccountId(\PDO $pdo, int $accountId) {
		// sanitize the accountId before searching
		if($accountId <= 0) {
			throw(new \PDOException("account id is not positive"));
		}
		// create query template
		$query = "SELECT accountId, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountId = :accountId";
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


// ------------------------------------------- AccountUserName -------------------------------------------

	/**
	 * updates AccountUserName in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function updateAccountUserName(\PDO $pdo) {

		// enforce the AccountUserName is not null (don't update whats not there)
		if($this->accountUserName === null) {
			throw(new \PDOException("unable to update account user name that does not exist"));
		}

		// create query template
		$query = "UPDATE account SET accountUserName = :accountUserName WHERE accountUserName = :accountUserName";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders
		$parameters = ["accountId" => $this->accountId, "accountImageId" => $this->accountImageId, "accountAdmin" => $this->accountAdmin, "accountName" => $this->accountName, "accountPpEmail" => $this->accountPpEmail, "accountUserName" => $this->accountUserName];
		$statement->execute($parameters);
	}


	/**
	 * test creating a AccountUserName and then deleting it
	 **/
	public function testDeleteAccountUserName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new AccountUserName and insert into mySQL
		$account = new Account(null, $this->AccountUserName);
		$account->insert($this->getPDO());

		// delete the AccountUserName from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$account->delete($this->getPDO());

		// grab the data from mySQL and enforce that the AccountUserName does not exist
		$pdoAccount = Account::getAccountUserNameByAccountUserName($this->getPDO(), $account->getAccountUserName());
		$this->assertNull($pdoAccountUserName);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("account"));
	}

	/**
	 * gets the AccountUserName by account id
	 * @param \PDO $pdo PDO connection object
	 * @param int $accountUserName - account user name search for
	 * @param int $accountId - prim key
	 * @return int|null - id found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getAccountUserNameByAccountId(\PDO $pdo, int $accountId) {
		// sanitize the accountId before searching
		if($accountId <= 0) {
			throw(new \PDOException("account id is not positive"));
		}
		// create query template
		$query = "SELECT accountId, accountImageId, accountActive, accountAdmin, accountName, accountPpEmail, accountUserName FROM account WHERE accountId = :accountId";
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

}


?>

