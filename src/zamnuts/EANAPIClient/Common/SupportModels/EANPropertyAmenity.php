<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property string $amenity
 */
class EANPropertyAmenity extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'PropertyAmenity';
	
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
		'amenityId' => 'int',
		'amenity' => 'string'
	);
	
	/**
	 * @param EANPropertyAmenity $supportModel
	 * @return EANPropertyAmenity
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
