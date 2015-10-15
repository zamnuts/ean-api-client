<?php

namespace zamnuts\EANAPIClient\Query\HotelListSearch;

use zamnuts\EANAPIClient\Util\ObjectBase;
use zamnuts\EANAPIClient\Util\GeoLists;

/**
 * @property string $countryCode Required. Two character ISO-3166 code for the country containing the specified city.
 * @property string $city Required. City to search within. Use only full city names.
 * @property string $stateProvinceCode Required for US, CA and AU only. Two character code for the state/province containing the specified city.
 */
class EANHLSearchLocation extends ObjectBase implements IEANHLSearch {
	
	/**
	 * @var string
	 */
	protected $city;
	
	/**
	 * @var string
	 */
	protected $stateProvinceCode;
	
	/**
	 * @var string
	 */
	protected $countryCode;
	
	/**
	 * Optional. Requires city and countryCode parameters to be defined.
	 * @var string
	 */
	public $address;
	
	/**
	 * Optional. Requires city and countryCode parameters to be defined.
	 * @var string
	 */
	public $postalCode;
	
	/**
	 * Optional. Requires city and countryCode parameters to be defined.
	 * @var string
	 */
	public $propertyName;
	
	protected static $propertyMap = array(
		'city' => 'string',
		'stateProvinceCode' => 'string',
		'countryCode' => 'string',
		'address' => 'string',
		'postalCode' => 'string',
		'propertyName' => 'string'
	);
	
	/**
	 * Country is always required. 
	 * City is always required. 
	 * State/province/territory codes are required for countries US, CA and AU. 
	 * When setting them here in the constructor, the state/province/territory is verified 
	 * to be in the country, if it is not then it is not set. 
	 * @param string $countryCode
	 * @param string $city
	 * @param string $stateProvinceCode Only required for countries US, CA and AU.
	 */
	public function __construct($countryCode=null,$city=null,$stateProvinceCode=null) {
		$this->set__countryCode($countryCode);
		$this->set__city($city);
		$this->set__stateProvinceCode($stateProvinceCode,true);
	}
	
	/**
	 * @return string
	 */
	protected function get__city() {
		return $this->city;
	}
	
	/**
	 * @param string $value
	 */
	protected function set__city($value) {
		$value = trim((string) $value);
		if ( $value ) {
			$this->city = $value;
		}
	}
	
	/**
	 * @return string
	 */
	protected function get__stateProvinceCode() {
		return $this->stateProvinceCode;
	}
	
	/**
	 * Set $strict to true when calling this manually, rather than 
	 * via ObjectBase::__get, if the $value should be a state in the 
	 * current known country (if not, the stateProvinceCode will not 
	 * be modified). 
	 * @param string $value
	 * @param boolean $strict
	 */
	protected function set__stateProvinceCode($value,$strict=false) {
		$value = strtoupper(trim((string) $value));
		if ( $value ) {
			if ( isset($strict,$this->countryCode) && $strict ) {
				if ( GeoLists::isStateInCountry($value,$this->countryCode) ) {
					$this->stateProvinceCode = $value;
				}
			} else if ( GeoLists::isStateInAnyCountry($value) ) {
				$this->stateProvinceCode = $value;
			}
		}
	}
	
	/**
	 * @return string
	 */
	protected function get__countryCode() {
		return $this->countryCode;
	}
	
	/**
	 * @param string $value
	 */
	protected function set__countryCode($value) {
		$value = strtoupper(trim((string) $value));
		if ( $value && GeoLists::isCountry($value) ) {
			$this->countryCode = $value;
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Query\HotelListSearch\IEANHLSearch::isValid()
	 */
	public function isValid() {
		if ( isset($this->city,$this->countryCode) && $this->city && $this->countryCode ) {
			if ( in_array($this->countryCode,array('AU','CA','US')) ) {
				if ( isset($this->stateProvinceCode) && GeoLists::isStateInCountry($this->stateProvinceCode,$this->countryCode) ) {
					return true;
				}
			} else {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Query\HotelListSearch\IEANHLSearch::renderPreparedArray()
	 */
	public function renderPreparedArray() {
		$array = array();
		foreach ( self::$propertyMap as $key => $type ) {
			if ( isset($this->$key) ) {
				$array[$key] = $this->$key;
			}
		}
		return $array;
	}
	
}
