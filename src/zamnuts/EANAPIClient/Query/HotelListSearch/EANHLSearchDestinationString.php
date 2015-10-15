<?php

namespace zamnuts\EANAPIClient\Query\HotelListSearch;

use zamnuts\EANAPIClient\Util\ObjectBase;

/**
 * @property string $destinationString A string containing at least a city name. You can also send city and state, city and country, city/state/country, etc.
 */
class EANHLSearchDestinationString extends ObjectBase implements IEANHLSearch {
	
	/**
	 * A string containing at least a city name. You can also send city and state, 
	 * city and country, city/state/country, etc. Ambiguous entries will return an 
	 * error containing a list of likely intended locations, including their 
	 * destinationId whenever possible. 
	 * @see EANHLSearchDestinationId
	 * @var string
	 */
	protected $destinationString;
	
	/**
	 * @param string $destinationString
	 */
	public function __construct($destinationString=null) {
		$this->set__destinationString($destinationString);
	}
	
	/**
	 * @return string
	 */
	protected function get__destinationString() {
		return $this->destinationString;
	}
	
	/**
	 * @param string $value
	 */
	protected function set__destinationString($value) {
		$value = trim((string) $value);
		if ( $value ) {
			$this->destinationString = $value;
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Query\HotelListSearch\IEANHLSearch::isValid()
	 */
	public function isValid() {
		return isset($this->destinationString)
			&& $this->destinationString;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Query\HotelListSearch\IEANHLSearch::renderPreparedArray()
	 */
	public function renderPreparedArray() {
		return array(
			'destinationString' => isset($this->destinationString)?$this->destinationString:''
		);
	}
	
}
