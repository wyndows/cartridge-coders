<?php
/**
 * Message class for cartridge coders so accounts may message eachother back and forth
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
	 * @var int $accountId
	 **/
	private $senderId;
	/**
	 * product message is going to be about
	 * @var int $productId
	 **/
	private $productId;
	/**
	 * id of the seller
	 * @var int $accountID
	 **/
	private $recipientId;
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
	 * contructor for the message
	 *
	 * @param int $newMessageId new message id
	 * @param int $newSenderId new sender id
	 * @param int $newProductId new product id
	 * @param int $newRecipientId new recipient id
	 * @param string $newMessageContent new message content
	 * @param string $newMessageMailGunId new message mail gun Id
	 * @param string $newMessageSubject new message subject
	 * @throws UnexpectedValueException if any of the parameters are invalid
	 * @throws TypeError if data violates type hints
	 **/
	public function __construct($newMessageId, $newAccountId, $newProductId, $newAccountId2, $newMessageContent, $newMessageMailGunId, $newMessageSubject) {
		try {
			$this->setMessageId($newMessageId);
			$this->setSenderId($newAccountId);
			$this->setProductId($newProductId);
			$this->setRecipientId($newAccountId);
			$this->setMessageContent($newMessageContent);
			$this->setMessageMailGunId($newMessageMailGunId);
			$this->setMessageSubject($newMessageSubject);
		} catch(\TypeError $typeError) {
			//rethrow the exception to the caller
			throw(new\TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\UnexpectedValueException $exception) {
			// rethrow to the caller
			throw(new \UnexpectedValueException("unable to contruct Message", 0, $exception));
		} catch(\RangeException $range) {
			//rethrow the exceptin to the caller
			throw(new \RangeException($range ->getMessage(), 0, $range));
		}
}
	/**
	 * accessor method for message Id
	 *
	 * @return int value of message id
	 **/
	public function getMessageId() {
		return($this->messageId);
	}
	/**
	 *mutator method for message id
	 * @param int $newMessageId new value of message id
	 * @throws RangeException if the $newMessageId is not positive
	 * @throws unexpectedValueException if $newMessageId is not an integer
	 **/
	public function setMessageId($newMessageId) {
		$newMessageId = filter_var($newMessageId, FILTER_VALIDATE_INT);
		if($newMessageId === false) {
			throw(new UnexpectedValueException("MessageId is not a valid integer"));
		}
		//confirm message is positive
		if($newMessageId <=0) {
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
	public function getSenderId() {
		return($this->senderId);
	}
	/**
	 * mutator method for message sender id
	 * @param int $newSenderId new value of sender id
	 * @throws unexpectedValueException if $newSenderId is not a integer
	 * @throws RangeException if $newSenderId is not positive
	 **/
	public function setSenderId($newSenderId) {
		$newSenderId = filter_var($newSenderId, FILTER_VALIDATE_INT);
		if($newSenderId === false) {
			throw(new UnexpectedValueException("SenderId is not a valid integer"));
		}
		//confirm sender id is positive
		if($newSenderId <=0) {
			throw(new RangeException("sender id is not positive"))
		}
		//convert and store the account id
		$this->senderId = intval($newSenderId);
	}
	/**
	 * accessor method for product id
	 *
	 * @return int value of product id
	 **/
	public function getProductId() {
		return($this->productId);
	}
	/**
	 * mutator method for product id
	 * @param int $newProductId new value of product id
	 * @throws unexpectedValueException if $newProductId is not a valid integer
	 * @throws RangeException if the $newProductId is not positive
	 **/
	public function setProductId($newProductId) {
		$newProductId = filter_var($newProductId, FILTER_VALIDATE_INT);
		if($newProductId === false) {
			throw(new UnexpectedValueException("ProductId is not a valid integer"));
		}
		// confirm product id is positive
		if($newProductId <=0) {
			throw(new RangeException("product id is not positive"));
		}
		//convert and store the product id
		$this->productId = intval($newProductId);
	}
	/**
	 * accessor method for recipient id
	 *
	 * @return int value of recipient id
	 **/
	public function getRecipientId() {
		return($this->recipientId);
	}
	/**
	 * mutator method for message recipient id
	 * @param int $newRecipientId new value of recipient id
	 * @throws unexpectedValueException if $newRecipientId is not a integer
	 * @throws RangeException if the $newRecipientId is not positive
	 **/
	public function setRecipientId($newRecipientId) {
		$newRecipientId = filter_var($newRecipientId, FILTER_VALIDATE_INT);
		if($newRecipientId === false) {
			throw(new UnexpectedValueException("RecipientId is not a valid integer"));
		}
		//confirm sender id is positive
		if($newRecipientId <=0) {
			throw(new RangeException("sender id is not positive"))
		}
		//convert and store the account id
		$this->recipientId = intval($newRecipientId);
	}
	/**
	 * accessor for message content
	 *
	 * @return string value of message content
	 **/
	public function getMessageContent() {
		return($this->messageContent);
	}
	/**
	 * mutator method for message content
	 *
	 * @param string $newMessageContent new value of message content
	 * @throws UnexpectedValueException if $newMessageContent is not valid
	 * @throws RangeException if the $newMessageContent exceeds var 255 is not positive
	 **/
	public function setMessageContent($newMessageContent) {
		//verify the message content is valid
		$newMessageContent = filter_var($newMessageContent, FILTER_SANITIZE_STRING);
		if($newMessageContent === false) {
			throw(new UnexpectedValueException("message cotent is not a valid string"));
		}
		if($newMessageContent > 255) {
			// confirm message content doesn't exceed 255
			throw(new \RangeException("message too long"));
		}
		// store the message content
		$this->messageContent = $newMessageContent;
	}
	/**
	 * accessor for mail gun id
	 *
	 * #return string value of message mailgun id
	 **/
	public function getMessageMailGunId() {
		return($this->messageMailGunId);
	}
	/**
	 * mutator method for message mailgun id
	 *
	 * @param string $newMessageMailGunId new value of message mailgun id
	 * @throws UnexpectedValueException if $newMessageMailGunId is not valid
	 * @throws RangeException if mail gun id exceeds 32
	 **/
	public function setMessageMailGunId($newMessageMailGunId) {
		//verify the message mail gun id is valid
		$newMessageMailGunId = filter_var($newMessageMailGunId, FILTER_SANITIZE_STRING);
		if($newMessageMailGunId === false) {
			throw(new UnexpectedValueException("message mailgun id is not a valid string"));
		}
		// verify the messge mail gun id is less then 32
		if($newMessageMailGunId >32) {
			throw(new RangeException("invalid mailgunId"));
		}
		//store the message mailgun id
		$this->messageMailGunId = $newMessageMailGunId;
	}
	/**
	 * accessor for message subject
	 *
	 * @return string value of message subject
	 **/
	public function  getMessageSubject() {
		return($this->messageSubject);
	}
	/**
	 * mutator method for message subject
	 *
	 * @param string $newMessageSubject new value of message subject
	 * @throws UnexpectedValueException if $newMessageSubject is not valid
	 * @throws RangeException if $newMessageSubject is more than 128
	 **/
	public function setMessageSubject($newMessageSubject) {
		// verify the message subject is valid
		$newMessageSubject = filter_var($newMessageSubject, FILTER_SANITIZE_STRING);
		if($newMessageSubject === false) {
			throw(new UnexpectedValueException("message subject is not a valid string"));
		}
		// confirm message subject doesn't exceed 128
		if($newMessageSubject > 128) {
			throw(new RangeException("value exceeds message subject length"));
		}
		//store the message subject
		$this->messageSubject = $newMessageSubject;
	}
	/**
	 * insert message into mySQL
	 * 
	 * @param PDO $pdo - PDO connection object
	 * @throw PDOexception when mySql errors occur
	 * @throws TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(PDO $pdo) {
		// enforce message id is null - make sure createing a new message
		if($this->messageId !== null) {
			throw(new PDOException("not new message"));
		}
		$query = "INSERT INTO message(messageSenderId, messageProductId, messageRecipientId, messageContent, messageMailGunId, messageSubject) VALUES(:messageSenderId: messageProductId, :messageRecipientId, :messageContent, :messageMailGunId, :messageSubject");
		$statement = $pdo->prepare($query);

		// bind the member variable to the kplace holders on the template
		$parameters = ["senderId" => $this->account->getAccountId, "productId" => ]
	}
	/**
	 * toString() magic method
	 *
	 * @return string HTML formatted message
	 **/
	public function __tostring() {
		// create an HTML formatted message
		$html = "<p>Message id: " . $this->messageId
				. "Account id: "    . $this->accountId
				. "Product id: "    . $this->productId
				. "Account id: "    . $this->accountId
				. "MessageContent"  . $this->messageContent
				. "MessageMailGunId". $this->messageMailGunId
				. "MessageSubject"  . $this->messageSubject
				. "</p>";
		return($html);
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