<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property int $hotelId
 * @property string $statusCode
 * @property string $name
 * @property string $address1
 * @property string $address2
 * @property string $address3
 * @property string $city
 * @property string $stateProvinceCode
 * @property string $countryCode
 * @property string $postalCode
 * @property string $phone
 * @property string $fax
 * @property float $latitude
 * @property float $longitude
 * @property string $coordinateAccuracyCode
 * @property float $lowRate
 * @property float $highRate
 * @property int $confidence
 * @property float $hotelRating
 * @property string $market
 * @property string $region
 * @property string $superRegion
 * @property string $theme
 */
class EANHotelConfirmationDetails extends EANAbstractSupportModel implements IEANSupportModel {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'Hotel';
	
	/**
	 * Active
	 * @var string
	 */
	const STATUS_CODE_A = 'A';
	
	/**
	 * Inactive
	 * @var string
	 */
	const STATUS_CODE_I = 'I';
	
	/**
	 * Deleted
	 * @var string
	 */
	const STATUS_CODE_D = 'D';
	
	/**
	 * Removed
	 * @var string
	 */
	const STATUS_CODE_R = 'R';
	
	/**
	 * Confidenced
	 * @var string
	 */
	const STATUS_CODE_C = 'C';
	
	/**
	 * @var int
	 */
	protected $hotelId;
	
	/**
	 * @var string
	 */
	protected $statusCode;
	
	/**
	 * @var string
	 */
	protected $name;
	
	/**
	 * @var string
	 */
	protected $address1;
	
	/**
	 * @var string
	 */
	protected $address2;
	
	/**
	 * @var string
	 */
	protected $address3;
	
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
	 * @var string
	 */
	protected $postalCode;
	
	/**
	 * @var string
	 */
	protected $phone;
	
	/**
	 * @var string
	 */
	protected $fax;
	
	/**
	 * @var float
	 */
	protected $latitude;
	
	/**
	 * @var float
	 */
	protected $longitude;
	
	/**
	 * @var string
	 */
	protected $coordinateAccuracyCode;
	
	/**
	 * @var float
	 */
	protected $lowRate;
	
	/**
	 * @var float
	 */
	protected $highRate;
	
	/**
	 * @var int
	 */
	protected $confidence;
	
	/**
	 * @var float
	 */
	protected $hotelRating;
	
	/**
	 * @var string
	 */
	protected $market;
	
	/**
	 * @var string
	 */
	protected $region;
	
	/**
	 * @var string
	 */
	protected $superRegion;
	
	/**
	 * @var string
	 */
	protected $theme;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'hotelId' => 'int',
		'statusCode' => 'string',
		'name' => 'string',
		'address1' => 'string',
		'address2' => 'string',
		'address3' => 'string',
		'city' => 'string',
		'stateProvinceCode' => 'string',
		'countryCode' => 'string',
		'postalCode' => 'string',
		'phone' => 'string',
		'fax' => 'string',
		'latitude' => 'float',
		'longitude' => 'float',
		'coordinateAccuracyCode' => 'string',
		'lowRate' => 'float',
		'highRate' => 'float',
		'confidence' => 'int',
		'hotelRating' => 'float',
		'market' => 'string',
		'region' => 'string',
		'superRegion' => 'string',
		'theme' => 'string'
	);
	
	/**
	 * @param EANHotelConfirmationDetails $supportModel
	 * @return EANHotelConfirmationDetails
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * Checks if the given status code is a valid constant's value.
	 * @param string $value
	 * @return boolean
	 */
	public static function isStatusCode($value) {
		return defined('static::STATUS_CODE_'.$value) && constant('static::STATUS_CODE_'.$value) === $value;
	}
	protected function get__hotelId() {
		return $this->hotelId;
	}
	
	protected function get__statusCode() {
		return $this->statusCode;
	}
	
	protected function set__statusCode($value) {
		$value = strtoupper((string) $value);
		if ( static::isStatusCode($value) ) {
			$this->statusCode = $value;
		}
	}
	
	protected function get__name() {
		return $this->name;
	}
	
	protected function get__address1() {
		return $this->address1;
	}
	
	protected function get__address2() {
		return $this->address2;
	}
	
	protected function get__address3() {
		return $this->address3;
	}
	
	protected function get__city() {
		return $this->city;
	}
	
	protected function get__stateProvinceCode() {
		return $this->stateProvinceCode;
	}
	
	protected function get__countryCode() {
		return $this->countryCode;
	}
	
	protected function get__postalCode() {
		return $this->postalCode;
	}
	
	protected function get__phone() {
		return $this->phone;
	}
	
	protected function get__fax() {
		return $this->fax;
	}
	
	protected function get__latitude() {
		return $this->latitude;
	}
	
	protected function get__longitude() {
		return $this->longitude;
	}
	
	protected function get__coordinateAccuracyCode() {
		return $this->coordinateAccuracyCode;
	}
	
	protected function get__lowRate() {
		return $this->lowRate;
	}
	
	protected function get__highRate() {
		return $this->highRate;
	}
	
	protected function get__confidence() {
		return $this->confidence;
	}
	
	protected function get__hotelRating() {
		return $this->hotelRating;
	}
	
	protected function get__market() {
		return $this->market;
	}
	
	protected function get__region() {
		return $this->region;
	}
	
	protected function get__superRegion() {
		return $this->superRegion;
	}
	
	protected function get__theme() {
		return $this->theme;
	}
	
}
