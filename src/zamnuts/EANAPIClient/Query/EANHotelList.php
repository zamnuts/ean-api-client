<?php

namespace zamnuts\EANAPIClient\Query;

// if these change, be sure to update $searchMethodMap and $hlSearchInterfacePath...
use zamnuts\EANAPIClient\Query\HotelListSearch\IEANHLSearch;
use zamnuts\EANAPIClient\Query\HotelListSearch\EANHLSearchLocation;
use zamnuts\EANAPIClient\Query\HotelListSearch\EANHLSearchHotelIds;
use zamnuts\EANAPIClient\Query\HotelListSearch\EANHLSearchDestinationString;
use zamnuts\EANAPIClient\Query\HotelListSearch\EANHLSearchDestinationId;
use zamnuts\EANAPIClient\Query\HotelListSearch\EANHLSearchGeo;

use \DateTime;
use zamnuts\EANAPIClient\Util\MathUtils;
use zamnuts\EANAPIClient\Util\XMLUtils;
use zamnuts\EANAPIClient\Common\SupportModels\EANResponseHotelList;
use zamnuts\EANAPIClient\Common\SupportModels\EANRoomGroup;
use zamnuts\EANAPIClient\Common\SupportModels\EANRoom;

/*
 * TODO: implement `supplierCacheTolerance` (for Turbo, i.e. cached responses)
 * TODO: add support for static/offline db files and the `options` param
 * TODO: update search method functions to use ReflectionClass
 */

/**
 * @property-read EANResponseHotelList $response
 * @property-read int $searchMethodType One of the SEARCH_METHOD_* constants.
 * @property-read string $searchMethodClass The class path to the currently defined search method.
 * @property int $numberOfResults Defaults to 20, only between 1 and 200.
 * @property DateTime $arrivalDate Optional.
 * @property DateTime $departureDate Optional.
 * @property string $propertyCategory
 * @property-read int[] $propertyCategoryArray
 * @property EANRoomGroup $roomGroup Optional.
 * @property float $maxStarRating Between 1.0 and 5.0 in increments of 0.5, inclusive
 * @property float $minStarRating Between 1.0 and 5.0 in increments of 0.5, inclusive
 * @property float $minRate Values must be positive, inclusive
 * @property float $maxRate Values must be positive, inclusive
 * @property int $numberOfBedRooms Maximium of 4. Only valid when using PROPERTY_CATEGORY_VR.
 * @property int $maxRatePlanCount Always keep at 1, unless you know otherwise.
 * @property string $supplierType Use one of the SUPPLIER_TYPE_* constants, typically only SUPPLIER_TYPE_E should be used.
 * @property string $cacheKey Cache Key to use for pagination
 * @property string $cacheLocation Cache Location to use for pagination
 * @property string $sort Use one of the SORT_* constants, default is SORT_OVERALL_VALUE.
 */
class EANHotelList extends EANAbstractQuery {
	
	/**
	 * @var string
	 */
	protected static $API_METHOD = 'list';
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelListRequest';
	
	/**
	 * @var string
	 */
	protected static $RESPONSE_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANResponseHotelList';
	
	/**
	 * City/state/country search, with related secondary search options.
	 * @var int
	 */
	const SEARCH_METHOD_LOCATION = 1;
	
	/**
	 * Use a free text destination string.
	 * @var int
	 */
	const SEARCH_METHOD_DESTINATION_STRING = 2;
	
	/**
	 * Use a destination identifier.
	 * @var int
	 */
	const SEARCH_METHOD_DESTINATION_ID = 3;
	
	/**
	 * Use a list of hotel identifiers.
	 * @var int
	 */
	const SEARCH_METHOD_HOTEL_IDS = 4;
	
	/**
	 * Search within a geographical area.
	 * @var int
	 */
	const SEARCH_METHOD_GEO = 5;
	
	/**
	 * @var float
	 */
	const STAR_RATING_MAX = 5.0;
	
	/**
	 * @var float
	 */
	const STAR_RATING_MIN = 1.0;
	
