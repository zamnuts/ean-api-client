<?php

namespace zamnuts\EANAPIClient\Query;

// if these change, be sure to update $searchMethodMap and $hlSearchInterfacePath...
use zamnuts\EANAPIClient\Query\LandmarkListSearch\IEANHLSearch;
use zamnuts\EANAPIClient\Query\LandmarkListSearch\EANHLSearchDestinationString;

use \DateTime;
use zamnuts\EANAPIClient\Common\SupportModels\EANResponseLandmarkList;
use zamnuts\EANAPIClient\Common\SupportModels\EANResponseHotelList;
use zamnuts\EANAPIClient\Common\SupportModels\EANRoomGroup;

/*
 * TODO: this is half-baked and incomplete, need to finish at some point...
 * Both the request and response classes do not properly reflect the actual data structure.
 * I don't even think this part of the API will work right now. Leaving it as-is.
 */

/**
 * @property-read EANResponseHotelList $response
 * @property-read int $searchMethodType One of the SEARCH_METHOD_* constants.
 * @property-read string $searchMethodClass The class path to the currently defined search method.
 * @property int $numberOfResults Defaults to 20, only between 1 and 200.
 * @property DateTime $arrivalDate Optional.
 * @property DateTime $departureDate Optional.
 * @property int $propertyCategory
 * @property-read int[] $propertyCategoryArray
 * @property EANRoomGroup $roomGroup Optional.
 * @property float $maxStarRating Between 1.0 and 5.0 in increments of 0.5, inclusive
 * @property float $minStarRating Between 1.0 and 5.0 in increments of 0.5, inclusive
 * @property float $minRate Values must be positive, inclusive
 * @property float $maxRate Values must be positive, inclusive
 * @property int $numberOfBedRooms Maximium of 4. Only valid when using PROPERTY_CATEGORY_VR.
 * @property int $maxRatePlanCount Always keep at 1, unless you know otherwise.
 * @property string $supplierType Use one of the SUPPLIER_TYPE_* constants, typically only SUPPLIER_TYPE_E should be used.
 * @property string $sort Use one of the SORT_* constants, default is SORT_OVERALL_VALUE.
 */
class EANLandmarkList extends EANAbstractQuery {
	
	/**
	 * @var string
	 */
	protected static $API_METHOD = 'geoSearch';
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'LocationInfoRequest';
	
	/**
	 * @var string
	 */
	protected static $RESPONSE_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANResponseLandmarkList';
	
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
	protected $type = 1;
	
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
		1 => 'zamnuts\\EANAPIClient\\Query\\LandmarkListSearch\\EANHLSearchDestinationString'
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
	protected static $hlSearchInterfacePath = 'zamnuts\\EANAPIClient\\Query\\LandmarkListSearch\\IEANHLSearch';
	
	protected static $propertyMap = array(
		'type' => 'int'
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
	
	// Type
	protected function get__type() {
		return $this->type;
	}
	
	protected function set__type($value) {
		$value = (int) $value;
		$this->type = $value;
	}

}
