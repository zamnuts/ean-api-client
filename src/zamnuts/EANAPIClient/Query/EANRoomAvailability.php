<?php

namespace zamnuts\EANAPIClient\Query;

use \DateTime;
use zamnuts\EANAPIClient\Util\XMLUtils;
use zamnuts\EANAPIClient\Common\SupportModels\EANResponseRoomAvailability;
use zamnuts\EANAPIClient\Common\SupportModels\EANRoom;
use zamnuts\EANAPIClient\Common\SupportModels\EANRoomGroup;
use zamnuts\EANAPIClient\Common\SupportModels\EANResponseHotelInformation;

/**
 * @property int $hotelId The EAN ID of the hotel.
 * @property string $options A comma-delimited list of registered options.
 * @property string[] $optionsArray An array of registered options.
 * @property EANResponseHotelInformation $response Yea, the response. OK?
 * @property DateTime $arrivalDate
 * @property DateTime $departureDate
 * @property int $numberOfBedRooms
 * @property string $supplierType
 * @property string $rateKey
 * @property EANRoomGroup $roomGroup
 * @property string $roomTypeCode
 * @property string $rateCode
 * @property boolean $includeDetails
 * @property boolean $includeRoomImages
 * @property boolean $includeHotelFeeBreakdown
 */
class EANRoomAvailability extends EANAbstractQuery {
	
	/**
	 * @var string
	 */
	protected static $API_METHOD = 'avail';
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelRoomAvailabilityRequest';
	
	/**
	 * @var string
	 */
	protected static $RESPONSE_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANResponseRoomAvailability';
	
	/**
	 * @var string
	 */
	const OPTIONS_DEFAULT = 'DEFAULT';
	
	/**
	 * @var string
	 */
	const OPTIONS_HOTEL_DETAILS = 'HOTEL_DETAILS';
	
	/**
	 * @var string
	 */
	const OPTIONS_ROOM_TYPES = 'ROOM_TYPES';
	
	/**
	 * @var string
	 */
	const OPTIONS_ROOM_AMENITIES = 'ROOM_AMENITIES';
	
	/**
	 * @var string
	 */
	const OPTIONS_PROPERTY_AMENITIES = 'PROPERTY_AMENITIES';
	
	/**
	 * @var string
	 */
	const OPTIONS_HOTEL_IMAGES = 'HOTEL_IMAGES';
	
	/**
	 * Supplier Type: Expedia Collect
	 * @var string
	 */
	const SUPPLIER_TYPE_E = 'E';
	
	/**
	 * Supplier Type: Venere (Hotel Collect)
	 * @var string
	 */
	const SUPPLIER_TYPE_V = 'V';
	
	/**
	 * Supplier Type: Sabre (Hotel Collect)
	 * @var string
	 */
	const SUPPLIER_TYPE_S = 'S';
	
	/**
	 * Supplier Type: Worldspan (Hotel Collect)
	 * @var string
	 */
	const SUPPLIER_TYPE_W = 'W';
	
	/**
	 * @var int
	 */
	protected $hotelId;
	
	/**
	 * @var DateTime
	 */
	protected $arrivalDate;
	
	/**
	 * @var DateTime
	 */
	protected $departureDate;
	
	/**
	 * @var int
	 */
	protected $numberOfBedRooms;
	
	/**
	 * @var string
	 */
	protected $supplierType;
	
	/**
	 * @var string
	 */
	protected $rateKey;
	
	/**
	 * @var EANRoomGroup
	 */
	protected $roomGroup;
	
	/**
	 * @var string
	 */
	protected $roomTypeCode;
	
	/**
	 * @var string
	 */
	protected $rateCode;
	
	/**
	 * Default: true 
	 * @var boolean
	 */
	public $includeDetails = true;
	
	/**
	 * Default: true 
	 * @var boolean
	 */
	public $includeRoomImages = true;
	
