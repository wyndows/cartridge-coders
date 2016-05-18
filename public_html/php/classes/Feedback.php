<?php

namespace Edu\Cnm\CartridgeCoders;
// require_once ("autoload.php);
use MongoDB\Driver\Exception\UnexpectedValueException;

/**
 * Feedback class for cartridge coders so account may submit feedback on one another
 * @author Elliot Murrey <emurrey@cnm.edu>
 **/
class Feedback implements \JsonSerializable {
	/**
	 * the id of the feedback, this will be the primary key
	 * @var int $feedbackId
	 **/
	private $feedbackId;
	/**
	 * id for the person submitting the feedback
	 * @var int $feedbackSenderId
	 */
	Private $feedbackSenderId;
	/**
	 * id for the product that transaction was about
	 * @var int $feedbackProductId
	 **/
	private $feedbackProductId;
	/**
	 * id for the person getting the feedback
	 * @var int $feedbackRecipientId
	 **/
	private $feedbackRecipientId;
	/**
	 * content of the feedback that is being submitted
	 * @var string $feedbackContent
	 **/
	private $feedbackContent;
	/**
	 * rating of the recipient of the feedback
	 * @var int $feedbackRating
	 **/
	private $feedbackRating;

	/**
	 * constructor for the feedbackRating
	 *
	 * @param int $newFeedbackId new feedback id
	 * @param int $newFeedbackSenderId new sender id
	 * @param int $newFeedbackProductId new product id
	 * @param int $newFeedbackRecipientId new feedback recipient
	 * @param string $newFeedbackContent new feedback content
	 * @param int $newFeedbackRating new feedback id
	 * @throws \UnexpectedValueException if any of hte parameters are invalid
	 * @throws \RangeException if not an it
	 * @throws \TypeError if data violates type hints
	 **/
	public function __construct(int $newFeedbackId = null, int $newFeedbackSenderId, int $newFeedbackProductId, int $newFeedbackRecipientId, string $newFeedbackContent, int $newFeedbackRating) {
		try {
			$this->setFeedbackId($newFeedbackId);
			$this->setFeedbackSenderId($newFeedbackSenderId);
			$this->setFeedbackProductId($newFeedbackProductId);
			$this->setFeedbackRecipientId($newFeedbackRecipientId);
			$this->setFeedbackContent($newFeedbackContent);
			$this->setFeedbackRating($newFeedbackRating);
		} catch(\TypeError($typeError) {
			//rethrow the exception to the caller
			throw(new\TypeError($typeError->getFeedback(), 0, $typeError));
		} catch(\UnexpectedValueException $exception) {
			// rethrow to the caller
			throw(new \UnexpectedValueException("unable to contruct Feedback",0, $exception));

		}
		)
	}


	/**
	 * accessor method for feedback id
	 *
	 * @return int value of feedback id
	 **/
	public function getFeedbackId() {
		return ($this->feedbackId);
	}

	/**
	 * mutator method for feedbackId id
	 * @param int $newFeedbackId
	 * @throws \RangeException if the $newFeedbackId is not positive
	 * @throws \UnexpectedValueException if $newFeedbackId is not an integer
	 **/
	public function setFeedbackId($newFeedbackId) {
		if($newFeedbackId === null) {
			$this->feedbackId = null;
			return;
		}
		$newFeedbackId = filter_var($newFeedbackId, FILTER_VALIDATE_INT);
		if($newFeedbackId === false) {
			throw(new \UnexpectedValueException("feedback id is not valid"));
		}
		// confirm feedback id is positive
		if($newFeedbackId <= 0) {
			throw(new \RangeException("no no no feedback id is not valid"));
		}
		// convert and store the feedback id
		$this->feedbackId = intval($newFeedbackId);
	}
	/**
	 * accessor method for feedbackSender id
	 *
	 * @return int value of feedbackSender id
	 **/
	public function getFeedbackSenderId() {
		return ($this->feedbackSenderId);
	}

	/**
	 * mutator method for feedbackSender id
	 * @param int $newFeedbackSenderId new value of feedbackSender id
	 * @throws \UnexpectedValueException if $newFeedbackSenderId is not an integer
	 * @throws \RangeException if $newFeedbackSenderId is not positive
	 **/
	public function setFeedbackSenderId($newFeedbackSenderId) {
		$newFeedbackSenderId = filter_var($newFeedbackSenderId, FILTER_VALIDATE_INT);
		if($newFeedbackSenderId === false) {
			throw(new \UnexpectedValueException("SenderId is not a valid integer"));
		}
		// convert and store the Account id
		$this->feedbackSenderId = intval($newFeedbackSenderId);
	}

