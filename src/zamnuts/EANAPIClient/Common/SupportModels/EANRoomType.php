<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property-read EANRoomAmenities $roomAmenities
 * @property-read EANHotelDetails $hotelDetails Rarely populated, usually for room availability queries.
 * @property-read EANPropertyAmenities $propertyAmenities Rarely populated, usually for room availability queries.
 * @property-read EANHotelImages $images Rarely populated, usually for room availability queries.
 * @property int $roomTypeId
 * @property int $roomCode
 * @property string $description
 * @property string $descriptionLong
 */
class EANRoomType extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'RoomType';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var int
	 */
	public $roomTypeId;
	
	/**
	 * @var int
	 */
	public $roomCode;
	
	/**
	 * @var string
	 */
	protected $description;
	
	/**
	 * @var string
	 */
	protected $descriptionLong;
	
	/**
	 * @var EANRoomAmenities
	 */
	protected $roomAmenities;
	
	/**
	 * @var EANHotelDetails
	 */
	protected $hotelDetails;
	
	/**
	 * @var EANPropertyAmenities
	 */
	protected $propertyAmenities;
	
	/**
	 * @var EANHotelImages
	 */
	protected $images;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'description' => 'string',
		'descriptionLong' => 'string',
		'roomAmenities' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRoomAmenities',
		'hotelDetails' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANHotelDetails',
		'propertyAmenities' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANPropertyAmenities',
		'images' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANHotelImages'
	);
	
	/**
	 * @var string[]
	 */
	protected static $attributeMap = array(
		'roomTypeId' => 'int',
		'roomCode' => 'int'
	);
	
	/**
	 * @param EANRoomType $supportModel
	 * @return EANRoomType
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__roomAmenities() {
		if ( isset($this->roomAmenities) ) {
			return clone $this->roomAmenities;
		}
		return null;
	}
	
	protected function get__hotelDetails() {
		if ( isset($this->hotelDetails) ) {
			return clone $this->hotelDetails;
		}
		return null;
	}
	
	protected function get__propertyAmenities() {
		if ( isset($this->propertyAmenities) ) {
			return clone $this->propertyAmenities;
		}
		return null;
	}
	
	protected function get__images() {
		if ( isset($this->images) ) {
			return clone $this->images;
		}
		return null;
	}
	
	protected function get__description() {
		return $this->description;
	}
	
	protected function set__description($value) {
		$this->description = trim(Utils::htmlEntitiesDecode($value));
	}
	
	protected function get__descriptionLong() {
		return $this->descriptionLong;
	}
	
	protected function set__descriptionLong($value) {
		$this->descriptionLong = trim(Utils::htmlEntitiesDecode($value));
	}
	
}
