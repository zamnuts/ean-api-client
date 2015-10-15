<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;

/**
 * @property-read int $length The number of EANHotelSummary in hotelList.
 * @property-read EANHotelListSummaries $hotelList An array of EANHotelSummary objects. 
 * @property-read EANError $error If an error was reported by the API, this will be populated. Make sure to test for it first with isset.
 */
class EANResponseHotelList extends EANAbstractSupportModel implements IEANResponse {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'ResponseHotelList';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var string
	 */
	public $customerSessionId;
	
	/**
	 * @var int
	 */
	public $numberOfRoomsRequested;
	
	/**
	 * @var boolean
	 */
	public $moreResultsAvailable;

	/**
	 * @var string
	 */
	public $cacheKey;

	/**
	 * @var string
	 */
	public $cacheLocation;
	
	/**
	 * @var EANHotelListSummaries
	 */
	protected $hotelList;
	
	/**
	 * @var int
	 */
	public $activePropertyCount;
	
	/**
	 * @var EANError
	 */
	protected $error;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'customerSessionId' => 'string',
		'numberOfRoomsRequested' => 'int',
		'moreResultsAvailable' => 'boolean',
		'cacheKey' => 'string',
		'cacheLocation' => 'string',
		'hotelList' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANHotelListSummaries',
		'error' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANError'
	);
	
	/**
	 * @param EANResponseHotelList $supportModel
	 * @return EANResponseHotelList
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	public function __construct() {
		$this->hotelList = array();
	}
	
	protected function get__length() {
		$this->initHotelList();
		return count($this->hotelList->hotels);
	}
	
	protected function get__hotelList() {
		if ( isset($this->hotelList) ) {
			return clone $this->hotelList;
		}
		return null;
	}
	
	protected function get__error() {
		if ( isset($this->error) ) {
			return clone $this->error;
		}
		return null;
	}
	
	/**
	 * TODO: get__xml
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractSupportModel::get__xml()
	 */
	protected function get__xml() {
		return $this->xml;
	}
	
	/**
	 * TODO: asXML
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractSupportModel::asXML()
	 */
	public function asXML() {
		return parent::asXML();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractSupportModel::loadXML()
	 * @param SimpleXMLElement $xml
	 */
	public function loadXML(SimpleXMLElement $xml) {
		parent::loadXML($xml);
		$hotelListRoot = EANHotelListSummaries::getRootTagName();
		if ( isset($xml->$hotelListRoot) ) {
			$attrs = $xml->$hotelListRoot->attributes();
			if ( isset($attrs->activePropertyCount) ) {
				$this->activePropertyCount = (int) $attrs->activePropertyCount;
			}
		}
	}
	
	/**
	 * Creates the hoteList array if it does not exists. 
	 * Optionally if it does exist, overwrite it anyway with a blank array.
	 * @param boolean $overwrite True to ovewrite (zero-out the array), false to maintain current state as an array.
	 */
	private function initHotelList($overwrite=false) {
		if ( $overwrite || !isset($this->hotelList) || !($this->hotelList instanceof EANHotelListSummaries) ) {
			$this->hotelList = new EANHotelListSummaries();
		}
	}
}
