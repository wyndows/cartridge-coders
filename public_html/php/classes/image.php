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
	 * @var varchar(128) $imageFileName
	 */
	private $imageFileName;

	/**
	 * file type of image
	 * @var varchar(10) $imageType
	 */
	private $imageType;
}