	/**
	 * Default: true 
	 * @var boolean
	 */
	public $includeHotelFeeBreakdown = true;
	
	/**
	 * @var string[]
	 */
	protected $options = array();
	
	/**
	 * @var EANResponseHotelInformation
	 */
	protected $response;
	
	protected static $propertyMap = array(
		'hotelId' => 'int',
		'arrivalDate' => 'DateTime',
		'departureDate' => 'DateTime',
		'numberOfBedRooms' => 'int',
		'supplierType' => 'string',
		'rateKey' => 'string',
		'roomGroup' => 'EANRoomGroup',
		'roomTypeCode' => 'string',
		'rateCode' => 'string',
		'includeDetails' => 'boolean',
		'includeRoomImages' => 'boolean',
		'includeHotelFeeBreakdown' => 'boolean',
		'options' => 'string'
	);
	
	public function __construct($hotelId=null) {
		parent::__construct();
		if ( isset($hotelId) ) {
			$this->set__hotelId($hotelId);
		}
	}
	
	protected function prepareRequest() {
		foreach ( self::$propertyMap as $property => $type ) {
			if ( !isset($this->$property) ) {
				continue;
			}
			switch ( $type ) {
				case 'DateTime':
					$this->xmlRequest->$property = $this->$property->format('m/d/Y');
					break;
				case 'EANRoomGroup':
					XMLUtils::appendSXE($this->xmlRequest, $this->$property->xml);
					break;
				case 'int':
				case 'float':
				case 'string':
					if ( method_exists($this,'get__'.$property) ) {
						$this->xmlRequest->$property = $this->{'get__'.$property}();
					} else {
						$this->xmlRequest->$property = (string) $this->$property;
					}
					break;
				case 'boolean':
					$this->xmlRequest->$property = $this->$property?'true':'false';
					break;
			}
		}
	}
	
	
	/**
	 * @return EANResponseHotelInformation
	 */
	protected function get__response() {
		if ( isset($this->response) ) {
			return clone $this->response;
		}
		return null;
	}
	
	// Hotel ID
	protected function get__hotelId() {
		return $this->hotelId;
	}
	
	protected function set__hotelId($value) {
		$this->hotelId = (int) $value;
	}
	
	// Arrival Date
	protected function get__arrivalDate() {
		return clone $this->arrivalDate;
	}
	
	protected function set__arrivalDate($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->arrivalDate = new DateTime($date);
	}
	
	// Departure Date
	protected function get__departureDate() {
		return clone $this->departureDate;
	}
	
	protected function set__departureDate($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->departureDate = new DateTime($date);
	}
	
	// Number of Bedrooms
	protected function get__numberOfBedRooms() {
		return $this->numberOfBedRooms;
	}
	
	protected function set__numberOfBedRooms($value) {
		$value = (int) $value;
		if ( $value > 0 ) {
			if ( $value > 4 ) {
				$value = 4;
			}
			$this->numberOfBedRooms = $value;
		}
	}
	
	// Supplier Type
	protected function get__supplierType() {
		return $this->supplierType;
	}
	
	protected function set__supplierType($value) {
		$value = substr(preg_replace('/[^A-Z]/i','',strtoupper((string) $value)),0,256);
		$constStr = 'self::SUPPLIER_TYPE_'.$value;
		if ( defined($constStr) ) {
			$this->supplierType = constant($constStr);
		}
	}
	
	// Rate Key
	protected function get__rateKey() {
		return $this->rateKey;
	}
	
	protected function set__rateKey($value) {
		if ( isset($value) ) {
			$value = (string) $value;
			if ( strlen($value) ) {
				$this->rateKey = (string) $value;
			}
		}
	}
	
	// Room Group
	protected function get__roomGroup() {
		return clone $this->roomGroup;
	}
	
	protected function set__roomGroup(EANRoomGroup $value) {
		if ( $value instanceof EANRoomGroup ) {
			$this->roomGroup = clone $value;
		}
	}
	
