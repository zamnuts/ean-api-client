<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;

/**
 * @property-read int $length The number of EANLandmarkListSummary in landmarkList.
 * @property-read EANLandmarkListSummaries $landmarkList An array of EANLandmarkListSummary objects.
 * @property-read EANError $error If an error was reported by the API, this will be populated. Make sure to test for it first with isset.
 */
class EANResponseLandmarkList extends EANAbstractSupportModel implements IEANResponse {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'LocationInfoResponse';
	
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
	 * @var EANLandmarkListSummaries
	 */
	protected $landmarkList;
	
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
		'landmarkList' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANLandmarkListSummaries',
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
		$this->landmarkList = array();
	}
	
	protected function get__length() {
		$this->initLandmarkList();
		return count($this->landmarkList->hotels);
	}
	
	protected function get__landmarkList() {
		if ( isset($this->landmarkList) ) {
			return clone $this->landmarkList;
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
		$LandmarkListRoot = EANLandmarkListSummaries::getRootTagName();
		if ( isset($xml->$LandmarkListRoot) ) {
			$attrs = $xml->$LandmarkListRoot->attributes();
			if ( isset($attrs->activePropertyCount) ) {
				$this->activePropertyCount = (int) $attrs->activePropertyCount;
			}
		}
	}
	
	/**
	 * Creates the landmarkList array if it does not exists.
	 * Optionally if it does exist, overwrite it anyway with a blank array.
	 * @param boolean $overwrite True to ovewrite (zero-out the array), false to maintain current state as an array.
	 */
	private function initLandmarkList($overwrite=false) {
		if ( $overwrite || !isset($this->landmarkList) || !($this->landmarkList instanceof EANLandmarkListSummaries) ) {
			$this->landmarkList = new EANLandmarkListSummaries;
		}
	}
}
