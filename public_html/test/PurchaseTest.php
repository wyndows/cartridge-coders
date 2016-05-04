<?php
namespace Edu\Cnm\CartridgeCoders\Test

//parts of this code have been modified from the original, created by Dylan Mcdonald and taken from https://bootcamp-coders.cnm.edu

// grab the project test parameters
require_once("CartridgeCodersTest.php");

//grab the cal under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * full PHPUnit test for the Purchase class
 *
 * This is a an attempt at TDD testing.
 *
 *@see Purchase
 *@author Elliot Murrey <emurrey@cnm.edu
 **/
class Purchase extends CartridgeCodersTest {
	/**
	 * timestamp of Purchase
	 * @var dateime $VALID_PURCHASECREATEDATE
	 **/
	protected $VALID_PURCHASECREATEDATE = null;
	/**
	 * Account that created this Purchase; this is for foreign key relations
	 * @var Account Account
	 **/
	protected $Account = null;

	/**
	 * create dependent objects before running each test
	 **/2
	public final fuction setUp() {
	//run the default setUp() method first
	parent::setUp();
}
}