	/**
	 * @param EANRoom $room
	 * @return boolean
	 */
	public function addRoom(EANRoom $room) {
		if ( $room instanceof EANRoom ) {
			if ( !isset($this->roomGroup) || !($this->roomGroup instanceof EANRoomGroup) ) {
				$this->roomGroup = new EANRoomGroup();
			}
			return $this->roomGroup->addRoom($room);
		}
		return false;
	}
	
	/**
	 * @param EANRoom $room
	 * @return boolean
	 */
	public function removeRoom(EANRoom $room) {
		if ( $room instanceof EANRoom ) {
			return $this->roomGroup->removeRoom($room);
		}
		return false;
	}
	
	/**
	 * @param int $i
	 * @return boolean
	 */
	public function removeRoomByIndex($i) {
		return $this->roomGroup->removeRoomByIndex($i);
	}
	
	// Room Type Code
	protected function get__roomTypecode() {
		return $this->roomTypeCode;
	}
	
	protected function set__roomTypeCode($value) {
		if ( isset($value) ) {
			$value = (string) $value;
			if ( strlen($value) ) {
				$this->roomTypeCode = (string) $value;
			}
		}
	}
	
	// Rate Code
	protected function get__rateCode() {
		return $this->rateCode;
	}
	
	protected function set__rateCode($value) {
		if ( isset($value) ) {
			$value = (string) $value;
			if ( strlen($value) ) {
				$this->rateCode = (string) $value;
			}
		}
	}
			
	// Options
	protected function get__options() {
		return implode(',',$this->get__optionsArray());
	}

	protected function set__options($value) {
		$value = (string) $value;
		$array = explode(',',$value);
		foreach ( $array as $option ) {
			$this->includeOption($option);
		}
	}
	
	protected function get__optionsArray() {
		return $this->options;
	}
	
	protected function set__optionsArray($options) {
		$this->includeOption(implode(',',$options));
	}
	
	/**
	 * Clears all options.
	 * @return array Returns an array of the old options that were defined before they were removed.
	 */
	public function clearOptions() {
		$oldOptions = array();
		if ( isset($this->options) && is_array($this->options) ) {
			$oldOptions = $this->options;
		}
		$this->options = array();
		return $oldOptions;
	}
	
	/**
	 * Clears all options and sets the default option.
	 * @see EANRoomAvailability::clearOptions()
	 * @return array Returns an array of the old options that were defined before they were removed.
	 */
	public function defaultOptions() {
		$oldOptions = array();
		if ( isset($this->options) && is_array($this->options) ) {
			$oldOptions = $this->options;
		}
		$this->options = array(static::OPTIONS_DEFAULT);
		return $oldOptions;
	}
	
	/**
	 * Note: If the default option exists, it is removed.
	 * @param int $option One of the OPTIONS_* constants.
	 * @return boolean
	 */
	public function includeOption($option) {
		$option = strtoupper((string) $option);
		if ( $this->isOption($option) ) {
			$this->excludeOption(static::OPTIONS_DEFAULT);
			array_push($this->options,$option);
			$this->options = array_unique($this->options,SORT_STRING);
			return true;
		}
		return false;
	}
	
	/**
	 * @param int $option One of the OPTIONS_* constants.
	 * @return boolean
	 */
	public function excludeOption($option) {
		$option = strtoupper((string) $option);
		if ( $this->isOption($option)  ) {
			$keys = array_keys($this->options,$option,true);
			foreach ( $keys as $key ) {
				unset($this->options[$key]);
			}
			$this->options = array_values($this->options);
		}
		return false;
	}
	
	/**
	 * Checks if the given option is a valid constant's value.
	 * @param string $option
	 * @return boolean
	 */
	public function isOption($option) {
		return defined('static::OPTIONS_'.$option) && constant('static::OPTIONS_'.$option) === $option;
	}
	
}
