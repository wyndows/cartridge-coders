<?php
/**
 * plan for unit testing Message class
 *
 * Message class will contain messageId, messageBuyerId, messageProductId, messageSellerId, messageContent, messageMailGunId, and messageSubjectId
 *
 * tesing will be attempted on the following.
 * inserting a valid Message and verify that the mySQL data matches
 * inserting a Message , changing it and updating it
 * test grabbing a message by message id
 * test updating a message that already exists
 *
 **/


namespace Edu\Cnm\CartridgeCoders\Test;

use Edu\Cnm\CartridgeCoders\{Message,Product,AccountId};

// grab the project test parameters
require_once("cartridgeCodersTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Message class
 *
 * This is a complete PHPUnit test of the Message class. Hopefully it passes, we're going to test both valid and invalid inputes
 *
 * @see Message
 * @author Elliot Murrey <emurrey@cnm.edu>
 **/
class MessageTest extends CartridgeCodersTest {
	/**
	 * content of the Message
	 * @var int $VALID_MESSAGECONTENT
	 **/
	protected $VALID_MESSAGECONTENT = "PHPUnit test Passing";
	/**
	 * this is the messages MailGunId
	 * @var string $VALID_MESSAGEMAILGUNID
	 **/
	protected $VALID_MESSAGEMAILGUNID = "I don't even know";
	/**
	 * this is the subject of the message
	 * @var string $VALID_MESSAGESUBJECT
	 **/
	protected $VALID_MESSAGESUBJECT = "PHPUnit test passing";
	/**
	 * Account that created this message this is for foreign key relations
	 * @var Account account
	 **/
	protected $account = null;
	/**
	 * Account that is responding to said created message
	 * @var Account2 account
	 **/
	protected $account2 = null;
	/**
	 * product that message is about
	 * @var Product product
	 **/
	protected $product = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUP() {
		// run the default setUp() method first
		parent::setUP();

		// create and insert an account to write the test Message
		$this->account = new Account(null, "10", "1", "0", "JamesDean", "JamesDean@gmail.com", "coolguy");
		$this->account->insert($this->getPDO());

		// create and insert an account to be the reciever of the test Message
		$this->account2 = new Account(null, "16", "1", "0", "JessicaJones", "JessicaJones@gmail.com", "hotgirl");
		$this->account2->insert($this->getPDO());

		// create and insert a product into hte test Message
		$this->product = new Product(null, "2", "116", "2.22", "coolItem", "22.22", "3.00", "0", "LegendOfZelda");
		$this->product->insert($this->getPdo());
	}

	/**
	 * test inserting a valid Message and verify that the actual mySQL data matches
	 **/
	public function testInsertValidMessage() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("message");

		//create a new Message and insert to into mySQL
		$message = new Message(null, $this->account->getAccountId(), $this->product->getProductId(), $this->account2->getAccountId2(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEMAILGUNID, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoMessage = Message::getMessageByMessageId($this->getPDO(), $message->getMessageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Message"));
		$this->assertEquals($pdoMessage->getAccountId(), $this->account->getAccountId());
		$this->assertEquals($pdoMessage->getProductId(), $this->product->getProductId());
		$this->assertEquals($pdoMessage->getAccountId(), $this->account2->getAccountId());
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageMailGunId(), $this->VALID_MAILGUNID());
		$this->assertEquals($pdoMessage->getMessageSubject(), $this->VALID_MESSAGESUBJECT);
	}
	/**
	 *test inserting a Message that already exists
	 *
	 * @expectedException \PDOException
	 *
	 **/
	public function testInsertInvalidMessage() {
		//create a Message with a non null Message id and watch it fail
		$message = new Message(CartridgeCodersTest::INVALID_KEY, $this->account->getAccountId(), $this->product->getProductId(), $this->account2->getAccountId2(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEMAILGUNID, $this->VALID_MESSAGESUBJECT);
		$messgage->insert($this->getPDO());
	}
	/**
	 * test inserting a Message and regrabbing it from mySQL
	 **/
	public function testGetValidMessageByMessageId() {
		// count the nunber of rows and save it for later
		$numRows = new Message(null, $this->account->getAccountId(), $this->product->getProductId(), $this->account2->getAccountId2(), $this->VALID_MESSAGECONENT, $this->VALID_MESSAGEMAILGUNID, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());

		//grab the data from mySQl and enforce the fields match our expectations
		$pdoMessage = Message::getMessageByMessageId($this->getPDO(), $Message->getMessageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertEquals($pdoMessage->getAccountId(), $this->account->getAccountID());
		$this->assertEquals($pdoMessage->getProductId(), $this->product->getProductId());
		$this->assertEquals($pdoMessage->getAccountID(), $this->account2->getAaccountId());
		$this->assertEquals($pdoMessage->getMessageContecnt(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageMailGunId(), $this->VALID_MESSAGEMAILGUNID());
		$this->assertEquals($pdoMessage->getMessageSubject(), $this->VALID_MESSAGESUBJECT);
	}

	/**
	 * test grabbing a Message that does not exist
	 **/
	public function testGetInvalidMessageByMessageId() {
		//grab an account id that exceeds the maximum allowable account id
		$message = Message::getMessageByMessageId($this->getPDO(), CartridgeCodersTest::INVALID_KEY);
		$this->assertNull($Message);
	}

	/**
	 * test grabbing a Message by message Subject
	 **/
	public function testGetMessageByMessageSubject() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("message");

		// create a new Message and insert to into mySQL
		$message = new Message(null, $this->account->getAccountId(), $this->product->getProductId(), $this->account2->getAccountId2(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEMAILGUNID, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());

		//grab the data from the mySQL and enforce the fields match our expectations
		$results = Message::getMessageByMessageSubject($this->getPDO(), $message->getMessageSubject());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertcount(1, $results);
		$this->assertcountainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Message", $results);

		//grab the result from the array and validate it
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getAccountId(), $this->account->getAccountID());
		$this->assertEquals($pdoMessage->getProductId(), $this->product->getProductId());
		$this->assertEquals($pdoMessage->getAccountID(), $this->account2->getAaccountId());
		$this->assertEquals($pdoMessage->getMessageContecnt(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageMailGunId(), $this->VALID_MESSAGEMAILGUNID());
		$this->assertEquals($pdoMessage->getMessageSubject(), $this->VALID_MESSAGESUBJECT);
	}

	/**
	 * test grabbing a Message by message content
	 **/
	public function testGetMessageByMessageSubject() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("message");

		// create a new Message and insert to into mySQL
		$message = new Message(null, $this->account->getAccountId(), $this->product->getProductId(), $this->account2->getAccountId2(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEMAILGUNID, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());

		//grab the data from the mySQL and enforce the fields match our expectations
		$results = Message::getMessageByMessageContent($this->getPDO(), $message->getMessageSubject());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertcount(1, $results);
		$this->assertcountainsOnlyInstancesOf("Edu\\Cnm\\CartridgeCoders\\Message", $results);

		//grab the result from the array and validate it
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getAccountId(), $this->account->getAccountID());
		$this->assertEquals($pdoMessage->getProductId(), $this->product->getProductId());
		$this->assertEquals($pdoMessage->getAccountID(), $this->account2->getAaccountId());
		$this->assertEquals($pdoMessage->getMessageContecnt(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageMailGunId(), $this->VALID_MESSAGEMAILGUNID());
		$this->assertEquals($pdoMessage->getMessageSubject(), $this->VALID_MESSAGESUBJECT);
}
	/**
	 * test grabbing a messaage by content that does not exist
	 **/
	public function testGetInvalidMessageByMessageConent() {
		// grab a Message by searching for content that does not exist
		$message = Message::getMessageByMessageContent($this->getPDO(),"you've got nothing and now I have your nose");
		$this->assertCount(0, $message);
	}

	/**
	 * test grabbing all Messages
	 **/
	public function testGetAllValidMessages() {
		//count the number of row ans save it for later
		$numRows = $this->getConnection()->getRowCount("message");

		//create a new Message and insert to into mySQL
		$message = new Message(null, $this->account->getAccountId(), $this->product->getProductId(), $this->account2->getAccountId2(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEMAILGUNID, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Message::getAllMessages($this->getPDO());
		$this->assertEquals($numbrows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertCount(1, $results);
		$this->assertCountainsOnlyInstancesOf("Edu\\Cnm]]Cartridge-coders\\", $results);

		//grab the result from the array and validate it
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getAccountId(), $this->account->getAccountID());
		$this->assertEquals($pdoMessage->getProductId(), $this->product->getProductId());
		$this->assertEquals($pdoMessage->getAccountID(), $this->account2->getAaccountId());
		$this->assertEquals($pdoMessage->getMessageContecnt(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageMailGunId(), $this->VALID_MESSAGEMAILGUNID());
		$this->assertEquals($pdoMessage->getMessageSubject(), $this->VALID_MESSAGESUBJECT);
	}
}