	/**
	 * Property Category: Hotel
	 * @var int
	 */
	const PROPERTY_CATEGORY_HOTEL = 1;
	
	/**
	 * Property Category: Suite
	 * @var int
	 */
	const PROPERTY_CATEGORY_SUITE = 2;
	
	/**
	 * Property Category: Resort
	 * @var int
	 */
	const PROPERTY_CATEGORY_RESORT = 3;
	
	/**
	 * Property Category: Vacation Rental/Condo
	 * @var int
	 */
	const PROPERTY_CATEGORY_VR = 4;
	
	/**
	 * Property Category: Bed and Breakfast
	 * @var int
	 */
	const PROPERTY_CATEGORY_BB = 5;
	
	/**
	 * Property Category: All-Inclusive
	 * @var int
	 */
	const PROPERTY_CATEGORY_AI = 6;

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
	 * Supplier Type: Expedia Collect and Venere
	 * @var string
	 */
	const SUPPLIER_TYPE_EV = 'E|V';

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
	 * Used only in conjunction with hotelIdList. Returns hotels in the exact order listed in the request.
	 *@var string
	 */
	const SORT_NO_SORT = 'NO_SORT';
	
	/**
	 * Properties within the specified city are ordered above properties in surrounding areas.
	 *@var string
	 */
	const SORT_CITY_VALUE = 'CITY_VALUE';
	
	/**
	 * Places preferred, best-converting properties at the top.
	 *@var string
	 */
	const SORT_OVERALL_VALUE = 'OVERALL_VALUE';
	
	/**
	 * Places properties with a promo rate or value add above properties not running promotions.
	 *@var string
	 */
	const SORT_PROMO = 'PROMO';
	
	/**
	 * Sorts properties by nightly rate from low to high. Accurate price sorting is best achieved within your own code after results are received.
	 *@var string
	 */
	const SORT_PRICE = 'PRICE';
	
	/**
	 * Sorts properties by nightly rate from high to low. Expect imperfect sort like SORT_PRICE.
	 *@var string
	 */
	const SORT_PRICE_REVERSE = 'PRICE_REVERSE';
	
	/**
	 * Sorts properties by average nightly rate from low to high. Expect imperfect sort like SORT_PRICE.
	 *@var string
	 */
	const SORT_PRICE_AVERAGE = 'PRICE_AVERAGE';
	
	/**
	 * Sorts by property star rating from high to low.
	 *@var string
	 */
	const SORT_QUALITY = 'QUALITY';
	
	/**
	 * Sorts by property star rating from low to high.
	 *@var string
	 */
	const SORT_QUALITY_REVERSE = 'QUALITY_REVERSE';
	
	/**
	 * Sorts properties alphabetically
	 *@var string
	 */
	const SORT_ALPHA = 'ALPHA';
	
	/**
	 * Sorts based on proximity to the origin point defined via latitude & longitude parameters.
	 *@var string
	 */
	const SORT_PROXIMITY = 'PROXIMITY';
	
	/**
	 * Sorts via postal code, from alphanumerically lower codes to higher codes.
	 *@var string
	 */
	const SORT_POSTAL_CODE = 'POSTAL_CODE';
	
	/**
	 * Hotel Collect properties only. Best-performing properties return first.
	 *@var string
	 */
	const SORT_CONFIDENCE = 'CONFIDENCE';
	
	/**
	 * Places Expedia Collect properties first, but sorts Hotel Collect properties thereafter by their confidence level.
	 *@var string
	 */
	const SORT_MARKETING_CONFIDENCE = 'MARKETING_CONFIDENCE';
	
	/**
	 * If you have an approved TripAdvisor integration, this value will sort results from high to low guest ratings.
	 *@var string
	 */
	const SORT_TRIP_ADVISOR = 'TRIP_ADVISOR';
	
	/**
	 * @var int
	 */
	protected $activePropertyCount;
	
	/**
	 * @var int
	 */
	protected $numberOfResults = 20;
	
	/**
	 * @var DateTime
	 */
	protected $arrivalDate;
	
