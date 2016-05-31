<?php

namespace Edu\Cnm\CartridgeCoders;
require_once ("autoload.php");
/**
 * Message class for cartridge coders so accounts may message each other back and forth
 * @author Elliot Murrey  <emurrey@cnm.edu> based on code from Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class Message implements \JsonSerializable {
	/**
	 * the id for the message, this will be the primary key
	 * @var int $messageId
	 **/
	private $messageId;
	/**
	 * id for the buyer
	 * @var int $messageSenderId
	 **/
	private $messageSenderId;
	/**
	 * product message is going to be about
	 * @var int $productId
	 **/
	private $productId;
	/**
	 * id of the seller
	 * @var int $messageRecipientId
	 **/
	private $messageRecipientId;
	/**
	 * content for message
	 * @var string $messageContent
	 **/
	private $messageContent;
	/**
	 * the id the api mailGun will use
	 * @var string $messageMailGunId
	 **/
	private $messageMailGunId;
	/**
	 * what the message will be about
	 * #var string $messageSubject
	 **/
	private $messageSubject;
	

	/**
	 * constructor for the message
	 *
	 * @param int $newMessageId new message id
	 * @param int $newMessageSenderId new sender id
	 * @param int $newProductId new product id
	 * @param int $newMessageRecipientId new recipient id
	 * @param string $newMessageContent new message content
	 * @param string $newMessageMailGunId new message mail gun Id
	 * @param string $newMessageSubject new message subject
	 * @throws \UnexpectedValueException if any of the parameters are invalid
	 * @throws \TypeError if data violates type hints
	 * @throws \RangeException if not an int
	 **/
	public function __construct(int $newMessageId = null, int $newMessageSenderId, int $newProductId, int $newMessageRecipientId, string  $newMessageContent, string $newMessageMailGunId, string $newMessageSubject) {
		try {
			$this->setMessageId($newMessageId);
			$this->setMessageSenderId($newMessageSenderId);
			$this->setProductId($newProductId);
			$this->setMessageRecipientId($newMessageRecipientId);
			$this->setMessageContent($newMessageContent);
			$this->setMessageMailGunId($newMessageMailGunId);
			$this->setMessageSubject($newMessageSubject);
		} catch(\TypeError $typeError) {
			//rethrow the exception to the caller
			throw(new\TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\UnexpectedValueException $exception) {
			// rethrow to the caller
			throw(new \UnexpectedValueException("unable to construct Message", 0, $exception));
		} catch(\RangeException $range) {
			//rethrow the exceptin to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
	}

	/**
	 * accessor method for message Id
	 *
	 * @return int value of message id
	 **/
	public function getMessageId() {
		return ($this->messageId);
	}

	/**
	 *mutator method for message id
	 * @param int $newMessageId new value of message id
	 * @throws \RangeException if the $newMessageId is not positive
	 * @throws \UnexpectedValueException if $newMessageId is not an integer
	 **/
	public function setMessageId($newMessageId) {
		if($newMessageId === null) {
			$this->messageId = null;
			return;
		}
		$newMessageId = filter_var($newMessageId, FILTER_VALIDATE_INT);
		if($newMessageId === false) {
			throw(new \UnexpectedValueException("MessageId is not a valid integer"));
		}
		//confirm message is positive
		if($newMessageId <= 0) {
			throw(new \RangeException("message id is not valid"));
		}
		//convert and store the message id
		$this->messageId = intval($newMessageId);
	}

	/**
	 * accessor method for sender id
	 *
	 * @return int value of sender id
	 **/
	public function getMessageSenderId() {
		return ($this->messageSenderId);
	}

	/**
	 * mutator method for message sender id
	 * @param int $newMessageSenderId new value of sender id
	 * @throws \UnexpectedValueException if $newSenderId is not a integer
	 * @throws \RangeException if $newSenderId is not positive
	 **/
	public function setMessageSenderId($newMessageSenderId) {
		$newMessageSenderId = filter_var($newMessageSenderId, FILTER_VALIDATE_INT);
		if($newMessageSenderId === false) {
			throw(new \UnexpectedValueException("SenderId is not a valid integer"));
		}
		//confirm sender id is positive
		if($newMessageSenderId <= 0) {
			throw(new \RangeException("sender id is not positive"));
		}
		//convert and store the account id
		$this->messageSenderId = intval($newMessageSenderId);
	}

	/**
	 * accessor method for product id
	 *
	 * @return int value of product id
	 **/
	public function getProductId() {
		return ($this->productId);
	}

	/**
	 * mutator method for product id
	 * @param int $newProductId new value of product id
	 * @throws \UnexpectedValueException if $newProductId is not a valid integer
	 * @throws \RangeException if the $newProductId is not positive
	 **/
	public function setProductId($newProductId) {
		$newProductId = filter_var($newProductId, FILTER_VALIDATE_INT);
		if($newProductId === false) {
			throw(new \UnexpectedValueException("ProductId is not a valid integer"));
		}
		// confirm product id is positive
		if($newProductId <= 0) {
			throw(new \RangeException("product id is not positive"));
		}
		//convert and store the product id
		$this->productId = intval($newProductId);
	}

	/**
	 * accessor method for recipient id
	 *
	 * @return int value of recipient id
	 **/
	public function getMessageRecipientId() {
		return ($this->messageRecipientId);
	}

	/**
	 * mutator method for message recipient id
	 * @param int $newRecipientId new value of recipient id
	 * @throws \UnexpectedValueException if $newRecipientId is not a integer
	 * @throws \RangeException if the $newRecipientId is not positive
	 **/
	public function setMessageRecipientId($newRecipientId) {
		$newRecipientId = filter_var($newRecipientId, FILTER_VALIDATE_INT);
		if($newRecipientId === false) {
			throw(new \UnexpectedValueException("RecipientId is not a valid integer"));
		}
		//confirm recipientId id is positive
		if($newRecipientId <= 0) {
			throw(new \RangeException("sender id is not positive"));
		}
		//convert and store the account id
		$this->messageRecipientId = intval($newRecipientId);
	}

	/**
	 * accessor for message content
	 *
	 * @return string value of message content
	 **/
	public function getMessageContent() {
		return ($this->messageContent);
	}

	/**
	 * mutator method for message content
	 *
	 * @param string $newMessageContent new value of message content
	 * @throws \UnexpectedValueException if $newMessageContent is not valid
	 * @throws \RangeException if the $newMessageContent exceeds var 255 is not positive
	 **/
	public function setMessageContent($newMessageContent) {
		//verify the message content is valid
		$newMessageContent = filter_var($newMessageContent, FILTER_SANITIZE_STRING);
		if($newMessageContent === false) {
			throw(new \UnexpectedValueException("message cotent is not a valid string"));
		}
		if($newMessageContent > 255) {
			// confirm message content doesn't exceed 255
			throw(new \RangeException("message too long"));
		}
		// store the message content
		$this->messageContent = $newMessageContent;
	}

	/**
	 * accessor fo*8r mail gun id
	 *
	 * #return string value of message mailgun id
	 **/
	public function getMessageMailGunId() {
		return ($this->messageMailGunId);
	}

	/**
	 * mutator method for message mailgun id
	 *
	 * @param string $newMessageMailGunId new value of message mailgun id
	 * @throws \UnexpectedValueException if $newMessageMailGunId is not valid
	 * @throws \RangeException if mail gun id exceeds 32
	 **/
	public function setMessageMailGunId($newMessageMailGunId) {
		//verify the message mail gun id is valid
		$newMessageMailGunId = filter_var($newMessageMailGunId, FILTER_SANITIZE_STRING);
		if($newMessageMailGunId === false) {
			throw(new \UnexpectedValueException("message mailgunid is not a valid string"));
		}
		// verify the message mail gun id is less then 40
		if(strlen($newMessageMailGunId) > 40) {
			throw(new \RangeException("invalid mailgunId"));
		}
		//store the message mailgun id
		$this->messageMailGunId = $newMessageMailGunId;
	}

	/**
	 * accessor for message subject
	 *
	 * @return string value of message subject
	 **/
	public function getMessageSubject() {
		return ($this->messageSubject);
	}

	/**
	 * mutator method for message subject
	 *
	 * @param string $newMessageSubject new value of message subject
	 * @throws \UnexpectedValueException if $newMessageSubject is not valid
	 * @throws \RangeException if $newMessageSubject is more than 128
	 **/
	public function setMessageSubject($newMessageSubject) {
		// verify the message subject is valid
		$newMessageSubject = filter_var($newMessageSubject, FILTER_SANITIZE_STRING);
		if($newMessageSubject === false) {
			throw(new \UnexpectedValueException("message subject is not a valid string"));
		}
		// confirm message subject doesn't exceed 128
		if($newMessageSubject > 128) {
			throw(new \RangeException("value exceeds message subject length"));
		}
		//store the message subject
		$this->messageSubject = $newMessageSubject;
	}
	
	/**
	 * insert message into mySQL
	 *
	 * @param \PDO $pdo - PDO connection object
	 * @throw PDOException when mySql errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// enforce message id is null - make sure we're inserting a new message
		if($this->messageId !== null) {
			throw(new \PDOException("not new message"));
		}

		// create a query template
		$query = "INSERT INTO message(messageSenderId, messageProductId, messageRecipientId, messageContent, messageMailGunId, messageSubject) VALUES(:messageSenderId, :messageProductId, :messageRecipientId, :messageContent, :messageMailGunId, :messageSubject)";
		$statement = $pdo->prepare($query);

		// bind the member variable to the place holders in the template
		$parameters = ["messageSenderId" => $this->messageSenderId, "messageProductId" => $this->productId, "messageRecipientId" => $this->messageRecipientId, "messageContent" => $this->messageContent, "messageMailGunId" => $this->messageMailGunId, "messageSubject" => $this->messageSubject];
		$statement->execute($parameters);

		//update the null messageId with what mySQL just gave us
		$this->messageId = intval($pdo->lastInsertId());
	}

	/**
	 * gets the Message by messageId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $messageId message id to search for
	 * @return Message|null Message found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getMessageByMessageId(\PDO $pdo, int $messageId) {
		// sanitize the messageId before searching
		if($messageId <= 0) {
			throw(new \PDOException("message id is not positive"));
		}

		// create query template
		$query = "SELECT messageId, messageSenderId, messageProductId, messageRecipientId, messageContent, messageMailGunId, messageSubject FROM message WHERE messageId = :messageId";
		$statement = $pdo->prepare($query);

		// bind the message id to the place holder in the template
		$parameters = array("messageId" => $messageId);
		$statement->execute($parameters);

		// grab the message from mySQL
		try {
			$message = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$message = new Message($row["messageId"], $row["messageSenderId"], $row["messageProductId"], $row["messageRecipientId"], $row["messageContent"], $row["messageMailGunId"], $row["messageSubject"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($message);
	}

	/**
	 * gets the Message by partyId
	 * @param \PDO $pdo PDO connection object
	 * @param int $partyId id to use for both sender and recipient
	 * @param int $messageSenderId sender id to search for
	 * @param int $messageRecipientId recipient id to search for
	 * @return \SplFixedArray SplFixedArray of messages found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getMessageByPartyId(\PDO $pdo, int $partyId) {
		// sanitize the partyId before searching
		if($partyId <= 0) {
			throw(new \PDOException("partyId is not positive "));
		}

		// create query template
		$query = "SELECT messageId, messageSenderId, messageProductId, messageRecipientId, messageContent, messageMailGunId, messageSubject FROM message WHERE messageSenderId = :partyId OR messageRecipientId = :partyId";
		$statement = $pdo->prepare($query);

		// bind the party id to the place holder in the template
		$parameters = array("partyId" => $partyId);
		$statement->execute($parameters);

		// build an array of messages
		$messages = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$message = new Message($row["messageId"], $row["messageSenderId"], $row["messageProductId"], $row["messageRecipientId"], $row["messageContent"], $row["messageMailGunId"], $row["messageSubject"]);
				$messages[$messages->key()] = $message;
				$messages->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($messages);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);

	}

}