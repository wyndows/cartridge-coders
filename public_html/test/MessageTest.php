<?php
/**
 * plan for unit testing Message class
 *
 * Message class will contain messageId, messageSenderId, messageProductId, messageSellerId, messageContent, messageMailGunId, and messageSubjectId
 *
 * tesing will be attempted on the following.
 * inserting a valid Message and verify that the mySQL data matches
 * inserting an invalid message and watching it fail
 * test grabbing a message by message id
 * test inserting a message and regrabbing it 
 * test searching for message by party id 
 * test serching for message by invalid party
 *
 **/


namespace Edu\Cnm\CartridgeCoders\Test;
use Edu\Cnm\CartridgeCoders\{Message,Product,Account,Image};

// grab the project test parameters
require_once("CartridgeCodersTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Message class
 *
 * This is a complete PHPUnit test of the Message class. Hopefully it passes, we're going to test both valid and invalid inputs
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
	 * @var Account sender
	 **/
	protected $messageSenderId = null;
	/**
	 * Account that will recieve this message this is for foreign key relations
	 * @var Account receiver
	 **/
	protected $messageRecipientId = null;
	/**
	 * product that message is about
	 * @var Product productId
	 **/
	protected $messageProductId = null;
	/**
	 * image for account
	 * @var Image image
	 **/
	protected $imageId = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUP() {
		// run the default setUp() method first
		parent::setUp();
		// create and insert an account to write the test Message
		$this->image = new Image(null, "fileName", "image/jpg");
		$this->imageId->insert($this->getPDO());

		// create and insert an account to write the test Message
		$this->messageSenderId = new Account(null, $this->imageId->getImageId(), "1", "0", "JamesDean", "JamesDean@gmail.com", "coolguy");
		$this->messageSenderId->insert($this->getPDO());

		// create and insert an Account to own this test Message
		$this->messageRecipientId = new Account(null, $this->imageId->getImageId(), "1", "0", "JessicaJones", "JessicaJones@gmail.com", "hotgirl");
		$this->messageRecipientId->insert($this->getPDO());

		// create and insert a product into the test Message
		$this->messageProductId = new Product(null, $this->messageSenderId->getAccountId(), $this->imageId->getImageId(), "2.22", "coolItem", "22.22", "3.00", "0", "LegendOfZelda");
		$this->messageProductId->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Message and verify that the actual mySQL data matches
	 **/
	public function testInsertValidMessage() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("message");

		//create a new Message and insert to into mySQL
		$message = new Message(null, $this->messageSenderId->getAccountId(), $this->messageProductId->getProductId(), $this->messageRecipientId->getAccountId(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEMAILGUNID, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoMessage = Message::getMessageByMessageId($this->getPDO(), $message->getMessageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Message"));
		$this->assertEquals($pdoMessage->getAccountId(), $this->sender->getAccountId());
		$this->assertEquals($pdoMessage->getProductId(), $this->product->getProductId());
		$this->assertEquals($pdoMessage->getAccountId(), $this->recipient->getAccountId());
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageMailGunId(), $this->VALID_MESSAGEMAILGUNID());
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
		$message = new Message(CartridgeCodersTest::INVALID_KEY, $this->sender->getAccountId(), $this->product->getProductId(), $this->recipient->getAccountId(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEMAILGUNID, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());
	}


	/**
	 * test inserting a Message and regrabbing it from mySQL
	 **/
	public function testGetValidMessageByMessageId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("message");

			//create a new Message and insert to into mySQL
		$message= new Message(null, $this->sender->getAccountId(), $this->product->getProductId(), $this->recipient->getAccountId(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEMAILGUNID, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());

		//grab the data from mySQl and enforce the fields match our expectations
		$pdoMessage = Message::getMessageByMessageId($this->getPDO(), $message->getMessageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertEquals($pdoMessage->getSenderId(), $this->sender->getAccountId());
		$this->assertEquals($pdoMessage->getProductId(), $this->product->getProductId());
		$this->assertEquals($pdoMessage->getRecipientId(), $this->recipient->getAacountId());
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
		$this->assertNull($message);
	}

	/**
	 * test getting message by party id
	 **/
	public function testGetValidMessageByPartyId(){
		// count the number of rows and save it for later
		$nubRows = $this->getConnection()->getRowCount("message");

		// create a new message and insert to into mySQL
		$message = new Message(null, $this->sender->getAccountId(), $this->product->getProductId(), $this->recipient->getAccountId(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEMAILGUNID, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Message::getMessageByPartyId($this->getPDO(), $message->getMessageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\CNM\\CartridgeCoders\\Message", $results);

		// grab the result from the array and validate it
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getSenderId(), $this->sender->getAccountId());
		$this->assertEquals($pdoMessage->getProductId(), $this->product->getProductId());
		$this->assertEquals($pdoMessage->getRecipientId(), $this->recipient->getAccountId());
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageMailGunId(), $this->VALID_MESSAGEMAILGUNID());
		$this->assertEquals($pdoMessage->getMessageSubject(), $this->VALID_MESSAGESUBJECT());
	}
	/**
	 * test grabbing a Message by party id that does not exist
	 **/
	public function testGetInvalidMessageByPartyId() {
		// grab a message by search for party id that does not exist
		$message = Message::getMessageByPartyId($this->getPDO(), CartridgeCodersTest::INVALID_KEY);
		$this->assertNull($message);
	}
}