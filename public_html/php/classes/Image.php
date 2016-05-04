<?php
namespace Edu\Cnm\CartridgeCoders;

/**
 * Class for Images
 * @author Donald DeLeeuw <donald.deleeuw@gmail.com>
 */

class Image {

	/**
	 * id for image, this is the primary key
	 * @var int $imageId
	 */
	private $imageId;

	/**
	 * file name of image
	 * @var string(128) $imageFileName
	 */
	private $imageFileName;

	/**
	 * file type of image
	 * @var string(10) $imageType
	 */
	private $imageType;

	/**
	 * constructor for Image class
	 * @param int|null $newImageId - id of this image or null if new image - primary key
	 * @param string $newImageFileName - string containing name of image file
	 * @param string $newImageType - string containing name of image file type
	 * @throws \InvalidArgumentException - if data types are not valid
	 * @throws \RangeException - if values are out of range (strings too long, negative numbers, etc.)
	 * @throws \TypeError - if data types violate type hints
	 * @throws \Exception - catch all if another error occurs
	 **/
	public function __construct(int $newImageId = null, string $newImageFileName, string $newImageType) {
		try {
			$this->setImageId($newImageId);
			$this->setImageFileName($newImageFileName);
			$this->setImageType($newImageType);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw (new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for image id
	 * @return int|null value of image id
	 */
	public function getImageId() {
		return ($this->imageId);
	}

	/**
	 * mutator method for image id
	 * @param int|null $newImageId - new value of image id
	 * @throws \RangeException if $newImageId is not positive
	 * @throws \TypeError if $newimageId is not an intiger
	 **/
	public function setImageId(int $newImageId = null) {
		//if image id is null (composing), allow new image without mySQL assignment
		if($newImageId === null) {
			$this->imageId = null;
			return;
		}
		// verify image id is positive
		if($newImageId <= 0) {
			throw(new \RangeException("image id is not positive"));
		}
		// convert and store image id
		$this->imageId = $newImageId;
	}

	/**
	 * accessor method for image file name
	 *
	 * @return string of image file name
	 */
	public function getImageFileName() {
		return ($this->imageFileName);
	}

	/**
	 * mutator method for image file name
	 * @param string $newImageFileName - new value of image file name
	 * @throws \InvalidArgumentException if $newImageFileName is not a string or insecure
	 * @throws \RangeException if $newImageFileName is > 128 chars
	 * @throws \TypeError if $newImageFileName is not a string
	 */
	public function setImageFileName(string $newImageFileName) {
		// verify image file name is secure
		$newImageFileName = trim($newImageFileName);
		$newImageFileName = filter_var($newImageFileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newImageFileName) === true) {
			throw(new \InvalidArgumentException("image file name is empty or insecure"));
		}
		// verify the image file name will fit in the database
		if(strlen($newImageFileName) > 128) {
			throw(new \RangeException("image file name too large"));
		}
		// store image file name
		$this->imageFileName = $newImageFileName;
	}

	/**
	 * accessor method for image type
	 * @return string of image type
	 */
	public function getImageType() {
		return ($this->imageType);
	}

	/**
	 * mutator method for image type
	 *
	 * @param string $newImageType - new value of image type
	 * @throws \InvalidArgumentException if $newImageType is not a strgin or insecure
	 * @throws \RangeException if $newImageType is > 10 chars
	 * @throws \TypeError if $newImageType is not a string
	 */
	public function setImageType(string $newImageType) {
		// verify image type is secure
		$newImageType = trim($newImageType);
		$newImageType = filter_var($newImageType, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newImageType) === true) {
			throw (new \InvalidArgumentException("image type is empty or insecure"));
		}
		// verify the image type will fir into the database
		if(strlen($newImageType) > 10) {
			throw(new \RangeException("image type too long"));
		}
		// store image type
		$this->imageType = $newImageType;
	}

}













