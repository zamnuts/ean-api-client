<?php

namespace zamnuts\EANAPIClient\Query\HotelListSearch;

use zamnuts\EANAPIClient\Util\ObjectBase;

/**
 * @property-read int[] $hotelIdList
 * @property-read int $length
 */
class EANHLSearchHotelIds extends ObjectBase implements IEANHLSearch {
	
	/**
	 * @var int[]
	 */
	protected $hotelIdList;
	
	/**
	 * Pass hotel identifiers as any number of arguments, 
	 * e.g. `new EANHLSearchHotelIds(45,2342,2039,499)`. 
	 */
	public function __construct() {
		$this->hotelIdList = array();
		$args = func_get_args();
		foreach ( $args as $arg ) {
			$this->addHotelId($arg);
		}
	}
	
	protected function get__hotelIdList() {
		return $this->hotelIdList;
	}
	
	protected function get__length() {
		return count($this->hotelIdList);
	}
	
	/**
	 * @param int $id
	 * @return boolean
	 */
	public function addHotelId($id) {
		$id = (int) $id;
		if ( $id > 0 ) {
			array_push($this->hotelIdList,$id);
			$this->hotelIdList = array_unique($this->hotelIdList);
			return true;
		}
		return false;
	}
	
	/**
	 * @param int $id
	 * @return boolean
	 */
	public function removeHotelId($id) {
		$id = (int) $id;
		if ( $id > 0 ) {
			foreach ( $this->hotelIdList as $subjectKey => $subjectId ) {
				if ( $id === (int) $subjectId ) {
					return $this->removeHotelIdByIndex($subjectKey);
				}
			}
		}
		return false;
	}
	
	/**
	 * @param int $i
	 * @return boolean
	 */
	public function removeHotelIdByIndex($i) {
		if ( isset($this->hotelIdList[$i]) ) {
			unset($this->hotelIdList[$i]);
			$this->hotelIdList = array_values($this->hotelIdList);
			return true;
		}
		return false;
	}
	
	/**
	 * Returns a comma-delimited list of hotel identifiers, useful for the API's XML request. 
	 * @return string
	 */
	public function toString() {
		return implode(',',$this->hotelIdList);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Query\HotelListSearch\IEANHLSearch::isValid()
	 */
	public function isValid() {
		return isset($this->hotelIdList)
			&& is_array($this->hotelIdList)
			&& count($this->hotelIdList);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Query\HotelListSearch\IEANHLSearch::renderPreparedArray()
	 */
	public function renderPreparedArray() {
		return array('hotelIdList'=>$this->toString());
	}
	
}
