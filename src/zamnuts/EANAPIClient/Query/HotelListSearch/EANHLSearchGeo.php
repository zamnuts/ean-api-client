<?php

namespace zamnuts\EANAPIClient\Query\HotelListSearch;

use zamnuts\EANAPIClient\Util\ObjectBase;
use zamnuts\EANAPIClient\Util\MathUtils;

/**
 * @property float $latitude Required, in the format DD.MMmmm, auto-clamps values
 * @property float $longitude Required, in the format DDD.MMmmm, auto-rolls values
 * @property int $searchRadius Optional, be sure to set searchRadiusUnit first!
 * @property string $searchRadiusUnit Optional, defaults to miles when `searchRadius` is used. Set with a SEARCH_RADIUS_* constant. Automatically converts searchRadius when changed.
 */
class EANHLSearchGeo extends ObjectBase implements IEANHLSearch {
	
	const SEARCH_RADIUS_MILES = 'MI';
	
	const SEARCH_RADIUS_KILOMETERS = 'KM';
	
	const SEARCH_RADIUS_MILES_MIN = 2;
	
	const SEARCH_RADIUS_MILES_MAX = 50;

	const SEARCH_RADIUS_KILOMETERS_MIN = 2;
	
	const SEARCH_RADIUS_KILOMETERS_MAX = 80;
	
	/**
	 * @var float
	 */
	protected $latitude;
	
	/**
	 * @var float
	 */
	protected $longitude;
	
	/**
	 * 
	 * @var int
	 */
	protected $searchRadius;
	
	/**
	 * @var string
	 */
	protected $searchRadiusUnit;
	
	protected static $propertyMap = array(
		'latitude' => 'float',
		'longitude' => 'float',
		'searchRadius' => 'int',
		'searchRadiusUnit' => 'string'
	);
	
	/**
	 * Supply initial latitude and longitude values, optionally. Although these ARE required for validity. 
	 * Radius unit and radius are completely optional. Although, if search radius is set, then the unit is 
	 * automatically set if not already. It is advised to set the unit BEFORE the radius. 
	 * @param float $latitude
	 * @param float $longitude
	 * @param int $searchRadiusUnit
	 * @param string $searchRadius
	 */
	public function __construct($latitude=null,$longitude=null,$searchRadiusUnit=null,$searchRadius=null) {
		$this->set__latitude($latitude);
		$this->set__longitude($longitude);
		if ( isset($searchRadiusUnit) ) {
			$this->set__searchRadiusUnit($searchRadiusUnit);
		}
		if ( isset($searchRadius) ) {
			$this->set__searchRadius($searchRadius);
		}
	}
	
	/**
	 * @return float
	 */
	protected function get__latitude() {
		return $this->latitude;
	}
	
	/**
	 * Clamp to either -90.0 or +90.0. 
	 * @param float $value
	 */
	protected function set__latitude($value) {
		$this->latitude = MathUtils::normalizeLatitude($value);
	}
	
	/**
	 * @return float
	 */
	protected function get__longitude() {
		return $this->longitude;
	}
	
	/**
	 * Normalize between -180.0 and +180.0. 
	 * @param float $value
	 */
	protected function set__longitude($value) {
		$this->longitude = MathUtils::normalizeLongitude($value);
	}
	
	/**
	 * @return int
	 */
	protected function get__searchRadius() {
		return $this->searchRadius;
	}
	
	/**
	 * Auto-inits `searchRadiusUnit` if not defined. 
	 * Bounds to unit's MIN and MAX constants: SEARCH_RADIUS_*_{MIN,MAX}. 
	 * @param int $value
	 */
	protected function set__searchRadius($value) {
		if ( !isset($this->searchRadiusUnit) ) {
			$this->set__searchRadiusUnit(); // give a default if not defined
		}
		$value = round((int) $value);
		if ( $this->searchRadiusUnit === self::SEARCH_RADIUS_MILES ) {
			$value = MathUtils::bound($value,self::SEARCH_RADIUS_MILES_MIN,self::SEARCH_RADIUS_MILES_MAX);
		} else {
			$value = MathUtils::bound($value,self::SEARCH_RADIUS_KILOMETERS_MIN,self::SEARCH_RADIUS_KILOMETERS_MAX);
		}
		$this->searchRadius = $value;
	}
	
	/**
	 * @return string
	 */
	protected function get__searchRadiusUnit() {
		return $this->searchRadiusUnit;
	}
	
	/**
	 * Will match SEARCH_RADIUS_* constants. 
	 * Will also convert human-like units (e.g. m, mile, or miles) to values that correspond with SEARCH_RADIUS_* automatically. 
	 * If the unit was changed from its previous setting, automatically converts `searchRadius` from the old unit to the new unit. 
	 * @param string $value
	 */
	protected function set__searchRadiusUnit($value=null) {
		$originalValue = $this->searchRadiusUnit;
		$value = strtoupper(trim((string) $value));
		if ( !$value ) {
			$this->searchRadiusUnit = self::SEARCH_RADIUS_MILES;
		} else if ( in_array($value,array(self::SEARCH_RADIUS_KILOMETERS,self::SEARCH_RADIUS_MILES)) ) {
			$this->searchRadiusUnit = $value;
		} else if ( preg_match('/^m(ile(s)*)?$/i',$value) ) {
			$this->searchRadiusUnit = self::SEARCH_RADIUS_MILES;
		} else if ( preg_match('/^k(ilomet(er|re)(s)*)?$/i',$value) ) {
			$this->searchRadiusUnit = self::SEARCH_RADIUS_KILOMETERS;
		}
		if ( isset($this->searchRadius) && $originalValue != $this->searchRadiusUnit ) {
			if ( $this->searchRadiusUnit === self::SEARCH_RADIUS_MILES ) {
				$this->set__searchRadius(MathUtils::kilometersToMiles($this->searchRadius));
			} else {
				$this->set__searchRadius(MathUtils::milesToKilometers($this->searchRadius));
			}
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Query\HotelListSearch\IEANHLSearch::isValid()
	 */
	public function isValid() {
		if ( isset($this->latitude,$this->longitude) ) {
			if ( isset($this->searchRadius) && !isset($this->searchRadiusUnit) ) {
				return false;
			} else if ( isset($this->searchRadiusUnit) && !isset($this->searchRadius) ) {
				return false;
			}
			return true;
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
