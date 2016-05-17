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
	 * @param int $newF
	 **/
}