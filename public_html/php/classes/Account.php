<?php
namespace Edu\Cnm\CartridgeCoders;

/**
 * class for Account
 * @author Donald DeLeeuw <donald.deleeuw> based on code by Dylan McDonald <dmcdonad21@cnm.edu>
 */

class Account implements \JsonSerializable{

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
	 * 
	 */



}