	/**
	 * accessor method for product id
	 *
	 * @return int value of product id
	 **/
	public function getFeedbackProductId() {
		return ($this->feedbackProductId);
	}

	/**
	 * mutator method for product id
	 * @param int $newFeedbackProductId new value of product id 
	 * @throws \UnexpectedValueException if $newFeedbackProductId is not a valid integer
	 * @throws \RangeException if the $newFeedbackProductId is not positive
	 **/
	public function setFeedbackProductId($newFeedbackProductId) {
		$newFeedbackProductId = filter_var($newFeedbackProductId, FILTER_VALIDATE_INT);
		if($newFeedbackProductId === false) {
			throw(new \UnexpectedValueException("productId is not a valid integer"));
		}
		// confirm product id is positive
		if($newFeedbackProductId <=0) {
			throw(new \unexpectedValueException("product id is not positive"));
		}
		// covert and store the product id
		$this->feedbackProductId = intval($newFeedbackProductId);
	}

	/**
	 * accessor method for feedbackRecipientId
	 *
	 * @return int value of recipient id
	 **/
	public function getFeedbackRecipientId() {
		return ($this->feedbackRecipientId);
	}

	/**
	 * mutator method for feedbackRecipientId 
	 * @param int $newFeedbackRecipientId new value of feedbackRecipientId
	 * @throws \UnexpectedValueException if $newFeedbackRecipientId is not an integer
	 * @throws \RangeException if the $newFeedbackRecipientId is not positive 
	 **/
	public function setFeedbackRecipientId($newFeedbackRecipientId) {
		$newFeedbackRecipientId = filter_var($newFeedbackRecipientId, FILTER_VALIDATE_INT);
		if($newFeedbackRecipientId === false) {
			throw(new \UnexpectedValueException("Feedback RecipientId is not a valid integer"));
		}
		// confirm the feedbackRecipientId is positive
		if($newFeedbackRecipientId <= 0) {
			throw(new \RangeException("feedbackRecipientIdis not positive"));
		}
		// covert and store the account id
		$this->feedbackRecipientId = intval($newFeedbackRecipientId);
	}
	/**
	 * accessor for feedbackContent
	 *
	 * @return string value of message content
	 **/
	public function getFeedbackContent() {
		return ($this->feedbackContent);
	}

	/**
	 * mutator method for feedbackContent
	 *
	 * @param string $newFeedbackContent new value of feedback content
	 * @throws \UnexpectedValueException if $newMessageContent is not valid
	 * @throws \RangeException if the $newMessageContent exceeds varv 255
	 **/
	public function setFeedbackContent($newFeedbackContent) {
		// verify the message content is valid
		$newFeedbackContent = filter_var($newFeedbackContent, FILTER_SANITIZE_STRING);
		if($newFeedbackContent === false) {
			throw(new \UnexpectedValueException("feedback content is not valid"));
		}
		if($newFeedbackContent > 255) {
			// confirm feedbackContent doesn't exceed 255
			throw(new \RangeException("feedback is way to long "));
		}
		// store the feedbackContent
		$this->feedbackContent = $newFeedbackContent;
	}

	/**
	 * accessor for feedbackRating
	 *
	 * @return int value of Feedback rating
	 **/
	public function getFeedbackRating() {
		return ($this->feedbackContent);
	}

	/**
	 * mutator method for feedback rating
	 *
	 * @param int $newFeedbackRating new value of feedback rating
	 * @throws \UnexpectedValueException if $newFeedbackRating is not a valid int
	 * @throws \RangeException if $newFeedbackRating is not positive
	 * @throws \RangeException if $newFeedbackRating is about 5
	 **/
	public function setFeedbackRating(int $newFeedbackRating) {
		// verify the feedbackRating is positve and not too high
		if($newFeedbackRating < 1) {
			throw(new \RangeException("please select a ratting between 1 and 5"));
		}
		if($newFeedbackRating > 5) {
			throw(new \RangeException("please select a ratting between 1 and 5"));
		}

		// convert and store the feedback rating
		$this->feedbackRating = $newFeedbackRating;
	}

}