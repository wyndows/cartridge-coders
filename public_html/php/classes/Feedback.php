<?php

namespace Edu\Cnm\CartridgeCoders;
// require_once ("autoload.php);

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
	 **/
	private $feedbackRecipientId;
	/**
	 * content of the feedback that is being submitted
	 * @var string $feedbackContent
	 **/
	private $feedbackContent;
	/**
	 * rating of the recipient of the feedback
	 **/
	private $feedbackRating;

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
		
	}
}