<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property string $amenity
 */
class EANRoomAmenity extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'RoomAmenity';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var int
	 */
	public $amenityId;
	
	/**
	 * @var string
	 */
	protected $amenity;
	
	public static $propertyMap = array(
		'amenity' => 'string'
	);
	
	public static $attributeMap = array(
		'amenityId' => 'int'
	);
	
	/**
	 * @param EANRoomAmenity $supportModel
	 * @return EANRoomAmenity
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__amenity() {
		return $this->amenity;
	}
	
	protected function set__amenity($value) {
		$this->amenity = trim(Utils::htmlEntitiesDecode($value));
	}
	
}
