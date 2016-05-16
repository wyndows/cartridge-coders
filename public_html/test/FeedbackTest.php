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
class FeedbackTest extends CartridgeCodersTest {}