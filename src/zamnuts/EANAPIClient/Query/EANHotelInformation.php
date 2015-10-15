<?php

namespace zamnuts\EANAPIClient\Query;

use zamnuts\EANAPIClient\Common\SupportModels\EANResponseHotelInformation;

/**
 * @property int $hotelId The EAN ID of the hotel.
 * @property string $options A comma-delimited list of registered options.
 * @property string[] $optionsArray An array of registered options.
 * @property EANResponseHotelInformation $response Yea, the response. OK?
 */
class EANHotelInformation extends EANAbstractQuery {
	
	/**
	 * @var string
	 */
	protected static $API_METHOD = 'info';
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelInformationRequest';
	
	/**
	 * @var string
	 */
	protected static $RESPONSE_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANResponseHotelInformation';
	
	/**
	 * @var string
	 */
	const OPTIONS_DEFAULT = 'DEFAULT';
	
	/**
	 * @var string
	 */
	const OPTIONS_HOTEL_SUMMARY = 'HOTEL_SUMMARY';
	
	/**
	 * @var string
	 */
	const OPTIONS_HOTEL_DETAILS = 'HOTEL_DETAILS';
	
	/**
	 * @var string
	 */
	const OPTIONS_SUPPLIERS = 'SUPPLIERS';
	
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
	 * @var int
	 */
	protected $hotelId;
	
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
	 * @see EANHotelInformation::clearOptions()
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
