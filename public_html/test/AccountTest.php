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
	public function testDeleteVAccountId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new AccountId and insert into mySQL
		$category = new Account(null, $this->AccountId);
		$category->insert($this->getPDO());

		// delete the AccountId from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$category->delete($this->getPDO());

		// grab the data from mySQL and enforce that the AccountId does not exist
		$pdoCategory = Category::getAccountIdByAccountId($this->getPDO(), $account->getAccountId());
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
	public function testDeleteVAccountImageId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new AccountImageId and insert into mySQL
		$category = new Account(null, $this->AccountImageId);
		$category->insert($this->getPDO());

		// delete the AccountImageId from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$category->delete($this->getPDO());

		// grab the data from mySQL and enforce that the AccountImageId does not exist
		$pdoCategory = Category::getAccountImageIdByAccountImageId($this->getPDO(), $account->getAccountImageId());
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
	public function testDeleteVAccountActive() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new AccountActive and insert into mySQL
		$category = new Account(null, $this->AccountActive);
		$category->insert($this->getPDO());

		// delete the AccountActive from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$category->delete($this->getPDO());

		// grab the data from mySQL and enforce that the AccountActive does not exist
		$pdoCategory = Category::getAccountActiveByAccountActive($this->getPDO(), $account->getAccountActive());
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







//* 		 DONE		int|null AccountId - id of account or null if new account - primary key
//* 		 DONE		int|null AccountImageId - id of image - this is a foreign key
//* 		 DONE		int|null AccountActive - flag for account active
//* int|null AccountAdmin - flag for account admin
//* string AccountName - user's name
//* string AccountPpEmail - user's paypal email address
//* string AccountUserName - user's chosen user name

// *
// * insert (x1)
// * update
// * delete
// * get by attribute
// * get all (x1)

}





?>

