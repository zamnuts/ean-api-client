<?php

namespace zamnuts\EANAPIClient\Query\HotelItinerary;

use \DateTime;
use zamnuts\EANAPIClient\Util\ObjectBase;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property DateTime $creationDateStart
 * @property DateTime $creationDateEnd
 * @property DateTime $departureDateStart
 * @property DateTime $departureDateEnd
 * @property boolean $includeChildAffiliates
 */
class EANItineraryQueryObject extends ObjectBase {
	
	/**
	 * @var DateTime
	 */
	protected $creationDateStart;

	/**
	 * @var DateTime
	 */
	protected $creationDateEnd;

	/**
	 * @var DateTime
	 */
	protected $departureDateStart;

	/**
	 * @var DateTime
	 */
	protected $departureDateEnd;

	/**
	 * @var boolean
	 */
	protected $includeChildAffiliates;
	
	protected static $propertyMap = array(
		'creationDateStart' => 'DateTime',
		'creationDateEnd' => 'DateTime',
		'departureDateStart' => 'DateTime',
		'departureDateEnd' => 'DateTime',
		'includeChildAffiliates' => 'boolean'
	);
	
	// creation date
	protected function get__creationDateStart() {
		return $this->creationDateStart;
	}
	
	protected function set__creationDateStart($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->creationDateStart = new DateTime($date);
	}
	
	protected function get__creationDateEnd() {
		return $this->creationDateEnd;
	}
	
	protected function set__creationDateEnd($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->creationDateEnd = new DateTime($date);
	}
	
	// departure date
	protected function get__departureDateStart() {
		return $this->departureDateStart;
	}
	
	protected function set__departureDateStart($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->departureDateStart = new DateTime($date);
	}
	
	protected function get__departureDateEnd() {
		return $this->departureDateEnd;
	}
	
	protected function set__departureDateEnd($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->departureDateEnd = new DateTime($date);
	}
	
	// child affiliates
	protected function get__includeChildAffiliates() {
		return $this->includeChildAffiliates;
	}
	
	protected function set__includeChildAffiliates($value) {
		$this->includeChildAffiliates = Utils::anyToBoolean($value);
	}
	
	// helpers
	/**
	 * Provide start and end dates as either instances of DateTime 
	 * or something that DateTime can understand.
	 * @param DateTime|string $start
	 * @param DateTime|string $end
	 */
	public function setCreateDateRange($start,$end) {
		$this->set__creationDateStart($start);
		$this->set__creationDateEnd($end);
	}
	
	/**
	 * Provide start and end dates as either instances of DateTime
	 * or something that DateTime can understand.
	 * @param DateTime|string $start
	 * @param DateTime|string $end
	 */
	public function setDepartureDateRange($start,$end) {
		$this->set__departureDateStart($start);
		$this->set__departureDateEnd($end);
	}
	
	/**
	 * This class doesn't offer an underlying XML object, 
	 * instead use this method to fetch a prepared array 
	 * with values suitable for the EAN API. Form the request 
	 * XML object by other means.
	 * @return string[]
	 */
	public function getRequestArray() {
		$arr = array();
		foreach ( static::$propertyMap as $property => $type ) {
			if ( !isset($this->$property) ) {
				continue;
			}
			switch ( $type ) {
				case 'DateTime':
					$arr[$property] = (string) $this->$property->format('m/d/Y');
					break;
				case 'boolean':
					$arr[$property] = (string) $this->$property?'true':'false';
					break;
			}
		}
		return $arr;
	}
	
}
