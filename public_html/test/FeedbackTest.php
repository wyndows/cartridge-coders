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
	 * @var string $VALID_MESSAGECONTENT
	 **/
	protected $VALID_FEEDBACKCONTENT = "yay lets go again";
	/**
	 * rating given by the person submitting the feedback
	 * @var int $VALID_FEEDBACKRATING
	 **/
	protected $VALID_FEEDBACKRATING = 1
	/**
	 * Account that submitted the feedback this is a foreign key relations
	 * @var Account sender
	 **/
	protected $feedbackSenderId = null;
	/**
	 * product that the feeback is about
	 * @var Product productId
	 **/
	protected $feedbackProductid = null;
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
	}

}