<?php
/**
 * tdd unit test for Feedback class
 *
 * Feedback class will contain feedbackId, feedbackSenderId, feedbackProductId, feedbackRecipientId, feedbackContent, feedbackRating
 *
 * testing will be tried on the following
 * inserting a valid Feedback and verify that the mySQL data matches
 * inserting invalid feedback and watching if fail like donald trump
 * test grabbing feedback by feedbackId
 * test inserting feedback and re-grabbing it
 * test searching for feedback by party id
 * test searching for feedback on party id by invalid party id
 *
 **/


namespace Edu\Cnm\CartridgeCoders\test;
use Edu\Cnm\CartridgeCoders\{Feedback,Product,Account,Image};

// grab the project from test parameters
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Feedback Class
 *
 * this is a complete PHPUnit test of the Feedback class. we're going to test both valid and invalid
 *
 * @see Feedback
 * @author Elliot Murrey <emurrey@cnm.edu>
 **/
class FeedbackTest extends CartridgeCodersTest {
	/**
	 * content of the feedback
	 * @var string $VALID_FEEDBACKCONTENT
	 **/
	protected $VALID_FEEDBACKCONTENT = "yay lets go";
	/**
	 * content of the updated feedback
	 * @var String $VALID_FEEDBACKCONTENT2
	 **/
	protected $VALID_FEEDBACKCONTENT2 = "yay still passing in yo face donald trump";
	/**
	 * rating given by the person submitting the feedback
	 * @var int $VALID_FEEDBACKRATING
	 **/
	protected $VALID_FEEDBACKRATING = 1;
	/**
	 * Account that submitted the feedback this is a foreign key relations
	 * @var Account sender
	 **/
	protected $feedbackSenderId = null;
	/**
	 * product that the feeback is about
	 * @var Product productId
	 **/
	protected $feedbackProductId = null;
	/**
	 * Account that the feedback is on
	 * @var account receiver
	 **/
	protected $feedbackRecipientId = null;
	/**
	 * image for account
	 * @var Image image
	 **/
	protected $image = null;
	/**
	 * account for hte messageSenderId and messageRecipientId
	 * @var Account accountId
	 **/
	protected $account= null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();
		// create and insert an account image for the test Feedback
		$this->image = new Image(null, "fileName", "image/jpg");
		$this->insert($this->getPDO());

		// create and insert an account to write the test Feedback
		$this->feedbackSenderId = new Account(null, $this->image->getImageId(), "1", "0", "JamesDean", "JamesDean@gmail.com", "coolguy");
		$this->feedbackSenderId->insert($this->getPDO());

		// create and insert a product into the test Feedback
		$this->feedbackProductId = new Product(null, $this->feedbackSenderId->getAccountId(), $this->image->getImageId(), "2.22", "coolItem", "22.22", "3.00", "0", "LegendOfZelda");
		$this->feedbackProductId->insert($this->getPDO());

		// create and insert and account the feedback is on
		$this->feedbackRecipientId = new Account(null, $this->image->getImageId(), "1", "0", "JessicaJones", "JessicaJones@gmail.com", "hotgirl");
		$this->feedbackRecipientId->insert($this->getPDO());
	}

	/**
	 * test inserting valid Feedback and verify that the actual mySQL data matches
	 **/
	public function testInsertValidFeedback() {
		// count the number of rows and save it for later
		$nubRows = $this->getConnection()->getRowCount("feedback");

		// create a new Feedback and insert to into mySQL
		$feedback = new Feedback(null, $this->feedbackSenderId->getAccountId(), $this->feedbackProductId->getProductId(), $this->feedbackRecipientId->getAccountId(), $this->VALID_FEEDBACKCONTENT, $this->VALID_FEEDBACKRATING);
		$feedback->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match out expectations
		$pdoFeedback = Feedback::getFeedbackByFeedbackId($this->getPDO(), $feedback->getFeedbackId());
		$this->assertEquals($numRows + 1, $this->getConnectiong()->getRowCount("feedback"));
		$this->assertEquals($pdoFeedback->getFeedbackSenderId(), $this->feedbackSenderId->getAccountId());
		$this->assertEquals($pdoFeedback->getFeedbackProductId(), $this->feedbackProductId->getProductId());
		$this->assertEquals($pdoFeedback->getFeedbackRecipientid(), $this->feedbackRecipientId->getAccountId());
		$this->assertEquals($pdoFeedback->getFeedbackContent(), $this->VALID_FEEDBACKCONTENT);
		$this->assertEquals($pdoFeedback->getFeedbackRating(), $this->VALID_FEEDBACKRATING);
	}

	/**
	 * test inserting Feedback that already exists
	 *
	 * @exectedException \PDOException
	 **/
	public function testInsertInvalidFeedback() {
		// create a Feedback with a non null Feedback id and watch it fail
		$feedback = new Feedback(CartridgeCodersTest::INVALID_KEY, $this->feedbackSenderId->getAccountId(), $this->feedbackProductId->getProductId(), $this->feedbackRecipientId->getAccountId(), $this->VALID_FEEDBACKCONTENT, $this->VALID_FEEDBACKRATING);
		$feedback->insert($this->getPDO());
	}

	/**
	 * test inserting Feedback, editing it, and then updating it
	 *
	 **/
	public function testUpdateValidFeedback() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("feedback");

		//create a new Feedback and insert to into mySQL
		$feedback = new Feedback(null, $this->feedbackSenderId->getAccountId(), $this->feedbackProductId->getProductId(), $this->feedbackRecipientId->getAccountId(), $this->VALID_FEEDBACKCONTENT, $this->VALID_FEEDBACKRATING);
		$feedback->insert($this->getPDO());

		// edit the Feedback and update it in mySQL
		$feedback->setFeedbackContent($this->VALID_FEEDBACKCONTENT2);
		$feedback->updated($this->getPDO());

		// grab the data from mySQl and enforce the fields match our expectations
		$pdoFeedback = Feedback::getFeedbackByFeedbackId($this->getPDO(), $feedback->getFeedbackId());
		$this->assertEquals($numRows + 1, $this->getConnectiong()->getRowCount("feedback"));
		$this->assertEquals($pdoFeedback->getFeedbackSenderId(), $this->feedbackSenderId->getAccountId());
		$this->assertEquals($pdoFeedback->getFeedbackProductId(), $this->feedbackProductId->getProductId());
		$this->assertEquals($pdoFeedback->getFeedbackRecipientid(), $this->feedbackRecipientId->getAccountId());
		$this->assertEquals($pdoFeedback->getFeedbackContent(), $this->VALID_FEEDBACKCONTENT2);
		$this->assertEquals($pdoFeedback->getFeedbackRating(), $this->VALID_FEEDBACKRATING);
	}
	/**
	 * test creating feedback then deleting it
	 **/
	public function testDeleteValidFeedback() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("feedback");

		// create a new feedback and insert to into mySQL
		$feedback = new Feedback(null, $this->feedbackSenderId->getAccountId(), $this->feedbackProductId->getProductId(), $this->feedbackRecipientId->getAccountId(), $this->VALID_FEEDBACKCONTENT, $this->VALID_FEEDBACKRATING);

	}
}