<?php
namespace Edu\Cnm\CartridgeCoders;

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
	 * @var int $accountActive
	 */
	private $accountActive;

	/** id for account admin
	 * @var int $accountAdmin
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
	public function __construct(int $newAccountId = null, int $newAccountImageId = null, int $newAccountActive = null, int $newAccountAdmin = null, string $newAccountName, string $newAccountPpEmail, string $newAccountUserName) {
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
	public function accountImageId(int $newAccountImageId = null) {
		//if account image id is null (composing), allow new account image id without mySQL assignment
		if($newAccountImageId === null) {
			$this->accountImageId = null;
			return;
		}
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
	public function accountActive(int $newAccountActive = null) {
		//if account active flag is null (composing), allow new account without mySQL assignment
		if($newAccountActive === null) {
			$this->accountActive = null;
			return;
		}
		// verify account active flag is positive
		if($newAccountActive <= 0) {
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
	public function accountAdmin(int $newAccountAdmin = null) {
		//if account admin flag is null (composing), allow new admin without mySQL assignment
		if($newAccountAdmin === null) {
			$this->accountAdmin = null;
			return;
		}
		// verify account admin flag is positive
		if($newAccountAdmin <= 0) {
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







	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}

}

