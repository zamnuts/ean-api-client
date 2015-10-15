<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;

/**
 * @property EANItinerary[] $itineraries
 * @property EANError $error
 */
class EANResponseHotelItinerary extends EANAbstractGroup implements IEANResponse {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelItineraryResponse';
	
	/**
	 * @var string
	 */
	protected static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANItinerary';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var string
	 */
	public $customerSessionId;
	
	/**
	 * @var EANError
	 */
	protected $error;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'customerSessionId' => 'string',
		'itineraries' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANItinerary',
		'error' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANError'
	);
	
	/**
	 * @param EANResponseHotelItinerary $supportModel
	 * @return EANResponseHotelItinerary
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	// Error
	protected function get__error() {
		if ( isset($this->error) ) {
			return clone $this->error;
		}
		return null;
	}
	
	// Itineraries
	/**
	 * @return EANItinerary[]
	 */
	protected function get__itineraries() {
		return $this->items;
	}
	
	/**
	 * @param EANItinerary $itinerary
	 * @return boolean
	 */
	public function addItinerary(EANItinerary $itinerary) {
		return $this->addItem($itinerary);
	}
	
	/**
	 * @param EANItinerary $itinerary
	 * @return boolean
	 */
	public function removeItinerary(EANItinerary $itinerary) {
		return $this->removeItem($itinerary);
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
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractGroup::loadXML()
	 * @param SimpleXMLElement $xml
	 */
	public function loadXML(SimpleXMLElement $xml) {
		parent::loadXML($xml);
	}
	
}
