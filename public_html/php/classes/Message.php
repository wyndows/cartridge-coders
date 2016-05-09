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
	private $accountId;
	/**
	 * product message is going to be about
	 * @var int $productId
	 **/
	private $productId;
	/**
	 * id of the seller
	 * @var int $accountID
	 **/
	private $accountId2;
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
	 * @throws unexpectedValueException if $newMessageId is not an integer
	 **/
	public function setMessageId($newMessageId) {
		$newMessageId = filter_var($newMessageId, FILTER_VALIDATE_INT);
		if($newMessageId === false) {
			throw(new UnexpectedValueException("MessageId is not a valid integer"));
		}
		//convert and store the message id
		$this->messageId = intval($newMessageID);
	}
	/**
	 * accessor method for account id
	 *
	 * @return int value of account id
	 **/
	public function getAccountId() {
		return($this->accountId);
	}
	/**
	 * mutator method for message account id
	 * @param int $newAccountId new value of account id
	 * @throws unexpectedValueException if $newAccountId is not a integer
	 **/
	public function setAccountId($newAccountId) {
		$newAccountId = filter_var($newAccountId, FILTER_VALIDATE_INT);
		if($newAccountId === false) {
			throw(new UnexpectedValueException("AccountId is not a valid integer"));
		}
		//convert and store the account id
		$this->accountId = intval($newAccountId);
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
	 **/
	public function setProductId($newProductId) {
		$newProductId = filter_var($newProductId, FILTER_VALIDATE_INT);
		if($newProductId === false) {
			throw(new UnexpectedValueException("ProductId is not a valid integer"));
		}
		//convert and store the product id
		$this->productId = intval($newProductId);
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
	 **/
	public function setMessageContent($newMessageContent) {
		//verify the message content is valid
		$newMessageContent = filter_var($newMessageContent, FILTER_SANITIZE_STRING);
		if($newMessageContent === false) {
			throw(new UnexpectedValueException("message cotent is not a valid string"));
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
	 **/
	public function setMessageMailGunId($newMessageMailGunId) {
		//verify the message mail gun id is valid
		$newMessageMailGunId = filter_var($newMessageMailGunId, FILTER_SANITIZE_STRING);
		if($newMessageMailGunId === false) {
			throw(new UnexpectedValueException("message mailgun id is not a valid string"));
		}
		//store the message mailgun id
		$this->messageMailGunId = $newMessageMailGunId;
	}
}