<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\XMLUtils;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property-read string[] $amenities Built using $amenitiesMaskMap against $amenityMask, a list of amenity strings.
 * @property string $name
 * @property string $deepLink
 * @property boolean $hotelInDestination
 * @property string $locationDescription This is HTML (I'm assuming? unconfirmed).
 * @property string $shortDescription This is HTML.
 * @property string $supplierType Corresponds to EANResponseHotelList::SUPPLIER_TYPE_* constants.
 * @property string $thumbNailUrl Absolute URL to a downloadable thumbnail URL.
 * @property-read EANRoomRateDetailsList $roomRateDetailsList
 */
class EANHotelSummary extends EANAbstractSupportModel implements IEANSupportModel {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelSummary';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var string
	 */
	public static $THUMBNAIL_URL_PREFIX = 'http://images.travelnow.com'; // no trailing slash needed
	
	/**
	 * @var string[]
	 */
	public static $amenitiesMaskMap = array(
		'1' => 'Business Center',
		'2' => 'Fitness Center',
		'4' => 'Hot Tub On-site',
		'8' => 'Internet Access Available',
		'16' => 'Kids\' Activities',
		'32' => 'Kitchen or Kitchenette',
		'64' => 'Pets Allowed',
		'128' => 'Pool',
		'256' => 'Restaurant On-site',
		'512' => 'Spa On-site',
		'1024' => 'Whirlpool Bath Available',
		'2048' => 'Breakfast',
		'4096' => 'Babysitting',
		'8192' => 'Jacuzzi',
		'16384' => 'Parking',
		'32768' => 'Room Service ',
		'65536' => 'Accessible Path of Travel',
		'131072' => 'Accessible Bathroom',
		'262144' => 'Roll-in Shower',
		'524288' => 'Handicapped Parking',
		'1048576' => 'In-room Accessibility ',
		'2097152' => 'Accessibility Equipment for the Deaf',
		'4194304' => 'Braille or Raised Signage',
		'8388608' => 'Free Airport Shuttle',
		'16777216' => 'Indoor Pool',
		'33554432' => 'Outdoor Pool',
		'67108864' => 'Extended Parking',
		'134217728' => 'Free Parking',
	);
	
	/**
	 * @var int
	 */
	public $order;
	
	/**
	 * @var int
	 */
	public $ubsScore;
	
	/**
	 * @var int
	 */
	public $hotelId;
	
	/**
	 * @var string
	 */
	protected $name;
	
	/**
	 * @var string
	 */
	public $address1;

	/**
	 * @var string
	 */
	public $city;
	
	/**
	 * @var string
	 */
	public $stateProvinceCode;
	
	/**
	 * @var string
	 */
	public $postalCode;
	
	/**
	 * @var string
	 */
	public $countryCode;
	
	/**
	 * @var string
	 */
	public $airportCode;
	
	/**
	 * @var string
	 */
	protected $supplierType;
	
	/**
	 * @var int
	 */
	public $propertyCategory;
	
	/**
	 * @var float
	 */
	public $hotelRating;
	
	/**
	 * @var int
	 */
	public $confidenceRating;
	
	/**
	 * @var int
	 */
	public $amenityMask;
	
	/**
	 * @var float
	 */
	public $tripAdvisorRating;
	
	/**
	 * @var int
	 */
	public $tripAdvisorReviewCount;
	
	/**
	 * @var string
	 */
	public $tripAdvisorRatingUrl;
	
	/**
	 * @var string
	 */
	protected $locationDescription;
	
	/**
	 * @var string
	 */
	protected $shortDescription;
	
	/**
	 * @var float
	 */
	public $highRate;
	
	/**
	 * @var float
	 */
	public $lowRate;
	
	/**
	 * @var string
	 */
	public $rateCurrencyCode;
	
	/**
	 * @var float
	 */
	public $latitude;
	
	/**
	 * @var float
	 */
	public $longitude;
	
	/**
	 * @var float
	 */
	public $proximityDistance;
	
	/**
	 * @var string
	 */
	public $proximityUnit;
	
	/**
	 * @var boolean
	 */
	protected $hotelInDestination;
	
	/**
	 * @var string
	 */
	protected $thumbNailUrl;
	
	/**
	 * @var string
	 */
	protected $deepLink;
	
	/**
	 * @var EANRoomRateDetailsList
	 */
	protected $roomRateDetailsList;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'address1' => 'string',
		'airportCode' => 'string',
		'amenityMask' => 'int',
		'city' => 'string',
		'confidenceRating' => 'int',
		'countryCode' => 'string',
		'deepLink' => 'string',
		'highRate' => 'float',
		'hotelId' => 'int',
		'hotelInDestination' => 'boolean',
		'hotelRating' => 'float',
		'latitude' => 'float',
		'locationDescription' => 'string',
		'longitude' => 'float',
		'lowRate' => 'float',
		'name' => 'string',
		'order' => 'int',
		'postalCode' => 'string',
		'propertyCategory' => 'int',
		'proximityDistance' => 'float',
		'proximityUnit' => 'string',
		'rateCurrencyCode' => 'string',
		'roomRateDetailsList' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRoomRateDetailsList',
		'shortDescription' => 'string',
		'stateProvinceCode' => 'string',
		'supplierType' => 'string',
		'thumbNailUrl' => 'string',
		'tripAdvisorRating' => 'float',
		'tripAdvisorRatingUrl' => 'string',
		'tripAdvisorReviewCount' => 'int',
		'ubsScore' => 'int'
	);
	
	/**
	 * @var string[]
	 */
	protected static $attributeMap = array(
		'order' => 'int',
		'ubsScore' => 'int'
	);
	
	/**
	 * @param EANAbstractSupportModel $supportModel
	 * @return EANHotelSummary
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}	
	
	public function __construct() {
		parent::__construct();
		$this->initRoomRateDetailsList();
	}
	
	protected function get__name() {
		return $this->name;
	}
	
	protected function set__name($value) {
		$this->name = Utils::htmlEntitiesDecode($value);
	}
	
	protected function get__supplierType() {
		return $this->supplierType;
	}
	
	protected function set__supplierType($value) {
		$this->supplierType = strtoupper((string) $value);		
	}
	
	protected function get__amenities() {
		$arr = array();
		foreach ( self::$amenitiesMaskMap as $mask => $amenity ) {
			if ( $this->amenityMask & $mask ) {
				array_push($arr,$amenity);
			}
		}
		return $arr;
	}
	
	protected function get__locationDescription() {
		return $this->locationDescription;
	}
	
	protected function set__locationDescription($value) {
		$this->locationDescription = XMLUtils::tidyPartialHTMLToString($value,true);
	}
	
	protected function get__shortDescription() {
		return $this->shortDescription;
	}
	
	protected function set__shortDescription($value) {
		$this->shortDescription = XMLUtils::tidyPartialHTMLToString($value,true);
	}
	
	protected function get__thumbNailUrl() {
		return $this->thumbNailUrl;
	}
	
	protected function set__thumbNailUrl($value) {
		$value = (string) $value;
		$this->thumbNailUrl = $this->supplementUrlPrefix($value);
	}
	
	protected function get__hotelInDestination() {
		return $this->hotelInDestination;
	}
	
	protected function set__hotelInDestination($value) {
		$this->hotelInDestination = Utils::anyToBoolean($value);
	}
	
	protected function get__deepLink() {
		return $this->deepLink;
	}
	
	protected function set__deepLink($value) {
		$this->deepLink = Utils::htmlEntitiesDecode((string) $value);
	}
	
	protected function get__roomRateDetailsList() {
		$this->initRoomRateDetailsList();
		return clone $this->roomRateDetailsList;
	}
	
	/**
	 * @param EANRoomRateDetails $roomRateDetails
	 * @return boolean
	 */
	public function addRoomRateDetails(EANRoomRateDetails $roomRateDetails) {
		$this->initRoomRateDetailsList();
		return $this->roomRateDetailsList->addItem($roomRateDetails);
	}
	
	/**
	 * @param EANRoomRateDetails $roomDetails
	 * @return boolean
	 */ 
	public function removeRoomRateDetails(EANRoomRateDetails $roomDetails) {
		$this->initRoomRateDetailsList();
		$result = $this->roomRateDetailsList->removeItem($roomDetails);
		if ( !$this->roomRateDetailsList->length ) {
			$this->roomRateDetailsList = null;
		}
		return $result;
	}
	
	private function initRoomRateDetailsList($overwrite=false) {
		if ( $overwrite || !isset($this->roomRateDetailsList) || !($this->roomRateDetailsList instanceof EANRoomRateDetailsList) ) {
			$this->roomRateDetailsList = new EANRoomRateDetailsList();
		}
	}
	
	private function supplementUrlPrefix($url) {
		$parsed = parse_url($url);
		if ( isset($parsed['path']) ) {
			return rtrim(static::$THUMBNAIL_URL_PREFIX,'/').'/'.ltrim($parsed['path'],'/').(isset($parsed['query'])?'?'.$parsed['query']:'');
		}
		return null;
	}
	
}
