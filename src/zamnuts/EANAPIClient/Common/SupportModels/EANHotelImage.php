<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property string $name
 * @property string $caption
 * @property string $url
 * @property string $thumbnailUrl
 */
class EANHotelImage extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelImage';
	
	/**
	 * @var string
	 */
	public static $THUMBNAIL_URL_PREFIX = 'http://images.travelnow.com'; // no trailing slash needed
	
	/**
	 * @var string
	 */
	public $hotelImageId;
	
	/**
	 * @var string
	 */
	protected $name;
	
	/**
	 * @var int
	 */
	public $category;
	
	/**
	 * @var int
	 */
	public $type;
	
	/**
	 * @var string
	 */
	protected $caption;
	
	/**
	 * @var string
	 */
	protected $url;
	
	/**
	 * @var string
	 */
	protected $thumbnailUrl;
	
	/**
	 * @var int
	 */
	public $supplierId;
	
	/**
	 * @var int
	 */
	public $width;
	
	/**
	 * @var int
	 */
	public $height;
	
	/**
	 * @var int
	 */
	public $byteSize;
	
	public static $propertyMap = array(
		'hotelImageId' => 'int',
		'name' => 'string',
		'category' => 'int',
		'type' => 'int',
		'caption' => 'string',
		'url' => 'string',
		'thumbnailUrl' => 'string',
		'supplierId' => 'int',
		'width' => 'int',
		'height' => 'int',
		'byteSize' => 'int'
	);
	
	/**
	 * @param EANHotelImage $supportModel
	 * @return EANHotelImage
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__name() {
		return $this->name;
	}
	
	protected function set__name($value) {
		$this->name = trim(Utils::htmlEntitiesDecode($value));
	}
	
	protected function get__caption() {
		return $this->caption;
	}
	
	protected function set__caption($value) {
		$this->caption = trim(Utils::htmlEntitiesDecode($value));
	}
	
	protected function get__url() {
		return $this->url;
	}
	
	protected function set__url($value) {
		$this->url = $this->supplementUrlPrefix(trim(Utils::htmlEntitiesDecode($value)));
	}
	
	protected function get__thumbnailUrl() {
		return $this->thumbnailUrl;
	}
	
	protected function set__thumbnailUrl($value) {
		$this->thumbnailUrl = $this->supplementUrlPrefix(trim(Utils::htmlEntitiesDecode($value)));
	}
	
	private function supplementUrlPrefix($url) {
		$parsed = parse_url($url);
		if ( isset($parsed['path']) ) {
			return rtrim(static::$THUMBNAIL_URL_PREFIX,'/').'/'.ltrim($parsed['path'],'/').(isset($parsed['query'])?'?'.$parsed['query']:'');
		}
		return null;
	}
		
}
