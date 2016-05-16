<?php

/**
 * Formulating plan for unit testing of Account class
 *
 * Class will consist of:
 *   accountId
 *   accountImageId
 *   accountActive
 *   accountAdmin
 *   accountName
 *   accountPpEmail
 *   accountUserName
 *
 * Primary key will be:
 *   accountId
 *
 * Foreign Keys:
 *   accountImageId
 *
 * Testing will be on:
 *   insertAccount
 *   updateAccount
 *   deleteAccount
 *   getAccountByAccountId
 *   getAccountByAccountImageId
 *   getAccountByAccountActive
 *   getAccountByAccountAdmin
 *   getAccountByAccountName
 *   getAccountByAccountUserName
 *   getAllAccounts
 *
 * Testing will consist of the following:
 *   test inserting a valid Account id and verify that the actual mySQL data matches
 *   test inserting a Account that already exists
 *   test inserting an invalid account id
 *   test inserting an invalid image id
 *   test inserting a Account, editing Account Active, and then updating it
 *   test inserting a Account, editing Account Admin, and then updating it
 *   test inserting a Account, editing Account Name, and then updating it
 *   test inserting a Account, editing Account PpEmail, and then updating it
 *   test inserting a Account, editing Account User Name, and then updating it
 *   test inserting a Account, editing Account Title, and then updating it
 *   test updating a Account that already exists
 *   test creating a Account and then deleting it
 *   test deleting a Account that does not exist
 *   test grabbing a Account by account id
 *   test grabbing a Account by account id
 *   test grabbing a Account by image id
 *   test grabbing a Account by active
 *   test grabbing a Account by account admin
 *   test grabbing a Account by account name
 *   test grabbing a Account by account pp email
 *   test grabbing a Account by account user name
 *   test grabbing a Account by account title
 *   test grabbing a Account with Account Id that does not exist
 *   test grabbing a Account with Account Id that does not exist
 *   test grabbing a Account with Image Id that does not exist
 *   test grabbing a Account with active that does not exist
 *   test grabbing a Account with account admin that does not exist
 *   test grabbing a Account with account name that does not exist
 *   test grabbing a Account with account pp email that does not exist
 *   test grabbing a Account with account user name that does not exist
 *   test grabbing a Account with account title that does not exist
 *   test grabbing all Accounts
 *
 * @author Donald DeLeeuw based on code by Marlan Ball <wyndows@earthlink.net> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 */

namespace Edu\Cnm\CartridgeCoders\Test;

use Edu\Cnm\CartridgeCoders\Account;
use Edu\Cnm\CartridgeCoders\Image;


// grab the project test parameters
require_once("CartridgeCodersTest.php");

// grab the class under scrutiny
require_once("../php/classes/autoload.php");



/**
 * Unit testing for the Account class for Cartridge Coders
 *
 * @see Account
 **/
class AccountTest extends CartridgeCodersTest {
	/**
	 * content of the Account
	 * @var int $VALID_ACCOUNTACTIVE
	 **/
	protected $VALID_ACCOUNTACTIVE = 1;
	/**
	 * content of the Account
	 * @var tinyint $VALID_ACCOUNTACTIVE2
	 **/
	protected $VALID_ACCOUNTACTIVE2 = 0;
	/**
	 * content of the Account
	 * @var tinyint $VALID_ACCOUNTADMIN
	 **/
	protected $VALID_ACCOUNTADMIN = 1;
	/**
	 * content of the Account
	 * @var tinyint $VALID_ACCOUNTADMIN2
	 **/
	protected $VALID_ACCOUNTADMIN2 = 0;
	/**
	 * content of the Account
	 * @var string $VALID_ACCOUNTNAME
	 **/
	protected $VALID_ACCOUNTNAME = "account name one";
	/**
	 * content of the Account
	 * @var string $VALID_ACCOUNTNAME2
	 **/
	protected $VALID_ACCOUNTNAME2 = "account name two";
	/**
	 * content of the Account
	 * @var string $VALID_ACCOUNTPPEMAIL
	 **/
	protected $VALID_ACCOUNTPPEMAIL = "pp@email.one";
	/**
	 * content of the Account
	 * @var string $VALID_ACCOUNTPPEMAIL2
	 **/
	protected $VALID_ACCOUNTPPEMAIL2 = "pp@email.two";
	/**
	 * content of the Account
	 * @var string $VALID_ACCOUNTUSERNAME
	 **/
	protected $VALID_ACCOUNTUSERNAME = "myusername1";
	/**
	 * content of the Account
	 * @var string $VALID_ACCOUNTUSERNAME2
	 **/
	protected $VALID_ACCOUNTUSERNAME2 = "myusername2";