	/**
	 * @var DateTime
	 */
	protected $departureDate;
	
	/**
	 * Default: false
	 * @var boolean
	 */
	public $includeDetails = false;
	
	/**
	 * Default: false
	 * @var boolean
	 */
	public $includeHotelFeeBreakdown = false;
	
	/**
	 * Default: true
	 * @var boolean
	 */
	public $includeSurrounding = true;
	
	/**
	 * @var string[]
	 */
	protected $propertyCategoryList = array();
	
	/**
	 * @var EANRoomGroup
	 */
	protected $roomGroup;
	
	/**
	 * @var float
	 */
	protected $maxStarRating;
	
	/**
	 * @var float
	 */
	protected $minStarRating;
	
	/**
	 * @var float
	 */
	protected $maxRate;
	
	/**
	 * @var float
	 */
	protected $minRate;
	
	/**
	 * @var int
	 */
	protected $numberOfBedRooms;
	
	/**
	 * Default: 1
	 * @see http://developer.ean.com/docs/hotel-list/#maxRatePlanCount
	 * @var int
	 */
	protected $maxRatePlanCount = 1;
	
	/**
	 * Default: 'E'
	 * @var string
	 */
	protected $supplierType = 'E';

	/**
	 * @var string
	 */
	protected $cacheKey;

	/**
	 * @var string
	 */
	protected $cacheLocation;

	/**
	 * Default: SORT_OVERALL_VALUE
	 * @var string
	 */
	protected $sort = 'OVERALL_VALUE';
	
	/**
	 * @var int
	 */
	protected $searchMethodType;
	
	/**
	 * @var IEANHLSearch
	 */
	protected $searchMethod;
	
	/**
	 * @var EANResponseHotelList
	 */
	protected $response;
	
	/**
	 * @var string[]
	 */
	protected static $searchMethodMap = array(
		1 => 'zamnuts\\EANAPIClient\\Query\\HotelListSearch\\EANHLSearchLocation',
		2 => 'zamnuts\\EANAPIClient\\Query\\HotelListSearch\\EANHLSearchDestinationString',
		3 => 'zamnuts\\EANAPIClient\\Query\\HotelListSearch\\EANHLSearchDestinationId',
		4 => 'zamnuts\\EANAPIClient\\Query\\HotelListSearch\\EANHLSearchHotelIds',
		5 => 'zamnuts\\EANAPIClient\\Query\\HotelListSearch\\EANHLSearchGeo'
	);
	
	/**
	 * @var string[]
	 */
	public static $propertyCategoryMap = array(
		1 => 'Hotel',
		2 => 'Suite',
		3 => 'Resort',
		4 => 'Vacation Rental/Condo',
		5 => 'Bed and Breakfast',
		6 => 'All-Inclusive'
	);
	
	/**
	 * @var string
	 */
	protected static $hlSearchInterfacePath = 'zamnuts\\EANAPIClient\\Query\\HotelListSearch\\IEANHLSearch';
	
	protected static $propertyMap = array(
		'arrivalDate' => 'DateTime',
		'departureDate' => 'DateTime',
		'numberOfResults' => 'int',
		'roomGroup' => 'EANRoomGroup',
		'includeDetails' => 'boolean',
		'includeHotelFeeBreakdown' => 'boolean',
		'includeSurrounding' => 'boolean',
		'propertyCategory' => 'string',
		'maxStarRating' => 'float',
		'minStarRating' => 'float',
		'minRate' => 'float',
		'maxRate' => 'float',
		'numberOfBedRooms' => 'int',
		'supplierType' => 'string',
		'maxRatePlanCount' => 'int',
		'sort' => 'string',
		'cacheKey' => 'string',
		'cacheLocation' => 'string'
	);
	
	protected static $attributeMap = array(
		'activePropertyCount' => 'int'
	);
	
	public function __construct($searchMethod=2) {
		parent::__construct();
		if ( isset($searchMethod) ) {
			$this->setSearchMethodFuzzy($searchMethod);
		}
	}
	
