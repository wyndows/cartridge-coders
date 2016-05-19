<?php

namespace Edu\Cnm\CartridgeCoders;
require_once ("autoload.php");

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
		} catch(\TypeError $typeError) {
			//rethrow the exception to the caller
			throw(new\TypeError($typeError->getFeedback(), 0, $typeError));
		} catch(\UnexpectedValueException $exception) {
			// rethrow to the caller
			throw(new \UnexpectedValueException("unable to contruct Feedback", 0, $exception));
		} catch(\RangeException $range) {
			// rethrow the exception tot he caller
			throw(new \RangeException($range->getFeedback(), 0, $range));
		}
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
	public function setFeedbackId(int $newFeedbackId = null) {
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
	public function setFeedbackSenderId(int $newFeedbackSenderId) {
		if($newFeedbackSenderId <= 0) {
			throw(new \RangeException("feedback recipient id is not positive"));
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
	public function setFeedbackProductId(int $newFeedbackProductId) {
		if($newFeedbackProductId <= 0) {
			throw(new \RangeException("feedback product id is not positive"));
		}
		// confirm product id is positive
		if($newFeedbackProductId <= 0) {
			throw(new \UnexpectedValueException("product id is not positive"));
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
	public function setFeedbackRecipientId(int $newFeedbackRecipientId) {
		if($newFeedbackRecipientId <= 0) {
			throw(new \RangeException("feedback recipient id is not positive"));
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
	public function setFeedbackContent(string $newFeedbackContent) {
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
		return ($this->feedbackRating);
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

	/**
	 * insert feedback into mySQL
	 *
	 * @param \PDO $pdo - PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 * @throws \RangeException if $pdo is to high or too low
	 */
	public function insert(\PDO $pdo) {
		// enforce feedback id is null - make sure we're inserting new Feedback
		if($this->feedbackId !== null) {
			throw(new \PDOException("not new Feedback"));
		}

		// create a query template
		$query = "INSERT INTO feedback(feedbackSenderId, feedbackProductId, feedbackRecipientId, feedbackContent, feedbackRating) VALUES(:feedbackSenderId, :feedbackProductId, :feedbackRecipientId, :feedbackContent, :feedbackRating)";
		$statement = $pdo->prepare($query);

		//bind the member variable to the place holder in the template
		$parameters = ["feedbackSenderId" => $this->feedbackSenderId, "feedbackProductId" => $this->feedbackProductId, "feedbackRecipientId" => $this->feedbackRecipientId, "feedbackContent" => $this->feedbackContent, "feedbackRating" => $this->feedbackRating];
		$statement->execute($parameters);

		// update teh null feedbackId with what mySQl jast gave us
		$this->feedbackId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes the Feedback from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connectino object
	 **/
	public function delete(\PDO $pdo) {
		// enforce the feedbackId is not null (i.e., don't delete a feedback that hasn't been inserted
		if($this->feedbackId === null) {
			throw(new \PDOException("unable to delete feedback that does not exist"));
		}

		// create query template
		$query = "DELETE FROM feedback WHERE feedbackId = :feedbackId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the tempalate
		$parameters = ["feedbackId" => $this->feedbackId];
		$statement->execute($parameters);
	}

	/**
	 * updates this Feedback in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQl related error occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) {
		// enforce the feedback Id is not null (i.e, don't update feedback that hasn't been inserted yet
		if($this->feedbackId === null) {
			throw(new \PDOException("unable to update feedback that does not exist"));
		}

		// create query template
		$query = "UPDATE feedback SET feedbackSenderId = :feedbackSenderId, feedbackProductId = :feedbackProductId, feedbackRecipientId = :feedbackRecipientId, feedbackContent = :feedbackContent, feedbackRating = :feedbackRating WHERE feedbackId = :feedbackId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["feedbackSenderId" => $this->feedbackSenderId, "feedbackProductId" => $this->feedbackProductId, "feedbackRecipientId" => $this->feedbackRecipientId, "feedbackContent" => $this->feedbackContent, "feedbackRating" => $this->feedbackRating, "feedbackId" => $this->feedbackId];
		$statement->execute($parameters);
	}

	/**
	 * gets the feedback by feedback id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $feedbackId feedback id to search for
	 * @return Feedback|null Feedback found or null if not found
	 * @throws \PDOException when mySQl related errors occur
	 * @throws \TypeError when variables are not the correct data Type
	 **/
	public static function getFeedbackByFeedbackId(\PDO $pdo, int $feedbackId) {
		// sanitize the feedback before searching
		if($feedbackId <= 0) {
			throw(new \PDOException("feedback id is not positive"));
		}

		// create query tmeplate
		$query = "SELECT feedbackId, feedbackSenderId, feedbackProductId, feedbackRecipientId, feedbackContent, feedbackRating FROM feedback WHERE feedbackId = :feedbackId";
		$statement = $pdo->prepare($query);

		// bind the feedback id to the place holder in teh template
		$parameters = array("feedbackId" => $feedbackId);
		$statement->execute($parameters);

		// grab the message from mySQL
		try {
			$feedback = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$feedback = new Feedback($row["feedbackId"], $row["feedbackSenderId"], $row["feedbackProductId"], $row["feedbackRecipientId"], $row["feedbackContent"], $row["feedbackRating"]);
			}
		} catch(\Exception $exception) {
			// if the row coulldn't be converted, rethrow it
			throw(new \PDOException($exception->getFeedback(), 0, $exception));
		}
		return ($feedback);
	}

	/**
	 * gets the Feedback by party
	 * @param \PDO $pdo PDO connection object
	 * @param int $partyId id to use for both sender and recipient
	 * @param int $feedbackSenderId sender id to search for
	 * @param int $feedbackRecipientId recipient id to search for
	 * @return \SplFixedArray SplFixedArray of feedbacks found
	 * @throws \PDOException when mySQl realted erorr occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getFeedbackByPartyId(\PDO $pdo, int $partyId) {
		// sanitize the partyId before searching
		if($partyId <= 0) {
			throw(new \PDOException("partyId is not positive"));
		}

		//create query template
		$query = "SELECT feedbackId, feedbackSenderId, feedbackProductId, feedbackRecipientId, feedbackContent, feedbackRating FROM feedback WHERE feedbackSenderId = :partyId OR feedbackRecipientId = :partyId";
		$statement = $pdo->prepare($query);

		// bind the party id to the place holder in the template
		$parameters = array("partyId" => $partyId);
		$statement->execute($parameters);

		// build an array of feedbacks
		$feedbacks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$feedback = new Feedback($row["feedbackId"], $row["feedbackSenderId"], $row["feedbackProductId"], $row["feedbackRecipientId"], $row["feedbackContent"], $row["feedbackRating"]);
				$feedbacks[$feedbacks->key()] = $feedback;
				$feedbacks->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it k
				throw(new \PDOException($exception->getFeedback(), 0, $exception));
			}
		}
		return ($feedbacks);
	}

	/**
	 * gets feedback by feedbackSenderId
	 * @param \PDO $pdo connection object
	 * @param int $feedbackSenderId sender id to search for
	 * @return \SplFixedArray SplFixedArray of feedback found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 *
	 **/
	public static function getFeedbackByFeedbackSenderId(\PDO $pdo, int $feedbackSenderId) {
		// sanitize the feedbackSenderId before searching
		if($feedbackSenderId <= 0) {
			throw(new \PDOException("senderId is not positive"));
		}

		//create query template
		$query = "SELECT feedbackId, feedbackSenderId, feedbackProductId, feedbackRecipientId, feedbackContent, feedbackRating FROM feedback WHERE feedbackSenderId = :feedbackSenderId";;
		$statement = $pdo->prepare($query);

		// bind the feedbackSender id to the place holder in the template
		$parameters = array("feedbackSenderId" => $feedbackSenderId);
		$statement->execute($parameters);

		// build an array of feedbacks
		$feedbacks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$feedback = new Feedback($row["feedbackId"], $row["feedbackSenderId"], $row["feedbackProductId"], $row["feedbackRecipientId"], $row["feedbackContent"], $row["feedbackRating"]);
				$feedbacks[$feedbacks->key()] = $feedback;
				$feedbacks->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it k
				throw(new \PDOException($exception->getFeedback(), 0, $exception));
			}
		}
		return ($feedbacks);
	}

	/**
	 * gets feedback by feedbackRecipientId
	 * @param \PDO $pdo connection object
	 * @param int $feedbackRecipientId sender id to search for
	 * @return \SplFixedArray SplFixedArray of feedback found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 *
	 **/
	public static function getFeedbackByFeedbackRecipientId(\PDO $pdo, int $feedbackRecipientId) {
		// sanitize the feedbackSenderId before searching
		if($feedbackRecipientId <= 0) {
			throw(new \PDOException("recipientId is not positive"));
		}

		//create query template
		$query = "SELECT feedbackId, feedbackSenderId, feedbackProductId, feedbackRecipientId, feedbackContent, feedbackRating FROM feedback WHERE feedbackRecipientId = :feedbackRecipientId";;
		$statement = $pdo->prepare($query);

		// bind the feedbackRecipient id to the place holder in the template
		$parameters = array("feedbackRecipientId" => $feedbackRecipientId);
		$statement->execute($parameters);

		// build an array of feedbacks
		$feedbacks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$feedback = new Feedback($row["feedbackId"], $row["feedbackSenderId"], $row["feedbackProductId"], $row["feedbackRecipientId"], $row["feedbackContent"], $row["feedbackRating"]);
				$feedbacks[$feedbacks->key()] = $feedback;
				$feedbacks->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it k
				throw(new \PDOException($exception->getFeedback(), 0, $exception));
			}
		}
		return ($feedbacks);
	}


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
}
?>