	/**
* content of the Account
* @var tinyint $imgeId
**/
	protected $imageId = null;

	/**
	 * Account
	 * @var int $accountId
	 **/

	protected $accountId = null;


	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert an Image to own the test account
		$this->image = new Image(null, "filename", "image/jpg");
		$this->image->insert($this->getPDO());

	}


	/**
	 * test inserting a valid Account and verify that the actual mySQL data matches
	 **/
	public function testInsertValidAccountId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new account and insert into mySQL
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAccount = Account::getAccountByAccountId($this->getPDO(), $account->getAccountId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertEquals($pdoAccount->getAccountId(), $this->account->getAccountId());
		$this->assertEquals($pdoAccount->getAccountImageId(), $this->image->getImageId());
		$this->assertEquals($pdoAccount->getAccountActive(), $this->VALID_ACCOUNTACTIVE);
		$this->assertEquals($pdoAccount->getAccountAdmin(), $this->VALID_ACCOUNTADMIN);
		$this->assertEquals($pdoAccount->getAccountName(), $this->VALID_ACCOUNTNAME);
		$this->assertEquals($pdoAccount->getAccountPpEmail(), $this->VALID_ACCOUNTPPEMAIL);
		$this->assertEquals($pdoAccount->getAccountUserName(), $this->VALID_ACCOUNTUSERNAME);
	}




	/**
	 * test inserting a Account that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidAccountId() {
		// create a Account with a non null image id and watch it fail
		$account = new Account(CartridgeCodersTest::INVALID_KEY, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());
	}

	/**
	 * test inserting an invalid image id
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidImageId() {
		// create a Account with an invalid account id and watch it fail
		$account = new Account(null, CartridgeCodersTest::INVALID_KEY, $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());
	}


	/**
	 * test inserting a Account, editing Active, and then updating it
	 **/
	public function testUpdateValidAccountActive() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new Account and insert into mySQL
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());

		// edit the Account Active and update it in mySQL
		$account->setAccountActive($this->VALID_ACCOUNTACTIVE2);
		$account->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAccount = Account::getAccountByAccountId($this->getPDO(), $account->getAccountId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertEquals($pdoAccount->getAccountId(), $this->account->getAccountId());
		$this->assertEquals($pdoAccount->getAccountImageId(), $this->image->getImageId());
		$this->assertEquals($pdoAccount->getAccountActive(), $this->VALID_ACCOUNTACTIVE2);
		$this->assertEquals($pdoAccount->getAccountAdmin(), $this->VALID_ACCOUNTADMIN);
		$this->assertEquals($pdoAccount->getAccountName(), $this->VALID_ACCOUNTNAME);
		$this->assertEquals($pdoAccount->getAccountPpEmail(), $this->VALID_ACCOUNTPPEMAIL);
		$this->assertEquals($pdoAccount->getAccountUserName(), $this->VALID_ACCOUNTUSERNAME);
	}

	/**
	 * test inserting a Account, editing Account Admin, and then updating it
	 **/
	public function testUpdateValidAccountAdmin() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new Account and insert into mySQL
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());

		// edit the Account Admin and update it in mySQL
		$account->setAccountAdmin($this->VALID_ACCOUNTADMIN2);
		$account->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAccount = Account::getAccountByAccountId($this->getPDO(), $account->getAccountId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertEquals($pdoAccount->getAccountId(), $this->account->getAccountId());
		$this->assertEquals($pdoAccount->getAccountImageId(), $this->image->getImageId());
		$this->assertEquals($pdoAccount->getAccountActive(), $this->VALID_ACCOUNTACTIVE);
		$this->assertEquals($pdoAccount->getAccountAdmin(), $this->VALID_ACCOUNTADMIN2);
		$this->assertEquals($pdoAccount->getAccountName(), $this->VALID_ACCOUNTNAME);
		$this->assertEquals($pdoAccount->getAccountPpEmail(), $this->VALID_ACCOUNTPPEMAIL);
		$this->assertEquals($pdoAccount->getAccountUserName(), $this->VALID_ACCOUNTUSERNAME);
	}


	/**
	 * test inserting a Account, editing Account Name, and then updating it
	 **/
	public function testUpdateValidAccountName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new Account and insert into mySQL
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());

		// edit the Account Name and update it in mySQL
		$account->setAccountName($this->VALID_ACCOUNTNAME2);
		$account->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAccount = Account::getAccountByAccountId($this->getPDO(), $account->getAccountId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertEquals($pdoAccount->getAccountId(), $this->account->getAccountId());
		$this->assertEquals($pdoAccount->getAccountImageId(), $this->image->getImageId());
		$this->assertEquals($pdoAccount->getAccountActive(), $this->VALID_ACCOUNTACTIVE);
		$this->assertEquals($pdoAccount->getAccountAdmin(), $this->VALID_ACCOUNTADMIN);
		$this->assertEquals($pdoAccount->getAccountName(), $this->VALID_ACCOUNTNAME2);
		$this->assertEquals($pdoAccount->getAccountPpEmail(), $this->VALID_ACCOUNTPPEMAIL);
		$this->assertEquals($pdoAccount->getAccountUserName(), $this->VALID_ACCOUNTUSERNAME);
	}

	/**
	 * test inserting a Account, editing Account PpEmail, and then updating it
	 **/
	public function testUpdateValidAccountPpEmail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new Account and insert into mySQL
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());

		// edit the Account PpEmail and update it in mySQL
		$account->setAccountPpEmail($this->VALID_ACCOUNTPPEMAIL2);
		$account->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAccount = Account::getAccountByAccountId($this->getPDO(), $account->getAccountId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertEquals($pdoAccount->getAccountId(), $this->account->getAccountId());
		$this->assertEquals($pdoAccount->getAccountImageId(), $this->image->getImageId());
		$this->assertEquals($pdoAccount->getAccountActive(), $this->VALID_ACCOUNTACTIVE);
		$this->assertEquals($pdoAccount->getAccountAdmin(), $this->VALID_ACCOUNTADMIN);
		$this->assertEquals($pdoAccount->getAccountName(), $this->VALID_ACCOUNTNAME);
		$this->assertEquals($pdoAccount->getAccountPpEmail(), $this->VALID_ACCOUNTPPEMAIL2);
		$this->assertEquals($pdoAccount->getAccountUserName(), $this->VALID_ACCOUNTUSERNAME);
	}

	/**
	 * test inserting a Account, editing Account User Name, and then updating it
	 **/
	public function testUpdateValidAccountUserName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new Account and insert into mySQL
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());

		// edit the Account User Name and update it in mySQL
		$account->setAccountUserName($this->VALID_ACCOUNTUSERNAME2);
		$account->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAccount = Account::getAccountByAccountId($this->getPDO(), $account->getAccountId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertEquals($pdoAccount->getAccountId(), $this->account->getAccountId());
		$this->assertEquals($pdoAccount->getAccountImageId(), $this->image->getImageId());
		$this->assertEquals($pdoAccount->getAccountActive(), $this->VALID_ACCOUNTACTIVE);
		$this->assertEquals($pdoAccount->getAccountAdmin(), $this->VALID_ACCOUNTADMIN);
		$this->assertEquals($pdoAccount->getAccountName(), $this->VALID_ACCOUNTNAME);
		$this->assertEquals($pdoAccount->getAccountPpEmail(), $this->VALID_ACCOUNTPPEMAIL);
		$this->assertEquals($pdoAccount->getAccountUserName(), $this->VALID_ACCOUNTUSERNAME2);
	}

	/**
	 * test updating a Account that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidAccount() {
		// create a Account with a non null image id and watch it fail
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->update($this->getPDO());
	}


	/**
	 * test creating a Account and then deleting it
	 **/
	public function testDeleteValidAccount() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new Account and insert into mySQL
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());

		// delete the Account from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$account->delete($this->getPDO());

		// grab the data from mySQL and enforce the Account does not exist
		$pdoAccount = Account::getAccountByAccountId($this->getPDO(), $account->getAccountId());
		$this->assertNull($pdoAccount);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("account"));
	}

	/**
	 * test deleting a Account that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidAccount() {
		// create a Account and try to delete it without actually inserting it
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->delete($this->getPDO());
	}

	/**
	 * test grabbing a Account with Account Id that does not exist
	 **/
	public function testGetAccountByInvalidAccountId() {
		// grab a account id that exceeds the maximum allowable account id
		$account = Account::getAccountByAccountId($this->getPDO(), CartridgeCodersTest::INVALID_KEY);
		$this->assertNull($account);
	}

	/**
	 * test grabbing a Account with Account Id that does not exist
	 **/
	public function testGetAccountByInvalidImageId() {
		// grab an account id that exceeds the maximum allowable account id
		$account = Account::getAccountByAccountImageId($this->getPDO(), CartridgeCodersTest::INVALID_KEY);
		$this->assertCount(0, $account);
	}

	/**
	 * test grabbing a Account with Image Id that does not exist
	 **/
	public function testGetInvalidAccountByAccountImageId() {
		// grab an image id that exceeds the maximum allowable image id
		$account = Account::getAccountByAccountImageId($this->getPDO(), CartridgeCodersTest::INVALID_KEY);
		$this->assertCount(0, $account);
	}

	/**
	 * test grabbing a Account by active that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testGetAccountByInvalidAccountActive() {
		// grab a account by searching for active that does not exist
		$account = Account::getAccountByAccountActive($this->getPDO(), 1);
		$this->assertCount(0, $account);
	}

	/**
	 * test grabbing a Account by account admin that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testGetAccountByInvalidAccountAdmin() {
		// grab a account by searching for admin that does not exist
		$account = Account::getAccountByAccountAdmin($this->getPDO(), "");
		$this->assertCount(0, $account);
	}

	/**
	 * test grabbing a Account by account name that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testGetAccountByInvalidAccountName() {
		// grab a account by searching for name that does not exist
		$account = Account::getAccountByAccountName($this->getPDO(), -1);
		$this->assertCount(0, $account);
	}

	/**
	 * test grabbing a Account by account pp email that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testGetAccountByInvalidAccountPpEmail() {
		// grab a account by searching for pp email that does not exist
		$account = Account::getAccountByAccountPpEmail($this->getPDO(), -1);
		$this->assertCount(0, $account);
	}

	/**
	 * test grabbing a Account by account user name that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testGetAccountByInvalidAccountUserName() {
		// grab a account by searching for user name that does not exist
		$account = Account::getAccountByAccountUserName($this->getPDO(), -1);
		$this->assertCount(0, $account);
	}

	/**
	 * test grabbing a Account by account account id
	 **/
	public function testGetAccountByValidAccountAccountId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new Account and insert into mySQL
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Account::getAccountByAccountImageId($this->getPDO(), $account->getAccountImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Account", $results);

		// grab the result from the array and validate it
		$pdoAccount = $results[0];
		$this->assertEquals($pdoAccount->getAccountId(), $this->account->getAccountId());
		$this->assertEquals($pdoAccount->getAccountImageId(), $this->image->getImageId());
		$this->assertEquals($pdoAccount->getAccountActive(), $this->VALID_ACCOUNTACTIVE);
		$this->assertEquals($pdoAccount->getAccountAdmin(), $this->VALID_ACCOUNTADMIN);
		$this->assertEquals($pdoAccount->getAccountName(), $this->VALID_ACCOUNTNAME);
		$this->assertEquals($pdoAccount->getAccountPpEmail(), $this->VALID_ACCOUNTPPEMAIL);
		$this->assertEquals($pdoAccount->getAccountUserName(), $this->VALID_ACCOUNTUSERNAME);
	}

	/**
	 * test grabbing a Account by account image id
	 **/
	public function testGetAccountByValidAccountImageId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new Account and insert into mySQL
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());

			// grab the data from mySQL and enforce the fields match our expectations
			$results = Account::getAccountByAccountImageId($this->getPDO(), $account->getAccountImageId());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
			$this->assertCount(1, $results);
			$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Account", $results);

			// grab the result from the array and validate it
			$pdoAccount = $results[0];
			$this->assertEquals($pdoAccount->getAccountId(), $this->account->getAccountId());
			$this->assertEquals($pdoAccount->getAccountImageId(), $this->image->getImageId());
			$this->assertEquals($pdoAccount->getAccountActive(), $this->VALID_ACCOUNTACTIVE);
			$this->assertEquals($pdoAccount->getAccountAdmin(), $this->VALID_ACCOUNTADMIN);
			$this->assertEquals($pdoAccount->getAccountName(), $this->VALID_ACCOUNTNAME);
			$this->assertEquals($pdoAccount->getAccountPpEmail(), $this->VALID_ACCOUNTPPEMAIL);
			$this->assertEquals($pdoAccount->getAccountUserName(), $this->VALID_ACCOUNTUSERNAME);
		}

	/**
	 * test grabbing a Account by account active
	 **/
	public function testGetAccountByValidAccountActive() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new Account and insert into mySQL
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Account::getAccountByAccountActive($this->getPDO(), $account->getAccountActive());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Account", $results);

		// grab the result from the array and validate it
		$pdoAccount = $results[0];
		$this->assertEquals($pdoAccount->getAccountId(), $this->account->getAccountId());
		$this->assertEquals($pdoAccount->getAccountImageId(), $this->image->getImageId());
		$this->assertEquals($pdoAccount->getAccountActive(), $this->VALID_ACCOUNTACTIVE);
		$this->assertEquals($pdoAccount->getAccountAdmin(), $this->VALID_ACCOUNTADMIN);
		$this->assertEquals($pdoAccount->getAccountName(), $this->VALID_ACCOUNTNAME);
		$this->assertEquals($pdoAccount->getAccountPpEmail(), $this->VALID_ACCOUNTPPEMAIL);
		$this->assertEquals($pdoAccount->getAccountUserName(), $this->VALID_ACCOUNTUSERNAME);
	}

	/**
	 * test grabbing a Account by account admin
	 **/
	public function testGetAccountByValidAccountAdmin() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new Account and insert into mySQL
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Account::getAccountByAccountAdmin($this->getPDO(), $account->getAccountAdmin());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Account", $results);

		// grab the result from the array and validate it
		$pdoAccount = $results[0];
		$this->assertEquals($pdoAccount->getAccountId(), $this->account->getAccountId());
		$this->assertEquals($pdoAccount->getAccountImageId(), $this->image->getImageId());
		$this->assertEquals($pdoAccount->getAccountActive(), $this->VALID_ACCOUNTACTIVE);
		$this->assertEquals($pdoAccount->getAccountAdmin(), $this->VALID_ACCOUNTADMIN);
		$this->assertEquals($pdoAccount->getAccountName(), $this->VALID_ACCOUNTNAME);
		$this->assertEquals($pdoAccount->getAccountPpEmail(), $this->VALID_ACCOUNTPPEMAIL);
		$this->assertEquals($pdoAccount->getAccountUserName(), $this->VALID_ACCOUNTUSERNAME);
	}

	/**
	 * test grabbing a Account by account name
	 **/
	public function testGetAccountByValidAccountName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new Account and insert into mySQL
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Account::getAccountByAccountName($this->getPDO(), $account->getAccountName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Account", $results);

		// grab the result from the array and validate it
		$pdoAccount = $results[0];
		$this->assertEquals($pdoAccount->getAccountId(), $this->account->getAccountId());
		$this->assertEquals($pdoAccount->getAccountImageId(), $this->image->getImageId());
		$this->assertEquals($pdoAccount->getAccountActive(), $this->VALID_ACCOUNTACTIVE);
		$this->assertEquals($pdoAccount->getAccountAdmin(), $this->VALID_ACCOUNTADMIN);
		$this->assertEquals($pdoAccount->getAccountName(), $this->VALID_ACCOUNTNAME);
		$this->assertEquals($pdoAccount->getAccountPpEmail(), $this->VALID_ACCOUNTPPEMAIL);
		$this->assertEquals($pdoAccount->getAccountUserName(), $this->VALID_ACCOUNTUSERNAME);
	}

	/**
	 * test grabbing a Account by account pp email
	 **/
	public function testGetAccountByValidAccountPpEmail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new Account and insert into mySQL
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Account::getAccountByAccountPpEmail($this->getPDO(), $account->getAccountPpEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Account", $results);

		// grab the result from the array and validate it
		$pdoAccount = $results[0];
		$this->assertEquals($pdoAccount->getAccountId(), $this->account->getAccountId());
		$this->assertEquals($pdoAccount->getAccountImageId(), $this->image->getImageId());
		$this->assertEquals($pdoAccount->getAccountActive(), $this->VALID_ACCOUNTACTIVE);
		$this->assertEquals($pdoAccount->getAccountAdmin(), $this->VALID_ACCOUNTADMIN);
		$this->assertEquals($pdoAccount->getAccountName(), $this->VALID_ACCOUNTNAME);
		$this->assertEquals($pdoAccount->getAccountPpEmail(), $this->VALID_ACCOUNTPPEMAIL);
		$this->assertEquals($pdoAccount->getAccountUserName(), $this->VALID_ACCOUNTUSERNAME);
	}

	/**
	 * test grabbing a Account by account user name
	 **/
	public function testGetAccountByValidAccountUserName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new Account and insert into mySQL
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Account::getAccountByAccountUserName($this->getPDO(), $account->getAccountUserName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Account", $results);

		// grab the result from the array and validate it
		$pdoAccount = $results[0];
		$this->assertEquals($pdoAccount->getAccountId(), $this->account->getAccountId());
		$this->assertEquals($pdoAccount->getAccountImageId(), $this->image->getImageId());
		$this->assertEquals($pdoAccount->getAccountActive(), $this->VALID_ACCOUNTACTIVE);
		$this->assertEquals($pdoAccount->getAccountAdmin(), $this->VALID_ACCOUNTADMIN);
		$this->assertEquals($pdoAccount->getAccountName(), $this->VALID_ACCOUNTNAME);
		$this->assertEquals($pdoAccount->getAccountPpEmail(), $this->VALID_ACCOUNTPPEMAIL);
		$this->assertEquals($pdoAccount->getAccountUserName(), $this->VALID_ACCOUNTUSERNAME);
	}


	/**
	 * test grabbing all Accounts
	 **/
	public function testGetAllValidAccounts() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new Account and insert into mySQL
		$account = new Account(null, $this->image->getImageId(), $this->VALID_ACCOUNTACTIVE, $this->VALID_ACCOUNTADMIN, $this->VALID_ACCOUNTNAME, $this->VALID_ACCOUNTPPEMAIL, $this->VALID_ACCOUNTUSERNAME);
		$account->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Account::getAllAccounts($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Account", $results);

		// grab the result from the array and validate it
		$pdoAccount = $results[0];
		$this->assertEquals($pdoAccount->getAccountId(), $this->account->getAccountId());
		$this->assertEquals($pdoAccount->getAccountImageId(), $this->image->getImageId());
		$this->assertEquals($pdoAccount->getAccountActive(), $this->VALID_ACCOUNTACTIVE);
		$this->assertEquals($pdoAccount->getAccountAdmin(), $this->VALID_ACCOUNTADMIN);
		$this->assertEquals($pdoAccount->getAccountName(), $this->VALID_ACCOUNTNAME);
		$this->assertEquals($pdoAccount->getAccountPpEmail(), $this->VALID_ACCOUNTPPEMAIL);
		$this->assertEquals($pdoAccount->getAccountUserName(), $this->VALID_ACCOUNTUSERNAME);
	}

}

?>