	protected function prepareRequest() {
		// if we're working with a cached result, we can only send specific fields
		$cacheKey = $this->get__cacheKey();
		$cacheLocation = $this->get__cacheLocation();
		$supplierType = $this->get__supplierType();
		if ( isset($cacheKey,$cacheLocation) ) {
			$this->xmlRequest->cacheKey = $cacheKey;
			$this->xmlRequest->cacheLocation = $cacheLocation;
			if ( isset($supplierType) ) {
				$this->xmlRequest->supplierType = $supplierType;
			}
			return;
		}
		// not working with a cached result, so just prepare the request per usual
		if ( isset($this->searchMethod) ) {
			$searchMethodProperties = $this->searchMethod->renderPreparedArray();
			foreach ( $searchMethodProperties as $tag => $value ) {
				$this->xmlRequest->addChild($tag,(string) $value);
			}
		}
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
	 * @return EANResponseHotelList
	 */
	protected function get__response() {
		if ( isset($this->response) ) {
			return clone $this->response;
		}
		return null;
	}
	
	// Search Methods
	protected function get__searchMethodType() {
		return $this->searchMethodType;
	}
	
	protected function get__searchMethodClass() {
		return get_class($this->searchMethod);
	}
	
	/**
	 * Get a read-only version of the current search method hash map.
	 * @return array
	 */
	public static function getSearchMethodMap() {
		return self::$searchMethodMap;
	}
	
	/**
	 * Get a read-only string path to the IEANHLSearch interface.
	 * @return string
	 */
	public static function getSearchMethodInterface() {
		return self::$hlSearchInterfacePath;
	}
	
	/**
	 * Get a copy of the current search method class. 
	 * Changes made to the object will not affect the instance 
	 * in this class; use one of the setSearchMethod* methods to 
	 * update it. 
	 * @return \zamnuts\EANAPIClient\Query\HotelListSearch\IEANHLSearch
	 */
	public function getSearchMethod() {
		return clone $this->searchMethod;
	}
	
	/**
	 * Alias for getSearchMethod, only good for type hinting and code completion in IDE.
	 * @return \zamnuts\EANAPIClient\Query\HotelListSearch\EANHLSearchLocation
	 */
	public function getSearchMethodAsLocation() {
		return $this->getSearchMethod();
	}
	
	/**
	 * Alias for getSearchMethod, only good for type hinting and code completion in IDE.
	 * @return \zamnuts\EANAPIClient\Query\HotelListSearch\EANHLSearchHotelIds
	 */
	public function getSearchMethodAsHotelIds() {
		return $this->getSearchMethod();
	}
	
	/**
	 * Alias for getSearchMethod, only good for type hinting and code completion in IDE.
	 * @return \zamnuts\EANAPIClient\Query\HotelListSearch\EANHLSearchGeo
	 */
	public function getSearchMethodAsGeo() {
		return $this->getSearchMethod();
	}
	
	/**
	 * Alias for getSearchMethod, only good for type hinting and code completion in IDE.
	 * @return \zamnuts\EANAPIClient\Query\HotelListSearch\EANHLSearchDestinationString
	 */
	public function getSearchMethodAsDestinationString() {
		return $this->getSearchMethod();
	}
	

	/**
	 * Alias for getSearchMethod, only good for type hinting and code completion in IDE.
	 * @return \zamnuts\EANAPIClient\Query\HotelListSearch\EANHLSearchDestinationId
	 */
	public function getSearchMethodAsDestinationId() {
		return $this->getSearchMethod();
	}
	
	/**
	 * Set the search method by an IEANHLSearch implementor. 
	 * The class instance must be registered in the 
	 * static $searchMethodMap array. 
	 * @param IEANHLSearch $searchMethod
	 * @return boolean
	 */
	public function setSearchMethod(IEANHLSearch $searchMethod) {
		if ( $searchMethod instanceof IEANHLSearch ) {
			$className = get_class($searchMethod);
			$key = array_search($className,self::$searchMethodMap);
			if ( $key !== false ) {
				$this->searchMethodType = (int) $key;
				$this->searchMethod = $searchMethod;
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Set the search method by a search method type constant. 
	 * Once it is set, it is also auto-instantiated, overwriting 
	 * the previously set search method. The class to be set 
	 * must be registered in the static $searchMethodMap array. 
	 * @see \zamnuts\EANAPIClient\Query\EANHotelList::registerSearchMethod()
	 * @param number $searchMethodType
	 * @return boolean Whether the type was successfully set or not.
	 */
	public function setSearchMethodType($searchMethodType) {
		$searchMethodType = (int) $searchMethodType;
		if ( $searchMethodType && isset(self::$searchMethodMap[$searchMethodType]) ) {
			return $this->setSearchMethod(new self::$searchMethodMap[$searchMethodType]());
		}
		return false;
	}
	
	/**
	 * Set the search method by a class name/path. The same rules 
	 * of setSearchMethodType apply to setSearchMethodClass. 
	 * @see \zamnuts\EANAPIClient\Query\EANHotelList::setSearchMethodType()
	 * @param string $searchMethodClass
	 * @return boolean Whether the class was successfully set or not.
	 */
	public function setSearchMethodClass($searchMethodClass) {
		$searchMethodClass = (string) $searchMethodClass;
		if ( $searchMethodClass && in_array($searchMethodClass,self::$searchMethodMap) ) {
			return $this->setSearchMethod(new $searchMethodClass());
		}
		return false;
	}
	
	/**
	 * Set the search method when the type (e.g. object, int, string) is 
	 * not known, possibly null, or some other disastrous "value".
	 * @param mixed $fuzzy What you think could be something related to a search method.
	 * @return boolean Whether it worked or not.
	 */
	public function setSearchMethodFuzzy($fuzzy=null) {
		if ( isset($fuzzy) && $fuzzy ) {
			if ( is_object($fuzzy) ) {
				return $this->setSearchMethod($fuzzy);
			} else if ( is_int($fuzzy) ) {
				return $this->setSearchMethodType($fuzzy);
			} else if ( is_string($fuzzy) ) {
				return $this->setSearchMethodClass($fuzzy);
			}
		}
		return false;
	}
	
	/**
	 * Register a custom search method class. The $id cannot 
	 * be prexisting and the $classPath must be a class that 
	 * implements IEANHLSearch. 
	 * @param int $id
	 * @param string $classPath
	 * @return boolean
	 */
	public static function registerSearchMethod($id,$classPath) {
		$id = (int) $id;
		$classPath = (string) $classPath;
		if ( !isset(self::$searchMethodMap[$id]) && $classPath && class_exists($classPath,false) ) {
			$implements = class_implements($classPath,false);
			if ( isset($implements[self::$hlSearchInterfacePath]) ) {
				self::$searchMethodMap[$id] = $classPath;
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Deregister a previously registered search method by id. 
	 * Predefined search methods cannot be removed.
	 * @param int $id
	 * @return boolean Whether it was deregistered successfully.
	 */
	public static function deregisterSearchMethod($id) {
		$id = (int) $id;
		if ( isset(self::$searchMethodMap[$id]) && $id < 1 && $id > 5 ) {
			unset(self::$searchMethodMap[$id]);
			return true;
		}
		return false;
	}
	
	// Number of Results
	protected function get__numberOfResults() {
		return $this->numberOfResults;
	}
	
	protected function set__numberOfResults($value) {
		$value = (int) $value;
		if ( $value > 0 ) {
			if ( $value > 200 ) {
				$value = 200;
			}
			$this->numberOfResults = $value;
		} else {
			$this->numberOfResults = 20;
		}
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
	
	// Property Categories
	protected function get__propertyCategory() {
		return implode(',',$this->get__propertyCategoryArray());
	}
	
	protected function get__propertyCategoryArray() {
		$propertyCategoryList = $this->propertyCategoryList;
		if ( !count($propertyCategoryList) ) {
			$this->propertyCategoryList = range(1,7);
		}
		return $this->propertyCategoryList;
	}
	
	protected function set__propertyCategory($value) {
		$value = (string) $value;
		$array = explode(',',$value);
		foreach ( $array as $category ) {
			$this->includePropertyCategory($category);
		}
	}
	
	/**
	 * @param int $category One of the PROPERTY_CATEGORY_* constants.
	 * @return boolean
	 */
	public function includePropertyCategory($category) {
		$category = (int) $category;
		if ( $category >= 1 && $category <= 7 ) {
			array_push($this->propertyCategoryList,$category);
			$this->propertyCategoryList = array_unique($this->propertyCategoryList,SORT_NUMERIC);
			return true;
		}
		return false;
	}
	
	/**
	 * @param int $category One of the PROPERTY_CATEGORY_* constants.
	 * @return boolean
	 */
	public function excludePropertyCategory($category) {
		$category = (int) $category;
		if ( $category >= 1 && $category <= 7 ) {
			$keys = array_keys($this->propertyCategoryList,$category,true);
			foreach ( $keys as $key ) {
				unset($this->propertyCategoryList[$key]);
			}
			$this->propertyCategoryList = array_values($this->propertyCategoryList);
		}
		return false;
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
	
	// Star Ratings
	protected function get__maxStarRating() {
		return $this->maxStarRating;
	}
	
	protected function set__maxStarRating($value) {
		$value = (float) $value;
		$this->maxStarRating = MathUtils::bound(MathUtils::roundHalf($value),self::STAR_RATING_MIN,self::STAR_RATING_MAX);
		if ( isset($this->minStarRating) && $this->maxStarRating < $this->minStarRating ) {
			$this->maxStarRating = $this->minStarRating;
		}
	}
	
	protected function get_minStarRating() {
		return $this->minStarRating;
	}
	
	protected function set__minStarRating($value) {
		$value = (float) $value;
		$this->minStarRating = MathUtils::bound(MathUtils::roundHalf($value),self::STAR_RATING_MIN,self::STAR_RATING_MAX);
		if ( isset($this->maxStarRating) && $this->minStarRating > $this->maxStarRating ) {
			$this->minStarRating = $this->maxStarRating;
		}
	}
	
	// Room Rates
	protected function get__maxRate() {
		return $this->maxRate;
	}
	
	protected function set__maxRate($value) {
		$value = (float) $value;
		if ( $value < 0 ) {
			$value = 0; // FREE ROOM!
		}
		$this->maxRate = $value;
		if ( isset($this->minRate) && $this->maxRate < $this->minRate ) {
			$this->maxRate = $this->minRate;
		}
	}
	
	protected function get__minRate() {
		return $this->minRate;
	}
	
	protected function set__minRate($value) {
		$value = (float) $value;
		if ( $value < 0 ) {
			$value = 0; // cheap bastard.
		}
		$this->minRate = $value;
		if ( isset($this->maxRate) && $this->minRate > $this->maxRate ) {
			$this->minRate = $this->maxRate;
		}
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
	
	// Max Rate Plan Count
	protected function get__maxRatePlanCount() {
		return $this->maxRatePlanCount;
	}
	
	protected function set__maxRatePlanCount($value) {
		$value = (int) $value;
		if ( $value < 1 ) {
			$value = 1;
		}
		$this->maxRatePlanCount = $value;
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

	// Pagination (caching)
	protected function get__cacheKey() {
		return $this->cacheKey;
	}

	protected function set__cacheKey($value) {
		$this->cacheKey = $value;
	}

	protected function get__cacheLocation() {
		return $this->cacheLocation;
	}

	protected function set__cacheLocation($value) {
		$this->cacheLocation = $value;
	}

	// Sort
	protected function get__sort() {
		return $this->sort;
	}
	
	protected function set__sort($value) {
		$value = substr(preg_replace('/[^A-Z_]/i','',strtoupper((string) $value)),0,256);
		$constStr = 'self::SORT_'.$value;
		if ( defined($constStr) ) {
			$this->sort = constant($constStr);
		}
	}
	
}
