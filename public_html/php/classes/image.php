<?php
namespace Edu\Cnm\Ddeleeuw\Cartridge;

/**
 * Class for Images
 * @author Donald DeLeeuw <donald.deleeuw@gmail.com>
 */

class Image{

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
	 * construct for image
	 * @param int|null $newImageId - id of this image or null if new image - primary key
	 * @param string $newImageFileName - string containing name of image file
	 * @param string $newImageType - string containing name of image file type
	 * @throws \InvalidArgumentException - if data types are not valid
	 * @throws \RangeException - if values are out of range (strings too long, negative numbers, etc.)
	 * @throws \TypeError - if data types violate type hints
	 * @throws \Exception - catch all if another error occurs
	 **/

	


	private $imageId;
	private $imageFileName;
	private $imageType;















}



